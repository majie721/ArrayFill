<?php

namespace Mj\Fills\Fill;

use JetBrains\PhpStorm\ArrayShape;
use Mj\Fills\Fill\AttributeClass\Doc;

class AttributeParser
{

    protected array $attributesData = [];

    public function __construct(public \ReflectionProperty $property){
        $this->parseAttributes();
    }


    /**
     * @return $this
     */
    protected function parseAttributes(){
        $list = [];
        $attributes = $this->property->getAttributes();
        foreach ($attributes as $attribute){
            $name = $attribute->getName();
            $list[$name] = [
                'name' => $name,
                'arguments'=>$attribute->getArguments()
            ];
        }
        $this->attributesData =  $list;
        return $this;
    }


    public function getArrayType(){
        $data =  $this->attributesData[ArrayShape::class]??'';
        if($data){
            return $data['arguments'][0][0]??''; //todo 待优化
        }

        return '';
    }

    public function getDoc(){
        $data =  $this->attributesData[Doc::class]??'';
        if($data){
            return $data['arguments'][0]; //todo 待优化
        }
    }



}