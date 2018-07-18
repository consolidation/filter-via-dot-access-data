<?php

namespace Consolidation\Filter\Cli;

use Consolidation\Filter\LogicalOpFactory;

class OpCommands extends \Robo\Tasks
{
    /**
     * Test the expression parser
     *
     * @command evaluate
     * @return array
     */
    public function evaluate($expr, $options = ['format' => 'yaml', 'dump' => false])
    {
        $factory = LogicalOpFactory::get();
        $op = $factory->evaluate($expr);

        $result = (string)$op;

        if ($options['dump']) {
            $result = var_export($op, true) . "\n$result";
        }

        return $result;
    }
}
