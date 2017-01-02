<?php
/**
 * Created by PhpStorm.
 * User: Bartosz Bartniczak <kontakt@bartoszbartniczak.pl>
 */

namespace BartoszBartniczak\ArrayObject;


class ArrayObjectTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers \BartoszBartniczak\ArrayObject\ArrayObject::__construct
     */
    public function testConstructor()
    {
        $this->assertInstanceOf(\ArrayObject::class, new ArrayObject());

        $arrayObject = new ArrayObject([1, 2, 3]);
        $this->assertEquals(3, $arrayObject->count());
    }

    /**
     * @covers \BartoszBartniczak\ArrayObject\ArrayObject::shift
     */
    public function testShift()
    {
        $arrayObject = new ArrayObject([1, 2, 3]);
        $this->assertEquals(1, $arrayObject->shift());
        $this->assertEquals(2, $arrayObject->shift());
        $this->assertEquals(3, $arrayObject->shift());
    }

    /**
     * @covers \BartoszBartniczak\ArrayObject\ArrayObject::filter
     */
    public function testFilter()
    {
        $arrayObject = new ArrayObject([1, 2, 3]);
        $filteredData = $arrayObject->filter(function ($element) {
            return $element >= 2;
        });
        $this->assertEquals(2, $filteredData->count());
        $this->assertNotSame($arrayObject, $filteredData);
    }

    /**
     * @covers \BartoszBartniczak\ArrayObject\ArrayObject::pop
     */
    public function testPop()
    {
        $arrayObject = new ArrayObject([1, 2, 3]);
        $this->assertSame(3, $arrayObject->pop());
        $this->assertSame(2, $arrayObject->pop());
        $this->assertSame(1, $arrayObject->pop());
    }

    /**
     * @covers \BartoszBartniczak\ArrayObject\ArrayObject::isNotEmpty
     */
    public function testIsNotEmpty()
    {
        $arrayOfObjects = new ArrayObject();
        $this->assertFalse($arrayOfObjects->isNotEmpty());

        $arrayOfObjects->append(new \DateTime());
        $this->assertTrue($arrayOfObjects->isNotEmpty());
    }

    /**
     * @covers \BartoszBartniczak\ArrayObject\ArrayObject::isEmpty
     */
    public function testIsEmpty()
    {
        $arrayOfObjects = new ArrayObject();
        $this->assertTrue($arrayOfObjects->isEmpty());

        $arrayOfObjects->append(new \DateTime());
        $this->assertFalse($arrayOfObjects->isEmpty());
    }

    /**
     * @covers \BartoszBartniczak\ArrayObject\ArrayObject::merge
     */
    public function testMerge()
    {
        $first = new \DateTime();
        $second = new \DateTime();
        $arrayOfObjectsFirst = new ArrayObject([$first]);
        $arrayOfObjectsSecond = new ArrayObject([$second]);
        $arrayOfObjectsFirst->merge($arrayOfObjectsSecond);
        $this->assertEquals(2, $arrayOfObjectsFirst->count());
        $this->assertSame($first, $arrayOfObjectsFirst->offsetGet(0));
        $this->assertSame($second, $arrayOfObjectsFirst->offsetGet(1));
    }


}
