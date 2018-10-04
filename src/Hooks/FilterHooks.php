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
            $result = $this->wrapFilteredResult($filter->filter($result, $op), get_class($result));
        }

        return $result;
    }

    /**
     * If the source data was wrapped in a marker class such
     * as RowsOfFields, then re-apply the wrapper.
     */
    protected function wrapFilteredResult($data, $sourceClass)
    {
        if (!$sourceClass) {
            return $data;
        }

        return new $sourceClass($data);
    }
}
