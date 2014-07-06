<?php

namespace Aztech\Skwal\Expression;

use Aztech\Skwal\Condition\ComparisonPredicate;
use Aztech\Skwal\CompOp;
use Aztech\Skwal\Expression;

/**
 *
 * @author thibaud
 *        
 */
class Builder
{

    public function equals(Expression $left, Expression $right)
    {
        return new ComparisonPredicate($left, CompOp::EQUAL, $right);
    }

    public function notEquals(Expression $left, Expression $right)
    {
        return new ComparisonPredicate($left, CompOp::NOT_EQUAL, $right);
    }

    public function greaterThan(Expression $left, Expression $right)
    {
        return new ComparisonPredicate($left, CompOp::GREATER_THAN, $right);
    }

    public function greaterThanEq(Expression $left, Expression $right)
    {
        return new ComparisonPredicate($left, CompOp::GREATER_THANEq, $right);
    }

    public function lessThan(Expression $left, Expression $right)
    {
        return new ComparisonPredicate($left, CompOp::LESS_THAN, $right);
    }

    public function lessThanEq(Expression $left, Expression $right)
    {
        return new ComparisonPredicate($left, CompOp::LESS_THANEq, $right);
    }

    public function assign(AssignableExpression $assignee, AliasExpression $value)
    {
        return new AssignmentExpression($assignee, $value);
    }

    public function int($value, $alias = '')
    {
        return new LiteralExpression($value, $alias);
    }

    public function string($value, $alias = '')
    {
        return new LiteralExpression($value, $alias);
    }

    public function double($value, $alias = '')
    {
        return new LiteralExpression($value, $alias);
    }

    public function float($value, $alias = '')
    {
        return new LiteralExpression($value, $alias);
    }

    public function param($name)
    {
        return new ParameterExpression($name);
    }
}
