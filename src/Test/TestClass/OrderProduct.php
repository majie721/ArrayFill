<?php

namespace Mj\Fills\Test\TestClass;

use Mj\Fills\Fill\AttributeClass\Decorator;
use Mj\Fills\Fill\AttributeClass\Doc;
use Mj\Fills\Fill\Proxy;

class OrderProduct extends Proxy
{
    #[Doc('商品id')]
    public int $id;

    #[Doc('sku')]
    public string $sku;

    #[Doc('商品名称')]
    public string $title;

    #[Doc('数量')]
    #[Decorator('pow',2)]
    #[Decorator('pow',2)]
   // #[Decorator('sqrt')]
    public string $num;

    #[Doc('创建时间')]
    #[Decorator('strtotime')]
    //#[Decorator('date','H:i:s Y-m-d')]
    public string $created_at;

}