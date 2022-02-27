<?php

/**
 * This file is part of the guanguans/laravel-exception-notify.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelExceptionNotify\Support\Traits;

trait OptionsProperty
{
    /**
     * @var array
     */
    protected $options = [];

    public function set($name, $value = null)
    {
        $options = is_array($name) ? $name : [$name => $value];

        $this->options = array_merge($this->options, $options);
    }

    public function get($key = null, $default = null)
    {
        if (is_null($key)) {
            return $this->options;
        }

        if (array_key_exists($key, $this->options)) {
            return $this->options[$key];
        }

        return value($default);
    }

    public function offsetExists($offset)
    {
        return isset($this->options[$offset]);
    }

    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    public function offsetSet($offset, $value)
    {
        $this->set($offset, $value);
    }

    public function offsetUnset($offset)
    {
        unset($this->options[$offset]);
    }

    public function __call($method, $parameters)
    {
        $this->options[$method] = count($parameters) > 0 ? $parameters[0] : true;

        return $this;
    }

    public function __get($key)
    {
        return $this->get($key);
    }

    public function __set($key, $value)
    {
        $this->offsetSet($key, $value);
    }

    public function __isset($key)
    {
        return $this->offsetExists($key);
    }

    public function __unset($key)
    {
        $this->offsetUnset($key);
    }
}
