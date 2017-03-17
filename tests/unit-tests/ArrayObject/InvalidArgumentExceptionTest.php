<?php
/**
 * Created by PhpStorm.
 * User: Bartosz Bartniczak <kontakt@bartoszbartniczak.pl>
 */

namespace BartoszBartniczak\ArrayObject;

use BartoszBartniczak\TestCase\ExceptionTestCase;

class InvalidArgumentExceptionTest extends ExceptionTestCase
{

    public function testExtendsSplInvalidArgumentException()
    {
        $this->assertConstructorDoesNotRequiredAnyArguments(InvalidArgumentException::class);
        $this->assertConstructorUsesStandardArguments(InvalidArgumentException::class);

        $this->assertInstanceOf(\InvalidArgumentException::class, new InvalidArgumentException());
    }

}
