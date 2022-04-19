<?php

namespace Mj\Fills\Test;

use Mj\Fills\Fill\PropertyParser;
use Mj\Fills\Test\TestClass\Order;
use PHPUnit\Framework\TestCase;

Class PropertyParserTest extends TestCase{

    public function testGetProxyPropertyData(){
        $order = new Order();

        $PropertyParser = new PropertyParser($order);

        var_dump($PropertyParser->parseProxyPropertyData()->proxyPropertyPoll);
    }


    public function testData(){
        var_dump( is_object(null));
    }


    public function val(){
        return null;
    }

}