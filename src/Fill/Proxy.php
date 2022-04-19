<?php declare(strict_types=1);


namespace Mj\Fills\Fill;

class Proxy
{
    /** @var array|object|null  */
    private array|object|null $_original;

    public function __construct(array|object|null $data=null)
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