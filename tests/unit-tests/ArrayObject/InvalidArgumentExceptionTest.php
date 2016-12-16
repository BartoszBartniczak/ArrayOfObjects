<?php
/**
 * Created by PhpStorm.
 * User: Bartosz Bartniczak <kontakt@bartoszbartniczak.pl>
 */

namespace BartoszBartniczak\ArrayObject;

class InvalidArgumentExceptionTest extends \PHPUnit_Framework_TestCase
{

    public function testExtendsSplInvalidArgumentException()
    {
        $this->assertInstanceOf(\InvalidArgumentException::class, new InvalidArgumentException());
    }

}
