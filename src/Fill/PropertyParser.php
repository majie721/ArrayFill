<?php

namespace Mj\Fills\Fill;

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




    public function fillData(){

    }


    public function getProxyPropertyData(){
        $proxyProperty = $this->proxyPropertyPoll[$this->proxyObjName]?? null;
        if(null===$proxyProperty){
            $reflection = new \ReflectionClass($this->proxyObj);
            $properties =  $reflection->getProperties();
            foreach ($properties as $property){
                if($property->isPublic()){
                    []
                }
            }

        }
    }



}