<?php

namespace Consolidation\Filter\Hooks;

use Consolidation\AnnotatedCommand\AnnotatedCommand;
use Consolidation\AnnotatedCommand\AnnotationData;
use Consolidation\AnnotatedCommand\CommandData;
use Consolidation\Filter\LogicalOpFactory;
use Consolidation\Filter\FilterOutputData;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Yaml\Yaml;

class FilterHooks
{

    /**
     * @hook option *
     */
    public function addFilterOption(AnnotatedCommand $command, AnnotationData $annotationData)
    {
        if ($annotationData->has('filter-output')) {
            if (!$command->getDefinition()->hasOption('filter')) {
                // Add the default filter option if the command hasn't defined one.
                $command->addOption('filter', null, InputOption::VALUE_OPTIONAL, 'Filter output based on provided expression', '');
            }
        }
    }

    /**
     * @hook alter @filter-output
     */
    public function filterOutput($result, CommandData $commandData)
    {
        $expr = $commandData->input()->getOption('filter');
        $default_field = $commandData->annotationData()->get('filter-default-field');
        if (!empty($expr)) {
            $factory = LogicalOpFactory::get();
            $op = $factory->evaluate($expr, $default_field);
            $filter = new FilterOutputData();
            $result = $this->wrapFilteredResult($filter->filter($result, $op), $result);
        }

        return $result;
    }

    /**
     * If the source data was wrapped in a marker class such
     * as RowsOfFields, then re-apply the wrapper.
     */
    protected function wrapFilteredResult($data, $source)
    {
        if (!$source instanceof \ArrayObject) {
            return $data;
        }
        $sourceClass = get_class($source);

        return new $sourceClass($data);
    }
}
