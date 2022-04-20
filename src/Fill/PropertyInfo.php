<?php

namespace Mj\Fills\Fill;

use JetBrains\PhpStorm\ArrayShape;

class PropertyInfo
{
    /** @var bool 是否有默认值 */
    public bool $hasDefaultValue;

    /** @var mixed 默认值 */
    public mixed $defaultValue;

    /** @var string 属性类型 */
    public string $typeName;

    /** @var bool 是否可空 */
    public bool $allowsNull;

    /** @var string  */
    public mixed $arrayType;

    /** @var bool 是否标量类型: int,string,bool,float,int[],string[],bool[],float[]*/
    public bool $isBuiltin;

    /** @var ?string 文档注释 */
    public ?string $doc;

    /** @var ?string 枚举值 */
    public ?string $enum;

    /** @var array 装饰器函数 */
    #[ArrayShape([[
        'callback'=>'mixed',
        'args'=>'mixed'
    ]])]
    public array $decorators;
}