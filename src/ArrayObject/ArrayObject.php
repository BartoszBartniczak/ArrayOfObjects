<?php
/**
 * Created by PhpStorm.
 * User: Bartosz Bartniczak <kontakt@bartoszbartniczak.pl>
 */

namespace ArrayObject;


class ArrayObject extends \ArrayObject
{

    /**
     * Changes the case of all keys in an ArrayObject
     * @param int $case
     */
    public function changeKeyCase(int $case)
    {
        $this->exchangeArray(array_change_key_case($this->getArrayCopy(), $case));
    }

    /**
     * @param int $size
     * @param bool $preserveKeys
     * @return ArrayObject
     */
    public function chunk(int $size, bool $preserveKeys = false): ArrayObject
    {
        $arrays = array_chunk($this->getArrayCopy(), $size, $preserveKeys);
        $arrays = $this->changeArrayOfArraysIntoArrayOfObjects($arrays);
        return new ArrayObject($arrays);
    }

    /**
     * @param array $arrayOfArrays
     * @return array
     */
    protected function changeArrayOfArraysIntoArrayOfObjects(array $arrayOfArrays): array
    {
        foreach ($arrayOfArrays as $key => $array) {
            $arrayOfArrays[$key] = new ArrayObject($array);
        }
        return $arrayOfArrays;
    }

    /**
     * Return the values from a single column in the input array
     * @param $columnName mixed The column of values to return.
     * @param $indexKey mixed The column to use as the index/keys for the returned array.
     * @return ArrayObject
     */
    public function column($columnName, $indexKey = null): ArrayObject
    {
        $arrayColumn = [];

        foreach ($this as $value) {
            if (!isset($value[$columnName])) {
                throw new InvalidArgumentException(sprintf("Column '%s' is not defined.", $columnName));
            }

            if (empty($indexKey) && $indexKey !== 0) {
                $arrayColumn[] = $value[$columnName];
            } else {
                if (!isset($value[$indexKey])) {
                    throw new InvalidArgumentException(sprintf("Index column '%s' is not defined.", $indexKey));
                }
                $arrayColumn[$value[$indexKey]] = $value[$columnName];
            }
        }

        return new ArrayObject($arrayColumn);
    }

    /**
     * Returns all the keys.
     * @return ArrayObject
     */
    public function keys(): ArrayObject
    {
        return new ArrayObject(array_keys($this->getArrayCopy()));
    }

}