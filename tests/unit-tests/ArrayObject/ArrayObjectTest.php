<?php
/**
 * Created by PhpStorm.
 * User: Bartosz Bartniczak <kontakt@bartoszbartniczak.pl>
 */

namespace ArrayObject;


class ArrayObjectTest extends TestCase
{

    /**
     * @covers \ArrayObject\ArrayObject::__construct
     */
    public function testConstructor()
    {

        $arrayObject = new ArrayObject();
        $this->assertInstanceOf(\ArrayObject::class, $arrayObject);

        $arrayObject = new ArrayObject([1, 2, 3]);
        $this->assertEquals(3, $arrayObject->count());

        $arrayObject = new ArrayObject([1, 2, 3], ArrayObject::ARRAY_AS_PROPS);
        $this->assertEquals(ArrayObject::ARRAY_AS_PROPS, $arrayObject->getFlags());

        $arrayObject = new ArrayObject([1, 2, 3], ArrayObject::ARRAY_AS_PROPS, \EmptyIterator::class);
        $this->assertEquals(\EmptyIterator::class, $arrayObject->getIteratorClass());
    }

    /**
     * @covers \ArrayObject\ArrayObject::changeKeyCase
     */
    public function testChangeKeyCase()
    {

        $arrayObject = new ArrayObject(['appLe' => 1, 'baNANA' => 2, 'cherry' => 3]);
        $arrayObject->changeKeyCase(CASE_LOWER);
        $this->assertArrayKeys(new ArrayObject(['apple', 'banana', 'cherry']), $arrayObject);

        $arrayObject = new ArrayObject(['appLe' => 1, 'baNANA' => 2, 'cherry' => 3]);
        $arrayObject->changeKeyCase(CASE_UPPER);
        $this->assertArrayKeys(new ArrayObject(['APPLE', 'BANANA', 'CHERRY']), $arrayObject);
    }

    /**
     * @covers \ArrayObject\ArrayObject::keys
     */
    public function testKeys()
    {
        $arrayObject = new ArrayObject(['apple' => 1, 'banana' => 2, 'cherry' => 3]);
        $this->assertEquals(new ArrayObject(['apple', 'banana', 'cherry']), $arrayObject->keys());
    }

    /**
     * @covers \ArrayObject\ArrayObject::chunk
     */
    public function testChunk()
    {
        $arrayObject = new ArrayObject(['apple' => 1, 'banana' => 2, 'cherry' => 3]);
        $this->assertEquals(new ArrayObject([new ArrayObject([1, 2]), new ArrayObject([3])]), $arrayObject->chunk(2));

        $arrayObject = new ArrayObject(['apple' => 1, 'banana' => 2, 'cherry' => 3]);
        $this->assertEquals(new ArrayObject([new ArrayObject(['apple' => 1, 'banana' => 2]), new ArrayObject(['cherry' => 3])]), $arrayObject->chunk(2, true));
    }

}
