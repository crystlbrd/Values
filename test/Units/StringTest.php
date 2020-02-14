<?php


namespace crystlbrd\Values\Tests\Units;


use crystlbrd\Values\Exceptions\InvalidArgumentException;
use crystlbrd\Values\Exceptions\UnsupportedFeatureException;
use crystlbrd\Values\NumberValue;
use crystlbrd\Values\StringValue;
use PHPUnit\Framework\TestCase;

class StringTest extends TestCase
{
    /**
     * Tests, if String generates random values correctly
     * @throws InvalidArgumentException*@throws \crystlbrd\Values\Exceptions\UnsupportedFeatureException
     * @throws UnsupportedFeatureException
     * @author crystlbrd
     * @small
     */
    public function testRandom()
    {
        /// CONFIG

        // Different test scenarios
        $datasets = [
            [
                'pool' => 'abcdefghijklmnopqrstuvwxyz',
                'length' => 10,
            ],
            [
                'pool' => '0123456789abcdef',
                'length' => 16
            ]
        ];

        // Number of iteration per set
        $iterations = 100;


        /// TEST

        foreach ($datasets as $dataset) {
            for ($i = 0; $i < $iterations; $i++) {
                // Generate random string
                $string = StringValue::random($dataset['pool'], $dataset['length']);

                // Validate type
                self::assertIsString($string);

                // Validate string
                self::assertRegExp('/^[' . $dataset['pool'] . ']{' . $dataset['length'] . '}$/', $string);
            }
        }
    }

    /**
     * Tests, if random throws an Exception, if length is lesser than 0
     * @throws InvalidArgumentException
     * @throws UnsupportedFeatureException
     */
    public function testInvalidCallingOfRandom()
    {
        $this->expectException(InvalidArgumentException::class);
        StringValue::random('abc', -1);
    }

    /**
     * Test, if String returns random hex values correctly
     * @throws InvalidArgumentException
     * @throws UnsupportedFeatureException
     */
    public function testRandomHex()
    {
        /// CONFIG

        // Amount of iterations
        $iterations = 100;


        /// TEST

        for ($i = 0; $i < $iterations; $i++) {
            /// Lower case

            // get a random length
            $length = NumberValue::random(32);

            // generate a random string
            $string = StringValue::randomHex($length);

            // validate
            self::assertIsString($string);
            self::assertRegExp('/^[abcdef0123456789]{' . $length . '}$/', $string);


            /// Upper case

            // get a random length
            $length = NumberValue::random(32);

            // generate a random string
            $string = StringValue::randomHex($length, true);

            // validate
            self::assertIsString($string);
            self::assertRegExp('/^[ABCDEF0123456789]{' . $length . '}$/', $string);
        }
    }

    /**
     * Tests, if randomHex throws an Exception, if length is lesser than 0
     * @throws InvalidArgumentException
     * @throws UnsupportedFeatureException
     */
    public function testInvalidCallingOfRandomHex()
    {
        $this->expectException(InvalidArgumentException::class);
        StringValue::randomHex(-1);
    }
}