<?php


namespace crystlbrd\Values;

use crystlbrd\Values\Exceptions\InvalidArgumentException;

/**
 * Hosts all string related functions
 * @package crystlbrd\Values
 */
class StringValue
{
    /**
     * Returns a random string
     * @param string $pool chars to use
     * @param int $length length of output string
     * @return string random string
     * @throws InvalidArgumentException
     * @throws Exceptions\UnsupportedFeatureException
     */
    public static function random(string $pool = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', int $length = 16): string
    {
        $string = '';

        if ($length >= 0) {
            for ($i = 0; $i < $length; $i++) {
                $string .= substr($pool, NumberValue::random(strlen($pool) - 1), 1);
            }

            return $string;
        } else {
            throw new InvalidArgumentException('length has to be greater or equal than 0!');
        }
    }
}