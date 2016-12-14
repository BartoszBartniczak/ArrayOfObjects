<?php

namespace ArrayObject;

use PHPUnit_Framework_TestCase;

/**
 * Created by PhpStorm.
 * User: Bartosz Bartniczak <kontakt@bartoszbartniczak.pl>
 */
class TestCase extends PHPUnit_Framework_TestCase
{

    protected function assertArrayKeys(ArrayObject $keys, ArrayObject $arrayObject)
    {
        self::assertEquals($keys, $arrayObject->keys());
    }

}
