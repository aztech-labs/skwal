<?php
include __DIR__ . '/../Loader.php';

$builder = new \Skwal\Query\Builder();
$printer = new \Skwal\Visitor\Printer\Query();

$exprs = $builder->exprs();

$builder->select('table')
    ->addColumn('column')
    ->addColumn('column', 'alias')
    ->join('joinedTable')
    ->on($exprs->equals($builder->getColumn('column'), $builder->getTable('joinedTable')->getColumn('joinColumn')))
    ->where($exprs->greaterThan($builder->getColumn('column'), $exprs->int(10)))
    ->where($exprs->equals($builder->getColumn('column'), $exprs->param('column')));

$query = $builder->getQuery();

echo PHP_EOL . $printer->printQuery($query);
echo PHP_EOL . PHP_EOL;