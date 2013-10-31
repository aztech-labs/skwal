<?php

use Skwal\TableReference;
use Skwal\SelectQuery;
use Skwal\Expression\LiteralExpression;
use Skwal\Condition\ComparisonPredicate;
use Skwal\CompOp;

include __DIR__ . '/../Loader.php';

$startTime = microtime(true);

$printer = new Skwal\Visitor\Printer\Query();
$table = new TableReference('test');
$query = new SelectQuery('childQuery');

$query = $query->setTable($table)
               ->addColumn($table->getColumn('anyCol', 'aliasedCol'))
               ->addColumn($table->getColumn('unaliasedCol'))
               ->addColumn(new LiteralExpression(10, 'intExpr'))
               ->addColumn(new LiteralExpression('text', 'textExpr'))
               ->addColumn(new LiteralExpression(true, 'boolExpr'))
               ->addColumn(new LiteralExpression(null, 'nullExpr'));

echo $printer->getQueryCommand($query) . PHP_EOL;

$condition = new ComparisonPredicate($query->deriveColumn(0), CompOp::Equals, new LiteralExpression(10));
$condition = $condition->BOr($condition);
$condition = $condition->BAnd($condition);

$parentQuery = new SelectQuery('parent');
$parentQuery = $parentQuery->setTable($query)
                           ->addColumn($query->deriveColumn(0))
                           ->addColumn($query->deriveColumn(2))
                           ->setCondition($condition);

echo $printer->getQueryCommand($parentQuery) . PHP_EOL;

$endTime = microtime(true);

echo sprintf("Executed in %s s", $endTime - $startTime) . PHP_EOL;