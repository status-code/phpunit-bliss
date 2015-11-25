<?php
namespace PhpUnitBliss\Constraints;

class ArrayMatches extends \PHPUnit_Framework_Constraint
{
    /**
     * @var array
     */
    private $pattern;

    /**
     * ArrayMatches constructor.
     * @param array $pattern
     */
    public function __construct(array $pattern)
    {
        parent::__construct();
        $this->pattern = $pattern;
    }

    public function matches($other, $description = '')
    {
        $description = $description ?: '$array';

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
                $constraint = new static($expectedValue, $otherValue, $description);
            } elseif ($expectedValue instanceof \PHPUnit_Framework_Constraint) {
                $constraint = $expectedValue;
            } else {
                $constraint = new \PHPUnit_Framework_Constraint_IsEqual($expectedValue);
            }

            if (!$constraint->evaluate($otherValue, $description, true)) {
                return false;
            }
        }
        return true;
    }


    protected function failureDescription($other)
    {
        return sprintf(
            "\n%s\nmatches\n%s",
            $this->exporter->export($other),
            $this->exporter->export($this->getPrintablePattern())
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return sprintf(
            "\nmatches:\n%s",
            $this->exporter->export($this->getPrintablePattern())
        );
    }

    private function getPrintablePattern()
    {
        $pattern = (array)$this->pattern;

        array_walk_recursive($pattern, function (&$value) {
            if ($value instanceof \PHPUnit_Framework_Constraint) {
                $value = sprintf('%s (%s)', get_class($value), $value->toString());
            }
        });

        return $pattern;
    }
}