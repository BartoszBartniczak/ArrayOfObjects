<?php
/**
 * Created by PhpStorm.
 * User: Bartosz Bartniczak <kontakt@bartoszbartniczak.pl>
 */

namespace BartoszBartniczak\ArrayObject\KeyNamingStrategy;


class StandardStrategyTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers \BartoszBartniczak\ArrayObject\KeyNamingStrategy\StandardStrategy::key
     */
    public function testKey()
    {

        $standardStrategy = new StandardStrategy();
        $this->assertInstanceOf(KeyNamingStrategy::class, $standardStrategy);

        $this->assertSame('key1', $standardStrategy->key('key1', 'value'));
        $this->assertSame('Key2', $standardStrategy->key('Key2', 'value'));

    }

}
