<?php


namespace crystlbrd\Values\Tests\Units;


use crystlbrd\Values\Exceptions\UnsupportedFeatureException;
use crystlbrd\Values\NumVal;
use PHPUnit\Framework\TestCase;

/**
 * Test the Number value
 * @package crystlbrd\Values\Tests\Units
 */
class NumberTest extends TestCase
{
    /**
     * Tests, if Number generates valid random values
     * @author crystlbrd
     * @small
     */
    public function testRandom()
    {
        /// CONFIG

        // Amount of test iterations
        $iterations = 100;

        // Numbers largest value
        $maxBorder = 10000;

        // Number smallest value
        $minBorder = -1000;


        /// TEST

        // Test only with max border
        for ($i = 0; $i < $iterations; $i++) {
            // Generate a random number
            $number = NumVal::random($maxBorder);

            // test type
            self::assertIsInt($number);

            // test minimal border
            self::assertGreaterThanOrEqual(0, $number);

            // test maximal border
            self::assertLessThanOrEqual($maxBorder, $number);
        }

        // Test with max and min border
        for ($i = 0; $i < $iterations; $i++) {
            // Generate a random number
            $number = NumVal::random($maxBorder, $minBorder);

            // test type
            self::assertIsInt($number);

            // test minimal border
            self::assertGreaterThanOrEqual($minBorder, $number);

            // test maximal border
            self::assertLessThanOrEqual($maxBorder, $number);
        }

        // Test generation float
        for ($i = 0; $i < $iterations; $i++) {
            // Generate a random number
            self::expectException(UnsupportedFeatureException::class);
            $number = NumVal::random($maxBorder, $minBorder, 5);

            # TODO: As soon as implemented
        }
    }
}