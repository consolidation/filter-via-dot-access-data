<?php
namespace Consolidation\Filter;

use Dflydev\DotAccessData\Data;

use Consolidation\Filter\Operators\ContainsOp;
use Consolidation\Filter\Operators\EqualsOp;
use Consolidation\Filter\Operators\RegexOp;
use Consolidation\Filter\Operators\NotOp;

/**
 * Convert a simple operator expression into an Operator.
 *
 * The supported operators include:
 *
 *      key=value           Equals
 *      key*=value          Contains value
 *      key~=#regex#        Regular expression match
 *
 * It is also possible to negate the result of an operator by
 * adding a logical-not operator either before the entire expression,
 * e.g. !key=value, or before the operator, e.g. key!=value.
 *
 */
class OperatorFactory implements FactoryInterface
{
    public function __construct()
    {
    }

    /**
     * Create an operator or a set of operators from the expression.
     *
     * @param string $expression
     * @return OperatorInterface
     */
    public function evaluate($expression)
    {
        if ($expression[0] == '!') {
            $op = $this->evaluateNonNegated(substr($expression, 1));
            return new NotOp($op);
        }
        return $this->evaluateNonNegated($expression);
    }

    protected function evaluateNonNegated($expression)
    {
        list($key, $op, $comparitor) = $this->splitOnOperator($expression);
        if (empty($key) || empty($op)) {
            throw new \Exception('Could not parse expression ' . $expression);
        }

        if ($op[0] == '!') {
            $op = $this->instantiate($key, substr($op, 1), $comparitor);
            return new NotOp($op);
        }
        return $this->instantiate($key, $op, $comparitor);
    }

    protected function instantiate($key, $op, $comparitor)
    {
        switch ($op) {
            case '=':
                return new EqualsOp($key, $comparitor);
            case '*=':
                return new ContainsOp($key, $comparitor);
            case '~=':
                return new RegexOp($key, $comparitor);
        }

        throw new \Exception('Unrecognized operator ' . $op);
    }

    /**
     * Given an expression in the form 'key=comparitor', return a list
     * containing the key, the operator, and the comparitor. The operator
     * can be any of: =, *=, ~=, !=, !*= or !~=.
     *
     * @param string @expression
     * @return array
     */
    protected function splitOnOperator($expression)
    {
        if (!preg_match('#([^!~*=]*)(!?~?\*?=)(.*)#', $expression, $matches)) {
            return ['', '', ''];
        }

        array_shift($matches);
        return $matches;
    }
}

        // Find all quoted strings in $expression and save their values
        // in a value map

        // Substitute references from the value map into the expression

        // Split the expression on the logical operators (& and | only)

        // Iterate over the strings between the logical operators
