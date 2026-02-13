<?php

/** @noinspection PhpClassNamingConventionInspection */

declare(strict_types=1);

/**
 * Copyright (c) 2021-2026 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-exception-notify
 */

namespace Guanguans\LaravelExceptionNotify\Support\Rectors;

use PhpParser\Node;
use PhpParser\Node\Expr\FuncCall;
use Rector\PhpParser\Node\Value\ValueResolver;
use Rector\Rector\AbstractRector;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

/**
 * @internal
 */
final class HydratePipeFuncCallToStaticCallRector extends AbstractRector
{
    public function __construct(private ValueResolver $valueResolver) {}

    /**
     * @throws \Symplify\RuleDocGenerator\Exception\PoorDocumentationException
     */
    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition(
            'Hydrate pipe func call to static call',
            [
                new CodeSample(
                    <<<'CODE_SAMPLE'
                        hydrate_pipe(LimitLengthPipe::class, 4096);
                        CODE_SAMPLE,
                    <<<'CODE_SAMPLE'
                        LimitLengthPipe::class::with(4096);
                        CODE_SAMPLE,
                ),
            ],
        );
    }

    public function getNodeTypes(): array
    {
        return [
            FuncCall::class,
        ];
    }

    /**
     * @param \PhpParser\Node\Expr\FuncCall $node
     */
    public function refactor(Node $node): Node
    {
        if ($this->isName($node, 'Guanguans\LaravelExceptionNotify\Support\hydrate_pipe')) {
            $args = $node->getArgs();

            return $this->nodeFactory->createStaticCall(
                $this->valueResolver->getValue($args[0]),
                'with',
                \array_slice($args, 1)
            );
        }

        return $node;
    }
}
