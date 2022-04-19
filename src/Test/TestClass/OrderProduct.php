<?php

namespace Mj\Fills\Test\TestClass;

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
    public string $num;
}