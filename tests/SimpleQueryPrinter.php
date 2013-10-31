<?php

use Skwal\TableReference;
use Skwal\SelectQuery;
use Skwal\Expression\LiteralExpression;

include __DIR__ . '/../Loader.php';

$printer = new Skwal\Visitor\Printer\Query();
$table = new TableReference('test');
$query = new SelectQuery('childQuery');

$query = $query->addTable($table)
               ->addColumn($table->getColumn('anyCol', 'aliasedCol'))
               ->addColumn($table->getColumn('unaliasedCol'))
               ->addColumn(new LiteralExpression(10, 'intExpr'))
               ->addColumn(new LiteralExpression('text', 'textExpr'))
               ->addColumn(new LiteralExpression(true, 'boolExpr'))
               ->addColumn(new LiteralExpression(null, 'nullExpr'));

echo $printer->getQueryCommand($query) . PHP_EOL;

$parentQuery = new SelectQuery('parent');

$parentQuery = $parentQuery->addTable($query)
                           ->addColumn($query->deriveColumn(0))
                           ->addColumn($query->deriveColumn(2));

echo $printer->getQueryCommand($parentQuery) . PHP_EOL;