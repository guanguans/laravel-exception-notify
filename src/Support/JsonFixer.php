<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-exception-notify.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelExceptionNotify\Support;

use function is_bool;

/**
 * This file is modified from https://github.com/adhocore/php-json-fixer.
 */
class JsonFixer
{
    /**
     * @var array Current token stack indexed by position
     */
    protected $stack = [];

    /**
     * @var bool If current char is within a string
     */
    protected $inStr = false;

    /**
     * @var bool Whether to throw Exception on failure
     */
    protected $silent = false;

    /**
     * @var array The complementary pairs
     */
    protected $pairs = [
        '{' => '}',
        '[' => ']',
        '"' => '"',
    ];

    /**
     * @var int The last seen object `{` type position
     */
    protected $objectPos = -1;

    /** @var int The last seen array `[` type position */
    protected $arrayPos = -1;

    /**
     * @var string Missing value. (Options: true, false, null)
     */
    protected $missingValue = 'null';

    /**
     * Set/unset silent mode.
     *
     * @return $this
     */
    public function silent(bool $silent = true)
    {
        $this->silent = $silent;

        return $this;
    }

    /**
     * Set missing value.
     *
     * @return $this
     */
    public function missingValue(string $value)
    {
        // if (null === $value) {
        //     $value = 'null';
        // } elseif (is_bool($value)) {
        //     $value = $value ? 'true' : 'false';
        // }

        $this->missingValue = $value;

        return $this;
    }

    /**
     * Fix the truncated JSON.
     *
     * @param string $json the JSON string to fix
     *
     * @return string Fixed JSON. If failed with silent then original JSON.
     *
     * @throws \RuntimeException when fixing fails
     */
    public function fix(string $json)
    {
        [$head, $json, $tail] = $this->trim($json);

        if (empty($json) || $this->isValid($json)) {
            return $json;
        }

        if (null !== $tmpJson = $this->quickFix($json)) {
            return $tmpJson;
        }

        $this->reset();

        return $head.$this->doFix($json).$tail;
    }

    protected function trim($json)
    {
        \preg_match('/^(\s*)([^\s]+)(\s*)$/', $json, $match);

        $match += ['', '', '', ''];
        $match[2] = \trim($json);

        \array_shift($match);

        return $match;
    }

    protected function isValid($json): bool
    {
        /** @psalm-suppress UnusedFunctionCall */
        \json_decode($json);

        return \JSON_ERROR_NONE === \json_last_error();
    }

    protected function quickFix($json)
    {
        if (1 === \strlen($json) && isset($this->pairs[$json])) {
            return $json.$this->pairs[$json];
        }

        if ('"' !== $json[0]) {
            return $this->maybeLiteral($json);
        }

        return $this->padString($json);
    }

    protected function reset()
    {
        $this->stack = [];
        $this->inStr = false;
        $this->objectPos = -1;
        $this->arrayPos = -1;
    }

    protected function maybeLiteral($json)
    {
        if (! \in_array($json[0], ['t', 'f', 'n'])) {
            return null;
        }

        foreach (['true', 'false', 'null'] as $literal) {
            if (0 === \strpos($literal, $json)) {
                return $literal;
            }
        }

        // @codeCoverageIgnoreStart
        return null;
        // @codeCoverageIgnoreEnd
    }

    protected function doFix($json)
    {
        [$index, $char] = [-1, ''];

        while (isset($json[++$index])) {
            [$prev, $char] = [$char, $json[$index]];

            $next = $json[$index + 1] ?? '';

            if (! \in_array($char, [' ', "\n", "\r"])) {
                $this->stack($prev, $char, $index, $next);
            }
        }

        return $this->fixOrFail($json);
    }

    protected function stack($prev, $char, $index, $next)
    {
        if ($this->maybeStr($prev, $char, $index)) {
            return;
        }

        $last = $this->lastToken();

        if (\in_array($last, [',', ':', '"']) && \preg_match('/\"|\d|\{|\[|t|f|n/', $char)) {
            $this->popToken();
        }

        if (\in_array($char, [',', ':', '[', '{'])) {
            $this->stack[$index] = $char;
        }

        $this->updatePos($char, $index);
    }

    protected function lastToken()
    {
        return \end($this->stack);
    }

    /**
     * @noinspection OffsetOperationsInspection
     */
    protected function popToken($token = null)
    {
        // Last one
        if (null === $token) {
            return \array_pop($this->stack);
        }

        $keys = \array_reverse(\array_keys($this->stack));
        foreach ($keys as $key) {
            if ($this->stack[$key] === $token) {
                unset($this->stack[$key]);

                break;
            }
        }
    }

    protected function maybeStr($prev, $char, $index)
    {
        if ('\\' !== $prev && '"' === $char) {
            $this->inStr = ! $this->inStr;
        }

        if ($this->inStr && '"' !== $this->lastToken()) {
            $this->stack[$index] = '"';
        }

        return $this->inStr;
    }

    protected function updatePos($char, int $index)
    {
        if ('{' === $char) {
            $this->objectPos = $index;
        } elseif ('}' === $char) {
            $this->popToken('{');
            $this->objectPos = -1;
        } elseif ('[' === $char) {
            $this->arrayPos = $index;
        } elseif (']' === $char) {
            $this->popToken('[');
            $this->arrayPos = -1;
        }
    }

    protected function fixOrFail($json)
    {
        $length = \strlen($json);
        $tmpJson = $this->pad($json);

        if ($this->isValid($tmpJson)) {
            return $tmpJson;
        }

        if ($this->silent) {
            return $json;
        }

        throw new \RuntimeException(\sprintf('Could not fix JSON (tried padding `%s`)', \substr($tmpJson, $length)));
    }

    /* trait PadsJson */
    public function pad($tmpJson)
    {
        if (! $this->inStr) {
            $tmpJson = \rtrim($tmpJson, ',');
            while (',' === $this->lastToken()) {
                $this->popToken();
            }
        }

        $tmpJson = $this->padLiteral($tmpJson);
        $tmpJson = $this->padObject($tmpJson);

        return $this->padStack($tmpJson);
    }

    protected function padLiteral($tmpJson)
    {
        if ($this->inStr) {
            return $tmpJson;
        }

        $match = \preg_match('/(tr?u?e?|fa?l?s?e?|nu?l?l?)$/', $tmpJson, $matches);

        if (! $match || null === $literal = $this->maybeLiteral($matches[1])) {
            return $tmpJson;
        }

        return \substr($tmpJson, 0, -\strlen($matches[1])).$literal;
    }

    protected function padStack($tmpJson)
    {
        foreach (\array_reverse($this->stack, true) as $token) {
            if (isset($this->pairs[$token])) {
                $tmpJson .= $this->pairs[$token];
            }
        }

        return $tmpJson;
    }

    protected function padObject($tmpJson)
    {
        if (! $this->objectNeedsPadding($tmpJson)) {
            return $tmpJson;
        }

        $part = \substr($tmpJson, $this->objectPos + 1);
        if (\preg_match('/(\s*\"[^"]+\"\s*:\s*[^,]+,?)+$/', $part, $matches)) {
            return $tmpJson;
        }

        if ($this->inStr) {
            $tmpJson .= '"';
        }

        $tmpJson = $this->padIf($tmpJson, ':');
        $tmpJson .= $this->missingValue;

        if ('"' === $this->lastToken()) {
            $this->popToken();
        }

        return $tmpJson;
    }

    protected function objectNeedsPadding($tmpJson): bool
    {
        $last = \substr($tmpJson, -1);
        $empty = '{' === $last && ! $this->inStr;

        return ! $empty && $this->arrayPos < $this->objectPos;
    }

    protected function padString($string)
    {
        $last = \substr($string, -1);
        $last2 = \substr($string, -2);

        if ('\"' === $last2 || '"' !== $last) {
            return $string.'"';
        }

        // @codeCoverageIgnoreStart
        return null;
        // @codeCoverageIgnoreEnd
    }

    protected function padIf($string, $substr)
    {
        if (\substr($string, -\strlen($substr)) !== $substr) {
            return $string.$substr;
        }

        return $string;
    }
}
