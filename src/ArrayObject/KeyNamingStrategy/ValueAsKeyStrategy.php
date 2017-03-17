<?php
/**
 * Created by PhpStorm.
 * User: Bartosz Bartniczak <kontakt@bartoszbartniczak.pl>
 */

namespace BartoszBartniczak\ArrayObject\KeyNamingStrategy;


use BartoszBartniczak\ArrayObject\InvalidArgumentException;

class ValueAsKeyStrategy implements KeyNamingStrategy
{

    /**
     * @inheritdoc
     */
    public function key($key, $value)
    {
        if (!is_scalar($value)) {
            throw new InvalidArgumentException(sprintf(
                'This strategy cannot handle this type of data (\'%s\'). Value should be float, boolean, integer or string',
                gettype($value)
            ));
        }
        return (string)$value;
    }

}