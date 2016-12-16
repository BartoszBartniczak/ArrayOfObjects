<?php
/**
 * Created by PhpStorm.
 * User: Bartosz Bartniczak <kontakt@bartoszbartniczak.pl>
 */

namespace BartoszBartniczak\ArrayObject;


class ArrayOfObjects extends \ArrayObject
{

    /**
     * @var string
     */
    protected $className;

    /**
     * ArrayOfObjects constructor.
     * @param string $className Name of the class which this array can contain.
     * @param array|null $input
     * @param int $flags
     * @param string $iterator_class
     * @throws InvalidArgumentException
     */
    public function __construct(string $className, array $input = null, $flags = 0, $iterator_class = "ArrayIterator")
    {
        $this->className = $className;
        if (!is_array($input)) {
            $input = [];
        }

        foreach ($input as $object) {
            $this->throwExceptionIfIsNotInstanceOfTheClass($object);
        }

        parent::__construct($input, $flags, $iterator_class);
    }

    /**
     * @param $object
     * @throws InvalidArgumentException
     */
    private function throwExceptionIfIsNotInstanceOfTheClass($object)
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
        $this->throwExceptionIfIsNotInstanceOfTheClass($newval);
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
            $this->throwExceptionIfIsNotInstanceOfTheClass($item);
        }

        parent::exchangeArray($input);
    }


}