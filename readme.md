# PHPUnit Bliss

See ``tests/AssertionsTest.php`` for many examples.

Add a useful assertion to your TestCase: ``assertArrayMatches``, which allows you to test that a given array matches
a certain subset. You can match by value, or by other assertions.


```php

class AssertionsTest extends \PHPUnit_Framework_TestCase
{
    use \PhpUnitBliss\Assertions;

    public function testBasicExample()
    {
        $array = [
            'id' => 1,
            'name' => 'John',
            'friends' => [
                [
                    'name' => 'Sally',
                ]
            ],
            'other' => 'some field that is ignored',
        ];

        $pattern = [
            'id' => self::anything(),
            'name' => 'John',
            'friends' => self::contains(['name' => 'Sally']),
        ];

        $this->assertArrayMatches($array, $pattern);
    }
}

```