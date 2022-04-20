<?php

namespace Mj\Fills\Fill;

use JetBrains\PhpStorm\ArrayShape;
use Mj\Fills\Fill\AttributeClass\Decorator;
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
            if($attribute->isRepeated()){
                $list[$name][] = [
                    'name' => $name,
                    'arguments'=>$attribute->getArguments()
                ];
            }else{
                $list[$name] = [
                    'name' => $name,
                    'arguments'=>$attribute->getArguments()
                ];
            }

        }
        $this->attributesData =  $list;
        return $this;
    }

    /**
     * 解析数组类型的注解
     * @return mixed|string
     */
    public function getArrayType(){
        $data =  $this->attributesData[ArrayShape::class]??'';
        if($data){
            return $data['arguments'][0][0]??''; //todo 待优化
        }

        return '';
    }

    /**
     * 解析文档注释注解
     * @return mixed|string|void
     */
    public function getDoc(){
        $data =  $this->attributesData[Doc::class]??'';
        if($data){
            return $data['arguments'][0]; //todo 待优化
        }
    }

    /**
     *
     * @return void
     */
    #[ArrayShape([[
        'callback'=>'mixed',
        'args'=>'mixed'
    ]])]
    public function getDecorators(){
        $result = [];
        $data = $this->attributesData[Decorator::class]??[];
        if(!empty($data)){
            foreach ($data as $item){
                $result[] = [
                    'callback'=>array_shift($item['arguments']),
                    'args'=>$item['arguments']
                ];
            }
        }

       return $result;
    }



}