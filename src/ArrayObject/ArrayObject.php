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
     * Shift an element off the beginning of array
     * @return mixed
     */
    public function shift()
    {
        $arrayCopy = $this->getArrayCopy();
        $firstElement = array_shift($arrayCopy);
        $this->exchangeArray($arrayCopy);
        return $firstElement;
    }

    /**
     * Pop the element off the end of array
     * @return mixed
     */
    public function pop()
    {
        $arrayCopy = $this->getArrayCopy();
        $lastElement = array_pop($arrayCopy);
        $this->exchangeArray($arrayCopy);
        return $lastElement;
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
     * Merge two arrays.
     * @param ArrayObject $arrayObject
     */
    public function merge(ArrayObject $arrayObject)
    {
        $arrayCopy = $this->getArrayCopy();
        $arrayToMerge = $arrayObject->getArrayCopy();
        $this->exchangeArray(array_merge($arrayCopy, $arrayToMerge));
    }

}