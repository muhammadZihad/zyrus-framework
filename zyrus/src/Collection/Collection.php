<?php

namespace Zyrus\Collection;

class Collection
{

    /**
     * Stores items in array
     */
    private $items = [];


    /**
     * Constructor of the class
     * @param array $hayStack Default []
     */
    public function __construct($hayStack = [])
    {
        $this->merge($hayStack);
    }


    /**
     * Merge data with the given array
     * @param array|null $hayStack
     * @throws \Exception
     * @return self
     */
    public function merge($hayStack = null)
    {
        if (is_array($hayStack)) {
            $this->data = array_merge($this->data, $hayStack);
            return $this;
        }
        throw new \Exception(sprintf("Parameter {%s} array expected and %s given.", '$hayStack', gettype($hayStack)));
    }
}