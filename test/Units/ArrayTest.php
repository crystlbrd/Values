<?php


namespace crystlbrd\Values\Tests\Units;


use crystlbrd\Values\ArrVal;
use PHPUnit\Framework\TestCase;

class ArrayTest extends TestCase
{
    public function getSomeArrays()
    {
        return [
            [   // Simple list with string values
                [
                    'apple',
                    'banana',
                    'orange'
                ],
                'isNumeric' => true,
                'isList' => true
            ],
            [   // Numeric array with specific keys
                [
                    1 => 'Venus',
                    2 => 'Earth',
                    4 => 'Jupiter'
                ],
                'isNumeric' => true,
                'isList' => false
            ],
            [   // simple Assoc array
                [
                    'a' => 'Amy',
                    'c' => 'Clementine',
                    'f' => 'Fernando'
                ],
                'isNumeric' => false,
                'isList' => false
            ]
        ];
    }

    /**
     * @dataProvider getSomeArrays
     * @param array $arr
     * @param bool $isNumeric
     */
    public function testIsNumeric($arr, $isNumeric)
    {
        self::assertSame($isNumeric, ArrVal::isNumeric($arr));
    }

    /**
     * @dataProvider getSomeArrays
     * @param array $arr
     * @param bool $isNumeric
     * @param bool $isList
     */
    public function testIsList($arr, $isNumeric, $isList)
    {
        self::assertSame($isList, ArrVal::isList($arr));
    }


    public function testMerge()
    {
        $arr_strList = ['apple', 'peach', 'banana', 'strawberry'];
        $arr_numList = [23, 526, 98, 112];
        $arr_numeric = [1 => 'Stefan', 2 => 'Frank', 4 => 'Martin', 12 => 'Alex'];
        $arr_mixed = [
            'name' => 'Alex',
            'age' => 23,
            'job' => 'developer'
        ];
        $arr_multi = [
            'name' => 'dependencies',
            'require' => [
                'phpunit',
                'php7.3'
            ]
        ];
        $arr_multi2 = [
            'require' => [
                'twig',
                'php7.3'
            ]
        ];

        $datasets = [
            [   // Merge two lists
                $arr_strList,
                $arr_numList,
                [
                    'apple', 'peach', 'banana', 'strawberry',
                    23, 526, 98, 112
                ]
            ],
            [   // Merge two numeric arrays
                $arr_strList,
                $arr_numeric,
                [
                    0 => 'apple',
                    1 => 'Stefan',
                    2 => 'Frank',
                    3 => 'strawberry',
                    4 => 'Martin',
                    12 => 'Alex'
                ]
            ],
            [   // Merge different arrays
                $arr_strList,
                $arr_mixed,
                [
                    'apple', 'peach', 'banana', 'strawberry',
                    'name' => 'Alex',
                    'age' => 23,
                    'job' => 'developer'
                ]
            ],
            [   // Merge multidimensional arrays
                $arr_mixed,
                $arr_multi,
                [
                    'name' => 'dependencies',
                    'age' => 23,
                    'job' => 'developer',
                    'require' => [
                        'phpunit',
                        'php7.3'
                    ]
                ]
            ],
            [
                $arr_multi,
                $arr_multi2,
                [
                    'name' => 'dependencies',
                    'require' => [
                        'phpunit',
                        'php7.3',
                        'twig'
                    ]
                ]
            ],
            [
                $arr_multi,
                [
                    'require' => 'base64'
                ],
                [
                    'name' => 'dependencies',
                    'require' => [
                        'phpunit',
                        'php7.3',
                        'base64'
                    ]
                ]
            ]
        ];

        foreach ($datasets as $dataset) {
            $merged = ArrVal::merge($dataset[0], $dataset[1]);
            self::assertSame($dataset[2], $merged);
        }

        // Test merge overfloating parameters
        self::assertSame(
            [
                'name' => 'Steven',
                'fruits' => [
                    'apple',
                    'banana',
                    'strawberries',
                    'berries' => [
                        'blueberry',
                        'cranberry'
                    ]
                ],
                'color' => 'red'
            ],
            ArrVal::merge(
                ['name' => 'Steven'],
                ['fruits' => ['apple', 'banana']],
                ['fruits' => 'strawberries', 'color' => 'red'],
                ['fruits' => ['berries' => ['blueberry', 'cranberry']]]
            )
        );
    }
}