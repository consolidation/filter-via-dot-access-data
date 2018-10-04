<?php

namespace Consolidation\Filter\Hooks;

use Consolidation\AnnotatedCommand\CommandData;
use Consolidation\Filter\LogicalOpFactory;
use Consolidation\Filter\FilterOutputData;
use Symfony\Component\Yaml\Yaml;

class FilterHooks
{
    /**
     * @hook alter @filter-output
     * @option $filter Filter output based on provided expression
     * @default $filter ''
     */
    public function filterOutput($result, CommandData $commandData)
    {
        $expr = $commandData->input()->getOption('filter');
        if (!empty($expr)) {
            $factory = LogicalOpFactory::get();
            $op = $factory->evaluate($expr);
            $filter = new FilterOutputData();
            $result = $filter->filter($result, $op);
        }

        return $result;
    }
}
