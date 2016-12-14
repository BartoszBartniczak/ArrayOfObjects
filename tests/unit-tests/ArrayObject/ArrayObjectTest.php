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

    /**
     * @covers \ArrayObject\ArrayObject::column
     */
    public function testColumn()
    {
        $arrayObject = new ArrayObject(
            [
                [
                    'id' => 2135,
                    'first_name' => 'John',
                    'last_name' => 'Doe',
                ],
                [
                    'id' => 3245,
                    'first_name' => 'Sally',
                    'last_name' => 'Smith',
                ],
                [
                    'id' => 5342,
                    'first_name' => 'Jane',
                    'last_name' => 'Jones',
                ],
                [
                    'id' => 5623,
                    'first_name' => 'Peter',
                    'last_name' => 'Doe',
                ]
            ]
        );

        $this->assertEquals(
            new ArrayObject(['John', 'Sally', 'Jane', 'Peter']),
            $arrayObject->column('first_name')
        );

        $this->assertEquals(
            new ArrayObject([2135 => 'John', 3245 => 'Sally', 5342 => 'Jane', 5623 => 'Peter']),
            $arrayObject->column('first_name', 'id')
        );

        $arrayObject = new ArrayObject(
            [
                [
                    0 => 2135,
                    1 => 'John',
                    2 => 'Doe',
                ],
                [
                    0 => 3245,
                    1 => 'Sally',
                    2 => 'Smith',
                ],
                [
                    0 => 5342,
                    1 => 'Jane',
                    2 => 'Jones',
                ],
                [
                    0 => 5623,
                    1 => 'Peter',
                    2 => 'Doe',
                ]
            ]
        );

        $this->assertEquals(
            new ArrayObject(['John', 'Sally', 'Jane', 'Peter']),
            $arrayObject->column(1)
        );

        $this->assertEquals(
            new ArrayObject([2135 => 'John', 3245 => 'Sally', 5342 => 'Jane', 5623 => 'Peter']),
            $arrayObject->column(1, 0)
        );
    }

    /**
     * @covers \ArrayObject\ArrayObject::column
     */
    public function testColumnThrowsExceptionIfColumnIsNotSetStringIndices()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Column 'address' is not defined.");

        $arrayObject = new ArrayObject(
            [
                [
                    'id' => 2135,
                    'first_name' => 'John',
                    'last_name' => 'Doe',
                ],
                [
                    'id' => 3245,
                    'first_name' => 'Sally',
                    'last_name' => 'Smith',
                ],
                [
                    'id' => 5342,
                    'first_name' => 'Jane',
                    'last_name' => 'Jones',
                ],
                [
                    'id' => 5623,
                    'first_name' => 'Peter',
                    'last_name' => 'Doe',
                ]
            ]
        );

        $arrayObject->column('address');
    }

    /**
     * @covers \ArrayObject\ArrayObject::column
     */
    public function testColumnThrowsExceptionIfColumnIsNotSetNumericIndices()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Column '4' is not defined.");

        $arrayObject = new ArrayObject(
            [
                [
                    0 => 2135,
                    1 => 'John',
                    2 => 'Doe',
                ],
                [
                    0 => 3245,
                    1 => 'Sally',
                    2 => 'Smith',
                ],
                [
                    0 => 5342,
                    1 => 'Jane',
                    2 => 'Jones',
                ],
                [
                    0 => 5623,
                    1 => 'Peter',
                    2 => 'Doe',
                ]
            ]
        );

        $arrayObject->column(4);
    }

    /**
     * @covers \ArrayObject\ArrayObject::column
     */
    public function testColumnThrowsExceptionIfIndexColumnIsNotSetStringIndices()
    {

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Index column 'address' is not defined.");

        $arrayObject = new ArrayObject(
            [
                [
                    'id' => 2135,
                    'first_name' => 'John',
                    'last_name' => 'Doe',
                ],
                [
                    'id' => 3245,
                    'first_name' => 'Sally',
                    'last_name' => 'Smith',
                ],
                [
                    'id' => 5342,
                    'first_name' => 'Jane',
                    'last_name' => 'Jones',
                ],
                [
                    'id' => 5623,
                    'first_name' => 'Peter',
                    'last_name' => 'Doe',
                ]
            ]
        );

        $arrayObject->column('first_name', 'address');
    }

    /**
     * @covers \ArrayObject\ArrayObject::column
     */
    public function testColumnThrowsExceptionIfIndexColumnIsNotSetNumericIndices()
    {

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Index column '4' is not defined.");

        $arrayObject = new ArrayObject(
            [
                [
                    0 => 2135,
                    1 => 'John',
                    2 => 'Doe',
                ],
                [
                    0 => 3245,
                    1 => 'Sally',
                    2 => 'Smith',
                ],
                [
                    0 => 5342,
                    1 => 'Jane',
                    2 => 'Jones',
                ],
                [
                    0 => 5623,
                    1 => 'Peter',
                    2 => 'Doe',
                ]
            ]
        );

        $arrayObject->column(1, 4);
    }

}
