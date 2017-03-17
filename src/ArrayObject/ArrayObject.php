<?php
/**
 * Created by PhpStorm.
 * User: Bartosz Bartniczak <kontakt@bartoszbartniczak.pl>
 */

namespace BartoszBartniczak\ArrayObject;


class ArrayObject extends \ArrayObject
{

    /**
     * Iterates over each value in the array passing them to the callback function.
     * If the callback function returns true, the current value from array is returned into the result ArrayObject. Array keys are preserved.
     * @param callable $callback
     * @return ArrayObject
     */
    public function filter(callable $callback): ArrayObject
    {
        $arrayCopy = $this->getArrayCopy();
        $filteredData = array_filter($arrayCopy, $callback);
        return new ArrayObject($filteredData);
    }

    /**
     * Merge two arrays.
     * @param ArrayObject $arrayObject
     */
    public function merge(ArrayObject $arrayObject)
    {
        $arrayCopy = $this->getArrayCopy();
        $arrayToMerge = $arrayObject->getArrayCopy();
        $this->exchangeArray(array_merge($arrayCopy, $arrayToMerge));
    }

    /**
     * Returns the first element, ignoring the type of the keys.
     * @return mixed
     */
    public function first()
    {
        $this->throwExceptionIfEmpty();

        $keys = $this->keys();
        $keyOfTheFirstElement = $keys->shift();
        return $this->offsetGet($keyOfTheFirstElement);
    }

    /**
     * Throws EmptyArrayException in array is empty
     */
    private function throwExceptionIfEmpty(): void
    {
        if ($this->isEmpty()) {
            throw new EmptyArrayException('Array is empty. Cannot return any element.');
        }
    }

    /**
     * Checks if array is empty
     * @return bool
     */
    public function isEmpty(): bool
    {
        return !$this->isNotEmpty();
    }

    /**
     *  Checks if array is not empty
     * @return bool
     */
    public function isNotEmpty(): bool
    {
        return $this->count() > 0;
    }

    /**
     * Returns all the keys of the array.
     * @return ArrayObject
     */
    public function keys(): ArrayObject
    {
        return new ArrayObject(array_keys($this->getArrayCopy()));
    }

    /**
     * Shift an element off the beginning of array
     * @return mixed
     */
    public function shift()
    {
        $this->throwExceptionIfEmpty();

        $arrayCopy = $this->getArrayCopy();
        $firstElement = array_shift($arrayCopy);
        $this->exchangeArray($arrayCopy);
        return $firstElement;
    }

    /**
     * Returns the last element, ignoring the type of the keys.
     * @return mixed
     */
    public function last()
    {
        $this->throwExceptionIfEmpty();

        $keys = $this->keys();
        $keyOfTheLastElement = $keys->pop();
        return $this->offsetGet($keyOfTheLastElement);
    }

    /**
     * Pop the element off the end of array
     * @return mixed
     * @throws EmptyArrayException
     */
    public function pop()
    {
        $this->throwExceptionIfEmpty();

        $arrayCopy = $this->getArrayCopy();
        $lastElement = array_pop($arrayCopy);
        $this->exchangeArray($arrayCopy);
        return $lastElement;
    }
}