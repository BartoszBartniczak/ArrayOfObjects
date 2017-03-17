<?php
/**
 * Created by PhpStorm.
 * User: Bartosz Bartniczak <kontakt@bartoszbartniczak.pl>
 */

namespace BartoszBartniczak\ArrayObject\KeyNamingStrategy;


class ClosureStrategy implements KeyNamingStrategy
{

    /**
     * @var \Closure
     */
    private $closure;

    /**
     * ClosureStrategy constructor.
     * @param \Closure $closure
     */
    public function __construct(\Closure $closure)
    {
        $this->closure = $closure;
    }

    /**
     * @inheritdoc
     */
    public function key($key, $value): string
    {
        $closure = $this->closure;
        return $closure($key, $value);
    }


}