<?php
/**
 * Created by PhpStorm.
 * User: Bartosz Bartniczak <kontakt@bartoszbartniczak.pl>
 */

namespace BartoszBartniczak\ArrayObject;


use BartoszBartniczak\ArrayObject\KeyNamingStrategy\ClosureStrategy;
use BartoszBartniczak\ArrayObject\KeyNamingStrategy\StandardStrategy;
use BartoszBartniczak\ArrayObject\KeyNamingStrategy\ValueAsKeyStrategy;

class ArrayOfObjectsTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers \BartoszBartniczak\ArrayObject\ArrayOfObjects::__construct
     * @covers \BartoszBartniczak\ArrayObject\ArrayOfObjects::getClassName
     */
    public function testConstructor()
    {
        $arrayOfObjects = new ArrayOfObjects(\DateTime::class);
        $this->assertInstanceOf(ArrayObject::class, $arrayOfObjects);
        $this->assertEquals(\DateTime::class, $arrayOfObjects->getClassName());
        $this->assertInstanceOf(StandardStrategy::class, $arrayOfObjects->getKeyNamingStrategy());

        $arrayOfObjects = new ArrayOfObjects(\DateTime::class, [new \DateTime(), new \DateTime()]);
        $this->assertEquals(2, $arrayOfObjects->count());

        $arrayOfObjects = new ArrayOfObjects(\DateTime::class, [new \DateTime(), new \DateTime()], \ArrayObject::ARRAY_AS_PROPS, \EmptyIterator::class);
        $this->assertEquals(\ArrayObject::ARRAY_AS_PROPS, $arrayOfObjects->getFlags());
        $this->assertEquals(\EmptyIterator::class, $arrayOfObjects->getIteratorClass());

        $valueAsKeyStrategy = new ValueAsKeyStrategy();
        $arrayOfObjects = new ArrayOfObjects(\DateTime::class, [], ArrayOfObjects::DEFAULT_FLAGS, ArrayOfObjects::DEFAULT_ITERATOR_CLASS, $valueAsKeyStrategy);
        $this->assertSame($valueAsKeyStrategy, $arrayOfObjects->getKeyNamingStrategy());
    }


    /**
     * @covers \BartoszBartniczak\ArrayObject\ArrayOfObjects::__construct
     * @covers \BartoszBartniczak\ArrayObject\ArrayOfObjects::throwExceptionIfObjectIsNotInstanceOfTheClass
     */
    public function testConstructorThrowsExceptionIfAtLeastOneOfTheObjectsIsNotInstanceOfTheClass()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Expected instance of '\DateTime'. '\DateTimeZone' given.");
        new ArrayOfObjects(\DateTime::class, [new \DateTime(), new \DateTime(), new \DateTimeZone('Europe/Warsaw')]);
    }

    /**
     * @covers \BartoszBartniczak\ArrayObject\ArrayOfObjects::offsetSet
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
     * @covers \BartoszBartniczak\ArrayObject\ArrayOfObjects::offsetSet
     */
    public function testOffsetSetUsesKeyNamingStategy()
    {
        $closureStrategy = new ClosureStrategy(function ($key, \DateTime $dateTime) {
            return $dateTime->format('Y-m-d');
        });

        $dateTime1 = new \DateTime('2017-03-16');
        $dateTime2 = new \DateTime('2017-03-17');

        $arrayOfObjects = new ArrayOfObjects(\DateTime::class, [], ArrayOfObjects::DEFAULT_FLAGS, ArrayOfObjects::DEFAULT_ITERATOR_CLASS, $closureStrategy);
        $arrayOfObjects[] = $dateTime1;
        $arrayOfObjects[] = $dateTime2;

        $this->assertSame($dateTime1, $arrayOfObjects->offsetGet('2017-03-16'));
        $this->assertSame($dateTime2, $arrayOfObjects->offsetGet('2017-03-17'));

    }

    /**
     * @covers \BartoszBartniczak\ArrayObject\ArrayOfObjects::offsetSet
     * @covers \BartoszBartniczak\ArrayObject\ArrayOfObjects::throwExceptionIfObjectIsNotInstanceOfTheClass
     */
    public function testOffsetSetThrowsExceptionWhenIfTheObjectIsNotInstanceOfTheClass()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Expected instance of '\DateTime'. '\DateTimeZone' given.");
        $arrayOfObjects = new ArrayOfObjects(\DateTime::class, [new \DateTime(), new \DateTime()]);
        $arrayOfObjects->offsetSet(2, new \DateTimeZone('Europe/Warsaw'));
    }

    /**
     * @covers \BartoszBartniczak\ArrayObject\ArrayOfObjects::offsetSet
     * @covers \BartoszBartniczak\ArrayObject\ArrayOfObjects::append
     * @covers \BartoszBartniczak\ArrayObject\ArrayOfObjects::throwExceptionIfObjectIsNotInstanceOfTheClass
     */
    public function testAppendThrowsExceptionWhenIfTheObjectIsNotInstanceOfTheClass()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Expected instance of '\DateTime'. '\DateTimeZone' given.");
        $arrayOfObjects = new ArrayOfObjects(\DateTime::class, [new \DateTime(), new \DateTime()]);
        $arrayOfObjects->append(new \DateTimeZone('Europe/Warsaw'));
    }

    /**
     * @covers \BartoszBartniczak\ArrayObject\ArrayOfObjects::offsetSet
     * @covers \BartoszBartniczak\ArrayObject\ArrayOfObjects::throwExceptionIfObjectIsNotInstanceOfTheClass
     */
    public function testNewElementThrowsExceptionWhenIfTheObjectIsNotInstanceOfTheClass()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Expected instance of '\DateTime'. '\DateTimeZone' given.");
        $arrayOfObjects = new ArrayOfObjects(\DateTime::class, [new \DateTime(), new \DateTime()]);
        $arrayOfObjects[] = new \DateTimeZone('Europe/Warsaw');
    }

    /**
     * @covers \BartoszBartniczak\ArrayObject\ArrayOfObjects::exchangeArray
     */
    public function testExchangeArray()
    {
        $arrayOfObjects = new ArrayOfObjects(\DateTime::class, [new \DateTime(), new \DateTime()]);
        $arrayOfObjects->exchangeArray([new \DateTime()]);
    }

    /**
     * @covers \BartoszBartniczak\ArrayObject\ArrayOfObjects::exchangeArray
     */
    public function testExchangeArrayThrowsInvalidArgumentException()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Expected instance of '\DateTime'. '\DateTimeZone' given.");

        $arrayOfObjects = new ArrayOfObjects(\DateTime::class, [new \DateTime(), new \DateTime()]);
        $arrayOfObjects->exchangeArray([new \DateTimeZone('Europe/Warsaw')]);
    }


    /**
     * @covers \BartoszBartniczak\ArrayObject\ArrayOfObjects::merge
     * @covers \BartoszBartniczak\ArrayObject\ArrayOfObjects::throwExceptionIfObjectIsNotInstanceOfTheClass
     */
    public function testMergeThrowsInvalidArgumentExceptionIfTheObjectAreNotInstanceOfTheClass()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Expected instance of '\DateTime'. '\DateTimeZone' given.");

        $arrayOfObjectsFirst = new ArrayOfObjects(\DateTime::class, [new \DateTime()]);
        $arrayOfObjectsSecond = new ArrayOfObjects(\DateTimeZone::class, [new \DateTimeZone('Europe/Warsaw')]);
        $arrayOfObjectsFirst->merge($arrayOfObjectsSecond);
    }

}
