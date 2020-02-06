<?php


namespace crystlbrd\Values;

use crystlbrd\Values\Exceptions\UnsupportedFeatureException;
use Exception;

/**
 * Hosts all number related functions
 * @package crystlbrd\Values
 */
class NumberValue
{
    /**
     * Returns a random number between min and max
     * @param int $max maximum value
     * @param int $min minimum value
     * @param int $dec decimal digits for float output
     * @return int|float
     * @throws UnsupportedFeatureException
     * @throws Exception
     */
    public static function random(int $max, int $min = 0, int $dec = 0)
    {
        if ($dec == 0) {
            return random_int($min, $max);
        } else {
            # TODO: Add support
            throw new UnsupportedFeatureException('dec argument is not supported yet!');
        }
    }
}