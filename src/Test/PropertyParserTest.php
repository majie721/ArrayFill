<?php

namespace Mj\Fills\Test;

use Mj\Fills\Fill\PropertyParser;
use Mj\Fills\Test\TestClass\Order;
use PHPUnit\Framework\TestCase;

Class PropertyParserTest extends TestCase{

    public function testGetProxyPropertyData(){
        $order = new Order();

        $PropertyParser = new PropertyParser($order);

        print_r($PropertyParser->parseProxyPropertyData()->proxyPropertyPoll);
        $this->assertTrue(true);
    }


    public function testFillOrder(){
        $orderData = [
            'id'=>1,
            'order_code'=>'EL2022042001',
            'is_return'=>false,
            'service'=>['T','B'],
            'product'=>[
                [
                    'id'=>1,
                    'sku'=>'apple_01',
                    'title'=>'苹果1',
                    'num'=>1,
                ],
                [
                    'id'=>2,
                    'sku'=>'apple_02',
                    'title'=>'苹果2',
                    'num'=>2,
                ],
                [
                    'id'=>3,
                    'sku'=>'apple_03',
                    'title'=>'苹果3',
                    'num'=>3,
                ]
            ],
            'status'=>2,
            'status_text'=>'未知',
            'address'=>[
                'firstName'=>'jie',
                'lastName'=>'ma',
                'company'=>'哇哈哈',
                'address_1'=>'龙岗贝尔路',
            ]
        ];

        $orderObj = new Order($orderData);
        print_r($orderObj);

        //$this->assertTrue(true);
    }


}