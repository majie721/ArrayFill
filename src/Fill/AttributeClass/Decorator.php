<?php

namespace Mj\Fills\Fill\AttributeClass;

#[\Attribute(\Attribute::IS_REPEATABLE|\Attribute::TARGET_PROPERTY)]
class Decorator
{

    private mixed $callback;

    private mixed $args;

    /**
     * @param callable $func 回调函数
     * @param ...$args 回调函数的参数
     */
    public function __construct(callable $callback,...$args)
    {
        $this->callback = $callback;
        $this->args = $args;
    }

    public function call(){
        return call_user_func($this->callback,...$this->args);
    }
}