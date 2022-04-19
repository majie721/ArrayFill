<?php

namespace Mj\Fills\Test\TestClass;

use JetBrains\PhpStorm\ArrayShape;
use Mj\Fills\Fill\AttributeClass\Doc;
use Mj\Fills\Fill\Proxy;

class Order extends Proxy
{

    #[Doc('订单id')]
    public int $id;

    #[Doc('订单编码')]
    public string $order_code;

    #[Doc('是否退件单')]
    public bool $is_return;

    #[Doc('类型服务')]
    #[ArrayShape(['string'])]
    public array $services;

    #[Doc('商品信息')]
    #[ArrayShape([OrderProduct::class])]
    public array $product;

    #[Doc('状态')]
    public int $status = 1;

    #[Doc('状态文本')]
    public string $status_text = '处理中';

    #[Doc('地址信息')]
    public Address $address;
}