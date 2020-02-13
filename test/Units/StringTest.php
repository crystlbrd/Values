<?php


namespace crystlbrd\Values\Tests\Units;


use crystlbrd\Values\StringValue;
use PHPUnit\Framework\TestCase;

class StringTest extends TestCase
{
    /**
     * Tests, if String generates random values correctly
     * @author crystlbrd
     * @small
     * @throws \crystlbrd\Values\Exceptions\InvalidArgumentException
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
}