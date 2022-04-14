<?php declare(strict_types=1);


namespace Mj\Fills\Fill;

class Proxy
{
    /**
     * @var array|object 原始数组
     */
    private array|object $_original;

    public function __construct(array|object $data)
    {
        $this->setOriginalData($data)
            ->validateAction()
            ->doTranslate()
            ->beforeFillAction()
            ->fillAction()
            ->afterFillAction();

    }


    protected function transform(){

    }

    protected function beforeFill(){

    }

    protected function afterFill(){

    }

    /**
     * @param array $data
     * @return $this
     */
    private function setOriginalData(array $data): self
    {
        $this->_original = $data;
        return $this;
    }


    /**
     * @return array 获取原始数据
     */
    public function getOriginalData():array{
        return $this->_original;
    }


    private function validateAction(){
        return $this;
    }

    /**
     * @return Proxy
     */
    private function doTranslate(): Proxy
    {
        $this->transform();
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
}