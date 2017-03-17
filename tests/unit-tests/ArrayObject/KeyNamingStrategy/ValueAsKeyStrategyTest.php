<?php
/**
 * Created by PhpStorm.
 * User: Bartosz Bartniczak <kontakt@bartoszbartniczak.pl>
 */

namespace BartoszBartniczak\ArrayObject\KeyNamingStrategy;

use BartoszBartniczak\ArrayObject\InvalidArgumentException;

class ValueAsKeyStrategyTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers \BartoszBartniczak\ArrayObject\KeyNamingStrategy\ValueAsKeyStrategy::key
     */
    public function testKey()
    {

        $valueAsKeyStrategy = new ValueAsKeyStrategy();

        $this->assertSame('abc', $valueAsKeyStrategy->key('key', 'abc'));
        $this->assertSame('123', $valueAsKeyStrategy->key('key', 123));
        $this->assertSame('1.23', $valueAsKeyStrategy->key('key', 1.23));
        $this->assertSame('1', $valueAsKeyStrategy->key('key', true));

    }

    /**
     * @covers \BartoszBartniczak\ArrayObject\KeyNamingStrategy\ValueAsKeyStrategy::key
     */
    public function testKeyThrowsExceptionIfValueIsNotIntegerOrString()
    {

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('This strategy cannot handle this type of data (\'object\'). Value should be float, boolean, integer or string');

        $valueAsKeyStrategy = new ValueAsKeyStrategy();
        $valueAsKeyStrategy->key('key', new \DateTime());


    }

}
