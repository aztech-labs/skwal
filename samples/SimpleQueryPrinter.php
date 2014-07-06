<?php
use Aztech\Skwal\Table;
use Aztech\Skwal\SelectQuery;
use Aztech\Skwal\Expression\LiteralExpression;
use Aztech\Skwal\Condition\ComparisonPredicate;
use Aztech\Skwal\CompOp;
use Aztech\Skwal\Query\Select;
use Aztech\Skwal\OrderBy;
use Aztech\Skwal\Query\ScalarSelect;
use Aztech\Skwal\Join;
use Aztech\Skwal\JoinedTable;

include __DIR__ . '/../Loader.php';

$printer = new Atech\Aztech\Skwal\Visitor\Printer\Query();
$table = new Table('test');
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
$scalar = $scalar->setTable($table)->addColumn($table->getColumn('scalarColumn'));

$scalarCondition = new ComparisonPredicate($scalar, CompOp::Equals, new LiteralExpression(20));
$condition = $scalarCondition->BAnd($condition);

$join = new Join($scalar, new ComparisonPredicate($scalar->deriveColumn(0), CompOp::Equals, new LiteralExpression(20)));

$joinedTable = new JoinedTable($query);
$joinedTable->addJoin($join);

$parentQuery = new Select('parent');
$parentQuery = $parentQuery->setTable($joinedTable)
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
