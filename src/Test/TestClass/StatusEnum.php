<?php

namespace Mj\Fills\Test\TestClass;


use Mj\Fills\Fill\Interface\BaseEnum;
use Mj\Fills\Fill\Traits\EnumArrayAccessTrait;
use Mj\Fills\Fill\Traits\EnumTrait;

enum StatusEnum:int implements BaseEnum, \ArrayAccess
{
    use EnumTrait, EnumArrayAccessTrait;

    case DRAFT=1;

    case PROCESSING=2;

    case COMPLETE=3;

    public function label(): string
    {
        return match($this) {
            self::DRAFT => '草稿',
            self::PROCESSING => '处理中',
            self::COMPLETE => '已完成',
        };
    }
}