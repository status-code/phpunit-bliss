# PHPUnit Bliss

See ``tests/AssertionsTest.php`` for many examples.

Add a useful assertion to your TestCase: ``assertArrayMatches``, which allows you to test that a given array matches
a certain subset. You can match by value, or by other assertions.


```php

class AssertionsTest extends \PHPUnit_Framework_TestCase
{
    use \PhpUnitBliss\Assertions;

    public function testSimpleExample()
    {
        $array = [
            'id' => 1,
            'name' => 'John',
            'preferences' => [
                'vegetables' => true,
                'beer' => false,
            ],
        ];

        $pattern = [
            'name' => 'John',
            'preferences' => [
                'vegetables' => true,
            ],
        ];

        $this->assertArrayMatches($array, $pattern);

        $notPattern = [
            'name' => 'John',
            'preferences' => [
                'beer' => true,
            ],
        ];

        $this->assertArrayNotMatches($array, $notPattern);
    }

    /**
     * You can use constraints to match values inside arrays
     */
    public function testComplexExample()
    {
        $array = [
            'id' => 1,
            'age' => 25,
            'friends' => [
                [
                    'name' => 'Sally',
                ]
            ],
            'other' => 'some field that is ignored',
            'tree' => [
                'subtree' => ['foo', 'bar', 'baz']
            ],
        ];

        $pattern = [
            'id' => self::anything(),
            'age' => self::greaterThan(18),
            'friends' => self::contains(['name' => 'Sally']),
            'tree' => [
                'subtree' => self::logicalAnd(
                    self::countOf(3),
                    self::arrayMatches([1 => 'bar'])
                )
            ],
        ];

        $this->assertArrayMatches($array, $pattern);
    }
}

```