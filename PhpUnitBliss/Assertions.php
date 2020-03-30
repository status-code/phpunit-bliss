<?php
namespace PhpUnitBliss;

use PhpUnitBliss\Constraints\ArrayMatches;

trait Assertions
{
    public static function arrayMatches($pattern, $description = '')
    {
        return new ArrayMatches($pattern, $description);
    }

    public static function arrayNotMatches($pattern, $description = '')
    {
        return self::logicalNot(self::arrayMatches($pattern, $description));
    }

    public static function assertArrayMatches($pattern, $array, $description = '')
    {
        self::assertThat($array, self::arrayMatches($pattern, $description), $description);
    }

    public static function assertArrayNotMatches($pattern, $array, $description = '')
    {
        self::assertThat($array, self::arrayNotMatches($pattern, $description));
    }
}
