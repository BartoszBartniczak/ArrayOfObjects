<?php
/**
 * Created by PhpStorm.
 * User: Bartosz Bartniczak <kontakt@bartoszbartniczak.pl>
 */

namespace BartoszBartniczak\ArrayObject;

use BartoszBartniczak\TestCase\ExceptionTestCase;

class EmptyArrayExceptionTest extends ExceptionTestCase
{

    /**
     * @covers \BartoszBartniczak\ArrayObject\EmptyArrayException::__construct
     */
    public function testConstructor()
    {


        $this->assertConstructorDoesNotRequiredAnyArguments(EmptyArrayException::class);
        $this->assertConstructorUsesStandardArguments(EmptyArrayException::class);

        $emptyArrayException = new EmptyArrayException();
        $this->assertInstanceOf(InvalidArgumentException::class, $emptyArrayException);
    }

}
