<?php
/**
 * Created by PhpStorm.
 * User: Bartosz Bartniczak <kontakt@bartoszbartniczak.pl>
 */

namespace BartoszBartniczak\ArrayObject;


use BartoszBartniczak\ArrayObject\KeyNamingStrategy\KeyNamingStrategy;
use BartoszBartniczak\ArrayObject\KeyNamingStrategy\StandardStrategy;

class ArrayOfObjects extends ArrayObject
{

    /**
     * @var string
     */
    protected $className;

    /**
     * ArrayOfObjects constructor.
     * @param string $className Name of the class which this array can contain.
     * @param array $input
     * @param int $flags
     * @param string $iterator_class
     * @param KeyNamingStrategy $keyNamingStrategy
     */
    public function __construct(string $className, array $input = [], int $flags = self::DEFAULT_FLAGS, string $iterator_class = self::DEFAULT_ITERATOR_CLASS, KeyNamingStrategy $keyNamingStrategy = null)
    {
        $this->className = $className;

        foreach ($input as $object) {
            $this->throwExceptionIfObjectIsNotInstanceOfTheClass($object);
        }

        if (!$keyNamingStrategy instanceof KeyNamingStrategy) {
            $keyNamingStrategy = new StandardStrategy();
        }

        parent::__construct($input, $flags, $iterator_class, $keyNamingStrategy);
    }

    /**
     * @param $object
     * @throws InvalidArgumentException
     */
    protected function throwExceptionIfObjectIsNotInstanceOfTheClass($object)
    {
        if (!$object instanceof $this->className) {
            throw new InvalidArgumentException(
                sprintf("Expected instance of '\%s'. '\%s' given.",
                    $this->getClassName(),
                    get_class($object)
                )
            );
        }
    }

    /**
     * Returns the name of the class which this array can contain.
     * @return string
     */
    public function getClassName(): string
    {
        return $this->className;
    }

    /**
     * @param mixed $index
     * @param mixed $newval
     * @throws InvalidArgumentException
     */
    public function offsetSet($index, $newval)
    {
        $this->throwExceptionIfObjectIsNotInstanceOfTheClass($newval);
        parent::offsetSet($index, $newval);
    }

    /**
     * Exchange the array for another one.
     * @param mixed $input
     * @return void
     * @throws InvalidArgumentException
     */
    public function exchangeArray($input)
    {
        foreach ($input as $item) {
            $this->throwExceptionIfObjectIsNotInstanceOfTheClass($item);
        }

        parent::exchangeArray($input);
    }

}