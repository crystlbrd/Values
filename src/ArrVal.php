<?php


namespace crystlbrd\Values;

/**
 * Hosts all Array related functions
 * @package crystlbrd\Values
 */
class ArrVal
{
    /**
     * Checks, if any key in needle is in haystack
     * @param array $needle keys to look for
     * @param array $haystack array to search in
     * @return bool
     */
    public static function arrayInArray(array $needle, array $haystack):bool
    {
        foreach ($needle as $n) {
            if (in_array($n, $haystack)) return true;
        }

        return false;
    }

    /**
     * Checks, if an array is numeric (all keys are integers)
     * @param array $arr Array to check
     * @return bool
     */
    public static function isNumeric(array $arr): bool
    {
        foreach ($arr as $k => $v) {
            if (!is_int($k)) return false;
        }

        return true;
    }

    /**
     * Checks, if an array is numeric and list styled
     * @param array $arr
     * @return bool
     */
    public static function isList(array $arr): bool
    {
        // Array has to be numeric
        if (self::isNumeric($arr)) {
            // Check all keys if they are counting up
            $i = 0;
            foreach ($arr as $k => $v) {
                if ($k !== $i) {
                    return false;
                }

                $i++;
            }

            return true;
        } else {
            return false;
        }
    }

    public static function merge(array $bArray, array $mArray): array
    {
        foreach ($mArray as $k => $v) {
            // Merge 2 numeric arrays
            if (self::isList($bArray) && self::isList($mArray)) {
                // Don't append a duplicate value
                if (!in_array($v, $bArray)) {
                    $bArray[] = $v;
                }
            } elseif (isset($bArray[$k])) {
                // Special behavior for arrays
                if (is_array($bArray[$k])) {
                    if (is_array($v)) {
                        // Merge arrays on arrays
                        $bArray[$k] = self::merge($bArray[$k], $v);
                    } else {
                        // else just append to them
                        $bArray[$k][] = $v;
                    }
                } else {
                    // overwrite all none-array values
                    $bArray[$k] = $v;
                }
            } else {
                // append the missing key
                $bArray[$k] = $v;
            }
        }

        // Merge overfloating arrays
        if (func_num_args() > 2) {
            foreach (array_slice(func_get_args(), 2) as $arr) {
                $bArray = self::merge($bArray, $arr);
            }
        }

        return $bArray;
    }
}