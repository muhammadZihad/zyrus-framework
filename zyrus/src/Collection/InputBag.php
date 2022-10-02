<?php

namespace Zyrus\Collection;

use ArrayAccess;
use ArrayIterator;
use IteratorAggregate;

class InputBag implements ArrayAccess, IteratorAggregate
{

    /**
     * Stores data in array
     */
    private $data = [];


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
     * @return App\Lib\MiniCollection
     */
    public function merge($hayStack = null)
    {
        if (is_array($hayStack)) {
            $this->data = array_merge($this->data, $hayStack);
            return $this;
        }
        throw new \Exception(sprintf("Parameter {%s} array expected and %s given.", '$hayStack', gettype($hayStack)));
    }


    /**
     * Set element to the data associated with the key
     * @param string $key Array key
     * @return mixed
     */
    public function __set($key, $value)
    {
        if (is_null($key)) {
            $this->data[] = $value;
        } else {
            $this->data[$key] = $value;
        }
    }


    /**
     * Get element from the data by key
     * @param string $key Array key
     * @return mixed
     */
    public function __get($key)
    {
        if (isset($this->data[$key])) {
            return $this->data[$key];
        }
        return null;
    }


    /**
     * Check if a key is available in the data
     * @param string $name key of the element
     * @return bool
     */
    public function __isset($name)
    {
        return isset($this->data[$name]);
    }


    /**
     * Unset element form array
     * @param string $name key of the element
     * @return void
     */
    public function __unset($name)
    {
        if (isset($this->data[$name])) {
            unset($this->data[$name]);
        }
    }


    /**
     * Set element to the data associated with the key
     * @param string $key Array key
     * @param string $value Array value
     * @return void
     */
    public function offsetSet($key, $value): void
    {
        $this->__set($key, $value);
    }


    /**
     * Check if a key is available in the data
     * @param mixed  $name key of the element
     * @return bool
     */
    public function offsetExists($name): bool
    {
        return isset($this->data[$name]);
    }


    /**
     * Unset element from data array
     * @param string $name key of the element
     * @return void
     */
    public function offsetUnset($name): void
    {
        $this->__unset($name);
    }


    /**
     * Get element from the data by key
     * @param string $key Array key
     * @return mixed
     */
    public function offsetGet($key): mixed
    {
        return $this->__get($key);
    }


    /**
     * Make the object iterable
     * @return array
     */
    public function toArray(): array
    {
        return $this->data ?? [];
    }


    /**
     * Let the data iterate through iterator functions
     * @throws \Exception
     * @return ArrayIterator
     */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->data);
    }
}