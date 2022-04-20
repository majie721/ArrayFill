<?php

namespace Mj\Fills\Fill;

use JetBrains\PhpStorm\ArrayShape;
use Mj\Fills\Fill\Exceptions\DocumentPropertyError;
use Mj\Fills\Fill\Exceptions\ExceptionConstCode;

class PropertyParser
{

    /** @var Proxy */
    public Proxy $proxyObj;

    /** @var string 实例化的类名 */
    public string $proxyObjName;

    /** @var array 解析对象信息 */
    public  array $proxyPropertyPoll;

    public function __construct(Proxy $proxy)
    {
        $this->proxyObj = $proxy;
        $this->proxyObjName = get_class($proxy);
    }


    /**
     * @return void
     * @throws DocumentPropertyError
     * @throws \JsonException
     */
    public function fillData(): void
    {
        $originalData = $this->proxyObj->getOriginalData();
        if(null === $originalData){
            return;
        }

        if(is_object($originalData)){
            $waitFillData = json_decode(json_encode($originalData, JSON_THROW_ON_ERROR), true, 512, JSON_THROW_ON_ERROR);
        }else{
            $waitFillData = $originalData;
        }

        $propertiesInfo =  $this->getProxyPropertyData();
        foreach ($waitFillData as $propertyName => $propertyValue){
            $propertyData = $propertiesInfo[$propertyName]??null;
            if($propertyData){
                if($propertyData->isBuiltin){ //标量直接赋值
                    $this->setPropertyValue($propertyName,$propertyValue);
                }else{
                    if($propertyData->arrayType){ //对象数组
                        if(!is_array($propertyValue) && !$propertyData->allowsNull){
                            throw new \TypeError(sprintf("Cannot assign error type to property %s::$%s",$propertyData->arrayType,$propertyName));
                        }

                       $arrayValues = [];
                       foreach ($propertyValue as $item){
                           $arrayValues[] = $this->recursionFill($propertyData->arrayType,$item);//递归填充数据
                       }
                       $this->setPropertyValue($propertyName,$arrayValues);

                    }else{ //对象
                        if(null === $propertyValue){
                            $this->setPropertyValue($propertyName,$propertyValue);
                        }else{
                             $instance = $this->recursionFill($propertyData->typeName,$propertyValue);//递归填充数据
                             $this->setPropertyValue($propertyName,$instance);
                        }
                    }
                }
            }
        }
    }

    /**
     * @param bool $parseDoc
     * @return $this
     * @throws DocumentPropertyError
     */
    public function parseProxyPropertyData(bool $parseDoc=false): self
    {
        $proxyProperty = $this->proxyPropertyPoll[$this->proxyObjName]?? null;
        if(null===$proxyProperty){
            $reflection = new \ReflectionClass($this->proxyObj);
            $properties =  $reflection->getProperties();
            foreach ($properties as $property){
                if($property->isPublic()){

                    $propertyName = $property->getName();

                    $reflectionType =  $property->getType();
                    $this->verifyReflectionNamedType($propertyName,$reflectionType);

                    $propertyInfo = new PropertyInfo();
                    $attributeParser = new AttributeParser($property);
                    $propertyInfo->hasDefaultValue = $property->hasDefaultValue();
                    $propertyInfo->defaultValue = $property->getDefaultValue();
                    $propertyInfo->allowsNull = $reflectionType->allowsNull();
                    $propertyInfo->typeName = $reflectionType->getName();
                    $propertyInfo->arrayType = $attributeParser->getArrayType();
                    $propertyInfo->isBuiltin = $reflectionType->isBuiltin() && in_array($propertyInfo->arrayType,['','int','string','float','bool','int[]','string[]','float[]','bool[]'],true);
                    $parseDoc && $propertyInfo->doc = $attributeParser->getDoc();
                    $propertyInfo->decorators = $attributeParser->getDecorators();

                    $this->proxyPropertyPoll[$this->proxyObjName][$propertyName] = $propertyInfo;
                }
            }
        }

        return $this;
    }


    /**
     *
     * @return array 对象的属性信息
     * @throws DocumentPropertyError
     */
    #[ArrayShape(['Key'=>PropertyInfo::class])]
    public function getProxyPropertyData():array{
        $this->parseProxyPropertyData();
        return $this->proxyPropertyPoll[$this->proxyObjName];
    }


    /**
     * 类的属性类型必须注明,并且只能是ReflectionNamedType,不能是联合类型和交叉类型
     * @param string $propertyName
     * @param \ReflectionType|null $property
     * @return void
     * @throws DocumentPropertyError
     */
    private function verifyReflectionNamedType(string $propertyName, ?\ReflectionType $property = null): void
    {

        if($property instanceof \ReflectionNamedType){
            return;
        }

        if($property === null){
            $message = sprintf("The %s property type of the object[ %s ]  cannot be empty.",$propertyName,$this->proxyObjName);
            throw new DocumentPropertyError($message,ExceptionConstCode::PROPERTY_TYPE_IS_NULL);
        }

        if($property instanceof \ReflectionUnionType){
            $message = sprintf("The %s property type of the object[ %s ] cannot be union type.",$propertyName,$this->proxyObjName);
            throw new DocumentPropertyError($message,ExceptionConstCode::PROPERTY_TYPE_IS_UNION_TYPE);
        }

//        if($property instanceof \ReflectionIntersectionType){
//            $message = sprintf("The %s property type of the %s object cannot be intersection type.",$propertyName,$this->proxyObjName);
//            throw new DocumentPropertyError($message,ExceptionConstCode::PROPERTY_TYPE_IS_INTERSECTION_TYPE);
//        }

        $message = sprintf("The %s property type of the object[ %s ] cannot be unknown type.",$propertyName,$this->proxyObjName);
        throw new DocumentPropertyError($message,ExceptionConstCode::PROPERTY_TYPE_IS_UNKNOWN_TYPE);
    }

    /**
     * 设置对象的属性值
     * @param string $property
     * @param mixed $value
     * @return void
     */
    private function setPropertyValue(string $property, mixed $value){
        $this->proxyObj->{$property} = $value;
    }

    /**
     * 递归fill data
     * @param $className
     * @param $data
     * @return mixed
     */
    private function recursionFill($className,$data): mixed
    {
            return new $className($data);
    }


}