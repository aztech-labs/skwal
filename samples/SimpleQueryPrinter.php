<?php
use Skwal\TableReference;
use Skwal\SelectQuery;
use Skwal\Expression\LiteralExpression;
use Skwal\Condition\ComparisonPredicate;
use Skwal\CompOp;
use Skwal\Query\Select;
use Skwal\OrderBy;
use Skwal\Query\ScalarSelect;

include __DIR__ . '/../Loader.php';

$printer = new Skwal\Visitor\Printer\Query();
$table = new TableReference('test');
$query = new Select('childQuery');

$query = $query->setTable($table)
    ->addColumn($table->getColumn('anyCol', 'aliasedCol'))
    ->addColumn($table->getColumn('unaliasedCol'))
    ->addColumn(new LiteralExpression(10, 'intExpr'))
    ->addColumn(new LiteralExpression('text', 'textExpr'))
    ->addColumn(new LiteralExpression(true, 'boolExpr'))
    ->addColumn(new LiteralExpression(null, 'nullExpr'));

$query = $query->groupBy($query->getColumn(0))
    ->groupBy($query->getColumn(1))
    ->groupBy($query->getColumn(2));

$condition = new ComparisonPredicate($query->deriveColumn(0), CompOp::Equals, new LiteralExpression(10));
$condition = $condition->BOr($condition)->BAnd($condition);

$scalar = new ScalarSelect('scalar');
$scalar = $scalar->setTable($table)
    ->addColumn($table->getColumn('scalarColumn'));

$parentQuery = new Select('parent');
$parentQuery = $parentQuery->setTable($query)
    ->addColumn($query->deriveColumn(0))
    ->addColumn($query->deriveColumn(2))
    ->addColumn($scalar)
    ->setCondition($condition)
    ->orderBy(new OrderBy($query->deriveColumn(0)));

echo '------------------------' . PHP_EOL;
echo $printer->printQuery($query) . PHP_EOL;
echo '------------------------' . PHP_EOL;
echo $printer->printQuery($parentQuery) . PHP_EOL;
echo '------------------------' . PHP_EOL;
