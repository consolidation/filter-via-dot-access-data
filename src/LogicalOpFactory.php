<?php
namespace Consolidation\Filter;

use Dflydev\DotAccessData\Data;

use Consolidation\Filter\Operators\LogicalAndOp;
use Consolidation\Filter\Operators\LogicalOrOp;

/**
 * Convert an expression with logical operators into an Operator.
 */
class LogicalOpFactory implements FactoryInterface
{
    protected $factory;

    /**
     * Factory constructor
     * @param FactoryInterface|null $factory
     * @return FactoryInterface
     */
    public function __construct($factory = null)
    {
        $this->factory = $factory ?: new OperatorFactory();
    }

    /**
     * Factory factory
     * @return FactoryInterface
     */
    public static function get()
    {
        return new self();
    }

    /**
     * Create an operator or a set of operators from the expression.
     *
     * @param string $expression
     * @return OperatorInterface
     */
    public function evaluate($expression)
    {
        $exprSet = $this->splitByLogicOp($expression);
        $result = false;

        foreach ($exprSet as $exprWithLogicOp) {
            $logicOp = $exprWithLogicOp[1];
            $expr = $exprWithLogicOp[2];
            $rhs = $this->factory->evaluate($expr);
            $result = $this->combineUsingLogicalOp($result, $logicOp, $rhs);
        }

        return $result;
    }

    /**
     * Given an expression in a form similar to 'a=b&c=d|x=y',
     * produce a result as :
     *
     * [
     *  [
     *    0 => 'a=b',
     *     1 => '',
     *     2 => 'a=b',
     *   ),
     *   [
     *     0 => '&c=d',
     *     1 => '&',
     *     2 => 'c=d',
     *   ),
     *   [
     *     0 => '|x=y',
     *     1 => '|',
     *     2 => 'x=y',
     *   ),
     * )
     *
     * @param string $expression
     * @return array
     */
    protected function splitByLogicOp($expression)
    {
        if (!preg_match_all('#([&|]*)([^&|]+)#', $expression, $exprSet, PREG_SET_ORDER)) {
            throw new \Exception('Could not evaluate logical expression ' . $expression);
        }
        return $exprSet;
    }

    /**
     * Given the left-hand-side operator, a logical operator, and a
     * string expression, create the right-hand-side operator and combine
     * it with the provided lhs operator.
     *
     * @param Operator|false $lhs Left-hand-side operator
     * @param string $logicOp '&' or '|'
     * @param OperatorInterface $rhs Right-hand-side operator
     * @return Operator
     */
    protected function combineUsingLogicalOp($lhs, $logicOp, OperatorInterface $rhs)
    {
        // If this is the first term, just return the $rhs.
        // At this point, $logicOp is always empty.
        if (!$lhs || empty($logicOp)) {
            return $rhs;
        }

        // At this point, $logicOp is never empty.
        return $this->createLogicalOp($lhs, $logicOp, $rhs);
    }

    /**
     * Given the left-hand-side operator, a logical operator, and a
     * string expression, create the right-hand-side operator and combine
     * it with the provided lhs operator.
     *
     * @param Operator|false $lhs Left-hand-side operator
     * @param string $logicOp '&' or '|'
     * @param OperatorInterface $rhs Right-hand-side operator
     * @return Operator
     */
    protected function createLogicalOp(OperatorInterface $lhs, $logicOp, OperatorInterface $rhs)
    {
        switch ($logicOp) {
            case '&':
                return new LogicalAndOp($lhs, $rhs);
            case '|':
                return new LogicalOrOp($lhs, $rhs);
        }
        throw new \Exception('Impossible logicOp received: ' . $logicOp);
    }
}