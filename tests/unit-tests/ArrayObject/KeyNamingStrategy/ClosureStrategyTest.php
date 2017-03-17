<?php
/**
 * Created by PhpStorm.
 * User: Bartosz Bartniczak <kontakt@bartoszbartniczak.pl>
 */

namespace BartoszBartniczak\ArrayObject\KeyNamingStrategy;


class ClosureStrategyTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers \BartoszBartniczak\ArrayObject\KeyNamingStrategy\ClosureStrategy::key
     * @covers \BartoszBartniczak\ArrayObject\KeyNamingStrategy\ClosureStrategy::__construct
     */
    public function testKey()
    {

        $closureStrategy = new ClosureStrategy(function ($key, \DateTime $dateTime) {
            return $dateTime->format('Y-m-d');
        });

        $this->assertInstanceOf(KeyNamingStrategy::class, $closureStrategy);
        $this->assertSame('2017-03-17', $closureStrategy->key('key', new \DateTime('2017-03-17 12:00:00')));
    }

}
