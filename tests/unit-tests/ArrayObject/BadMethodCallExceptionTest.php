<?php
/**
 * Created by PhpStorm.
 * User: Bartosz Bartniczak <kontakt@bartoszbartniczak.pl>
 */

namespace ArrayObject;


class BadMethodCallExceptionTest extends \PHPUnit_Framework_TestCase
{

    public function testInstanceOfBadMethodCallException()
    {

        $this->assertInstanceOf(\BadMethodCallException::class, new BadMethodCallException());

    }

}
