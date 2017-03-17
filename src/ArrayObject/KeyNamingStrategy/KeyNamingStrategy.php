<?php
/**
 * Created by PhpStorm.
 * User: Bartosz Bartniczak <kontakt@bartoszbartniczak.pl>
 */

namespace BartoszBartniczak\ArrayObject\KeyNamingStrategy;


interface KeyNamingStrategy
{

    /**
     * @param string $key
     * @param $value
     * @return string|null
     */
    public function key($key, $value);

}