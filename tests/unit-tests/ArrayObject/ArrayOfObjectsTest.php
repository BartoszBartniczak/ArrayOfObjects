<?php
/**
 * Created by PhpStorm.
 * User: Bartosz Bartniczak <kontakt@bartoszbartniczak.pl>
 */

namespace ArrayObject;


class ArrayOfObjectsTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers \ArrayObject\ArrayOfObjects::__construct
     * @covers \ArrayObject\ArrayOfObjects::getClassName
     */
    public function testConstructor()
    {
        $arrayOfObjects = new ArrayOfObjects(\DateTime::class);
        $this->assertInstanceOf(ArrayObject::class, $arrayOfObjects);
        $this->assertEquals(\DateTime::class, $arrayOfObjects->getClassName());

        $arrayOfObjects = new ArrayOfObjects(\DateTime::class, [new \DateTime(), new \DateTime()]);
        $this->assertEquals(2, $arrayOfObjects->count());

        $arrayOfObjects = new ArrayOfObjects(\DateTime::class, [new \DateTime(), new \DateTime()], ArrayObject::ARRAY_AS_PROPS, \EmptyIterator::class);
        $this->assertEquals(ArrayObject::ARRAY_AS_PROPS, $arrayOfObjects->getFlags());
        $this->assertEquals(\EmptyIterator::class, $arrayOfObjects->getIteratorClass());
    }


    /**
     * @covers \ArrayObject\ArrayOfObjects::__construct
     */
    public function testConstructorThrowsExceptionIfAtLeastOneOfTheObjectsIsNotInstanceOfTheClass()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Expected instance of '\DateTime'. '\DateTimeZone' given.");
        new ArrayOfObjects(\DateTime::class, [new \DateTime(), new \DateTime(), new \DateTimeZone('Europe/Warsaw')]);
    }

    /**
     * @covers \ArrayObject\ArrayOfObjects::offsetSet
     */
    public function testOffsetSet()
    {
        $arrayOfObjects = new ArrayOfObjects(\DateTime::class, [new \DateTime(), new \DateTime()]);
        $arrayOfObjects[] = new \DateTime();
        $arrayOfObjects->offsetSet(4, new \DateTime());
        $arrayOfObjects->append(new \DateTime());
        $this->assertEquals(5, $arrayOfObjects->count());
    }

    /**
     * @covers \ArrayObject\ArrayOfObjects::offsetSet
     */
    public function testOffsetSetThrowsExceptionWhenIfTheObjectIsNotInstanceOfTheClass()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Expected instance of '\DateTime'. '\DateTimeZone' given.");
        $arrayOfObjects = new ArrayOfObjects(\DateTime::class, [new \DateTime(), new \DateTime()]);
        $arrayOfObjects->offsetSet(2, new \DateTimeZone('Europe/Warsaw'));
    }

    /**
     * @covers \ArrayObject\ArrayOfObjects::offsetSet
     * @covers \ArrayObject\ArrayOfObjects::append
     */
    public function testAppendThrowsExceptionWhenIfTheObjectIsNotInstanceOfTheClass()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Expected instance of '\DateTime'. '\DateTimeZone' given.");
        $arrayOfObjects = new ArrayOfObjects(\DateTime::class, [new \DateTime(), new \DateTime()]);
        $arrayOfObjects->append(new \DateTimeZone('Europe/Warsaw'));
    }

    /**
     * @covers \ArrayObject\ArrayOfObjects::offsetSet
     */
    public function testNewElementThrowsExceptionWhenIfTheObjectIsNotInstanceOfTheClass()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Expected instance of '\DateTime'. '\DateTimeZone' given.");
        $arrayOfObjects = new ArrayOfObjects(\DateTime::class, [new \DateTime(), new \DateTime()]);
        $arrayOfObjects[] = new \DateTimeZone('Europe/Warsaw');
    }

    /**
     * @covers \ArrayObject\ArrayOfObjects::chunk
     */
    public function testChunk()
    {
        $obj1 = new \DateTime();
        $obj2 = new \DateTime();
        $obj3 = new \DateTime();

        $arrayOfObjects = new ArrayOfObjects(\DateTime::class, [$obj1, $obj2, $obj3]);
        $this->assertEquals(
            new ArrayObject(
                [
                    new ArrayOfObjects(\DateTime::class, [$obj1, $obj2]),
                    new ArrayOfObjects(\DateTime::class, [$obj3])
                ]
            ),
            $arrayOfObjects->chunk(2)
        );
    }

    /**
     * @covers \ArrayObject\ArrayOfObjects::column
     */
    public function testColumnThrowsBadMethodCallException()
    {
        $this->expectException(BadMethodCallException::class);
        $this->expectExceptionMessage('Cannot call method \'column\'. Use map method instead.');

        $arrayOfObjects = new ArrayOfObjects(\DateTime::class);
        $arrayOfObjects->column('firstName');
    }

}
