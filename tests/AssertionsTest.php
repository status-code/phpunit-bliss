<?php
namespace Tests;

use PhpUnitBliss\Assertions;

class AssertionsTest extends \PHPUnit_Framework_TestCase
{
    use Assertions;

    public function testAssertArrayMatchesEquals()
    {
        $array = [
            'foo' => 'bar',
        ];

        $this->assertArrayMatches([
            'foo' => 'bar',
        ], $array);
    }

    public function testAssertArrayMatchesIgnoresExtraKeys()
    {
        $array = [
            'first' => '1',
            'second' => '3',
        ];

        $this->assertArrayMatches([
            'first' => '1',
        ], $array);
    }

    public function testAssertArrayMatchesGreaterThan()
    {
        $array = [
            'number' => 11,
        ];

        $this->assertArrayMatches([
            'number' => self::greaterThan(10),
        ], $array);
    }

    public function testAssertArrayMatchesNested()
    {
        $array = [
            'parent' => [
                'child' => 'foo'
            ]
        ];

        $this->assertArrayMatches([
            'parent' => [
                'child' => 'foo',
            ]
        ], $array);
    }

    public function testAssertArrayMatchesIgnoresExtraNestedKeys()
    {
        $array = [
            'parent' => [
                'child' => 'foo',
                'otherChild' => 'foo',
            ]
        ];

        $this->assertArrayMatches([
            'parent' => [
                'child' => 'foo',
            ]
        ], $array);
    }

    public function testAssertArrayMatchesAnything()
    {
        $array = [
            'existingKey' => [
                'content' => 'foo',
            ]
        ];

        $this->assertArrayMatches([
            'existingKey' => self::anything(),
        ], $array);
    }

    public function testNotAssertArrayMatches()
    {
        $array = [
            'foo' => 'bar',
        ];

        $this->assertThat($array, $this->logicalNot(
            $this->arrayMatches([
                'foo' => 'baz'
            ])
        ));
    }

    public function testAssertArrayNotMatchesWrongType()
    {
        $array = [
            'foo' => 'bar',
        ];

        $this->assertArrayNotMatches([
            'foo' => [
                'bar' => 'baz'
            ],
        ], $array);
    }

    public function testAssertArrayNotMatchesMissingKey()
    {
        $array = [
            'one' => 1,
        ];

        $this->assertArrayNotMatches([
            'two' => 2,
        ], $array);
    }

    public function testAssertArrayNotMatchesDifferentValue()
    {
        $array = [
            'one' => 1,
        ];

        $this->assertArrayNotMatches([
            'one' => 2,
        ], $array);
    }

    public function testAssertArrayMatchesLooseType()
    {
        $array = [
            'one' => 1,
        ];

        $this->assertArrayMatches([
            'one' => '1',
        ], $array);
    }

    public function testAssertArrayMatchesPartiallyWithExactSubset()
    {
        $array = [
            'one' => 1,
            'two' => 2,
            'tree' => [
                'a' => 'A',
            ]
        ];

        $this->assertArrayMatches([
            'one' => '1',
            'tree' => [

            ],
        ], $array);

        $this->assertArrayNotMatches([
            'one' => '1',
            'tree' => self::equalTo([])
        ], $array);
    }

    public function testAssertArrayMatchesContains()
    {
        $array = [
            'items' => [
                [
                    'name' => 'first',
                ],
                [
                    'name' => 'second',
                ]
            ]
        ];

        $this->assertArrayMatches([
            'items' => self::contains(['name' => 'second'])
        ], $array);
    }
}