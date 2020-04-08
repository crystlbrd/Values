<?php


namespace crystlbrd\Values;

use crystlbrd\Values\Exceptions\InvalidArgumentException;

/**
 * Hosts all string related functions
 * @package crystlbrd\Values
 */
class StrVal
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
                $string .= substr($pool, NumVal::random(strlen($pool) - 1), 1);
            }

            return $string;
        } else {
            throw new InvalidArgumentException('length has to be greater or equal than 0!');
        }
    }

    /**
     * Generates a random hex string
     * @param int $length length of the string
     * @param bool $useUpperCase use upper letter or lower ones
     * @return string hex string
     * @throws Exceptions\UnsupportedFeatureException
     * @throws InvalidArgumentException
     */
    public static function randomHex(int $length = 6, bool $useUpperCase = false): string
    {
        // upper or lower case?
        if ($useUpperCase) {
            $pool = 'ABCDEF';
        } else {
            $pool = 'abcdef';
        }

        $pool .= '0123456789';

        // generate string
        return self::random($pool, $length);
    }

    public static function urlSanitize(string $str, array $filter = []): string
    {
        // lower
        $str = mb_strtolower($str);

        // remove whitespace before and at the end
        $str = trim($str);

        // replace special characters
        if (empty($filter)) {
            $filter = [
                'ä' => 'ae',
                'ö' => 'oe',
                'ü' => 'ue',
                'ß' => 'ss',
                '€' => 'euro',
                '$' => 'dollar',
                ' ' => '-',
                '.' => '-',
                ':' => '',
                ';' => '',
                ',' => '',
                '?' => '',
                '&'  => '',
                '!' => '',
                ')' => '',
                '(' => '',
                '/' => '-',
                '"' => '',
                '%' => ''
            ];
        }

        $str = str_replace(array_keys($filter), array_values($filter), $str);

        // remove any other invalid characters
        $str = filter_var($str, FILTER_SANITIZE_URL);

        // remove double minuses
        $str = preg_replace('/(-){2,}/', '-', $str);

        // remove minuses at the end and beginning of the string
        $str = preg_replace('/^-+|-+$/', '', $str);

        return $str;
    }
}