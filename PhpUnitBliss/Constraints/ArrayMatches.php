<?php
namespace PhpUnitBliss\Constraints;

use PHPUnit\Framework\Constraint\IsEqual;
use PHPUnit\Framework\Constraint\Constraint;

class ArrayMatches extends Constraint
{
    /**
     * @var array
     */
    private $pattern;

    /**
     * @var string
     */
    private $description;

    /**
     * ArrayMatches constructor.
     * 
     * @param array $pattern
     * @param string $description
     */
    public function __construct(array $pattern, $description = '')
    {
        $this->pattern = $pattern;
        $this->description = $description;
    }

    public function matches($other): bool
    {
        $description = $this->description ?: '$array';

        if (!is_array($other)) {
            return false;
        }

        foreach ($this->pattern as $key => $expectedValue) {
            if (!array_key_exists($key, $other)) {
                return false;
            }

            $otherValue = $other[$key];

            $description .= "['$key']";

            if (is_array($expectedValue)) {
                $constraint = new static($expectedValue, $description);
            } elseif ($expectedValue instanceof Constraint) {
                $constraint = $expectedValue;
            } else {
                $constraint = new IsEqual($expectedValue);
            }

            if (!$constraint->evaluate($otherValue, $description, true)) {
                return false;
            }
        }
        return true;
    }


    protected function failureDescription($other): string
    {
        return sprintf(
            "\n%s\nmatches\n%s",
            $this->exporter()->export($other),
            $this->exporter()->export($this->getPrintablePattern())
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString(): string
    {
        return sprintf(
            "\nmatches:\n%s",
            $this->exporter()->export($this->getPrintablePattern())
        );
    }

    private function getPrintablePattern()
    {
        $pattern = (array)$this->pattern;

        array_walk_recursive($pattern, function (&$value) {
            if ($value instanceof Constraint) {
                $value = sprintf('%s (%s)', get_class($value), $value->toString());
            }
        });

        return $pattern;
    }
}
