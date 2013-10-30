<?php

include __DIR__ . '/../Loader.php';

$printer = new \Skwal\Visitor\Printer\Query();
$table = new \Skwal\TableReference('test');
$query = new \Skwal\SelectQuery('childQuery');

$query = $query->addTable($table)
               ->addColumn($table->getColumn('testCol', 'aliasedCol'))
               ->addColumn($table->getColumn('unaliasedCol'));

echo $printer->getQueryCommand($query) . PHP_EOL;

$parentQuery = new \Skwal\SelectQuery('parent');
/** @todo : Fix incorrect column reference when deriving columns from
 *          nested queries
 */
$parentQuery = $parentQuery->addTable($query)
                           ->addColumn($query->getColumn(0));

echo $printer->getQueryCommand($parentQuery) . PHP_EOL;