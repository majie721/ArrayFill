<?php declare(strict_types=1);


namespace Mj\Fills\Fill;

use JetBrains\PhpStorm\ArrayShape;
use Mj\Fills\Fill\Traits\ArrayAccessTrait;

class Proxy implements \ArrayAccess
{

    use ArrayAccessTrait;

    /** @var array|object|null  */
    private array|object|null $_original;


    public function __construct(array|object|null $data=null)
    {
        $this->setOriginalData($data)
            ->validateAction()
            ->beforeFillAction()
            ->fillAction()
            ->afterFillAction();
    }




    protected function beforeFill(){

    }

    protected function afterFill(){

    }

    /**
     * @param array|object|null $data
     * @return $this
     */
    private function setOriginalData(array|object|null $data): self
    {
        $this->_original = $data;
        return $this;
    }


    /**
     * @return array|object|null 获取原始数据
     */
    public function getOriginalData():array|object|null{
        return $this->_original;
    }


    private function validateAction(){
        return $this;
    }


    /**
     * @return Proxy
     */
    private function beforeFillAction(): Proxy
    {
        $this->beforeFill();
        return $this;
    }

    /**
     * @return Proxy
     */
    private function fillAction(): Proxy
    {
        $parser =  new PropertyParser($this);
        $parser->fillData();
        return $this;
    }

    /**
     * @return Proxy
     */
    private function afterFillAction(): Proxy
    {
        $this->afterFill();
        return $this;
    }

    /**
     * 将数组转换成对象的方法
     * @param mixed $data
     * @return static
     */
    public static function fromItem(mixed $data): static
    {
        return new static($data);
    }

    /**
     * 将数组列表转换成对象的方法
     * @param array $list
     * @return static[]
     */
    public static function fromList(array $list):array{
        $data = [];
        foreach ($list as $item){
            $data[] = new static($item);
        }
        return $data;
    }

    /**
     * 获取属性信息
     * @return array
     * @throws Exceptions\DocumentPropertyError
     */
    #[ArrayShape(['Key'=>PropertyInfo::class])]
    public static function getPropertiesInfo(): array
    {

        $parser =  new PropertyParser(null);
        return $parser->getProxyPropertyData(static::class);
    }

    /**
     * 获取属性列表
     * @return string[]
     * @throws Exceptions\DocumentPropertyError
     */
    public static function getProperties():array{
        $data =  self::getPropertiesInfo();
        return array_keys($data);
    }

    /**
     * @return array
     * @throws \JsonException
     */
    public function toArray():array{
        return (array)json_decode(json_encode($this, JSON_THROW_ON_ERROR), true, 512, JSON_THROW_ON_ERROR);
    }


    /**
     * @return string
     * @throws \JsonException
     */
    public function toJson(): string
    {
        return json_encode($this, JSON_THROW_ON_ERROR);
    }


}