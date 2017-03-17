<?php
/**
 * Created by PhpStorm.
 * User: Bartosz Bartniczak <kontakt@bartoszbartniczak.pl>
 */

namespace BartoszBartniczak\ArrayObject\KeyNamingStrategy;


class StandardStrategy implements KeyNamingStrategy
{
    /**
     * @inheritdoc
     */
    public function key($key, $value)
    {
        return $key;
    }


}