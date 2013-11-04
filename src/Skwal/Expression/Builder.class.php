<?php
namespace Skwal\Expression
{

    use Skwal\Condition\ComparisonPredicate;
    use Skwal\CompOp;
    use Skwal\Expression;

    /**
     *
     * @author thibaud
     *
     */
    class Builder
    {

        public function equals(Expression $left, Expression $right)
        {
            return new ComparisonPredicate($left, CompOp::Equals, $right);
        }

        public function notEquals(Expression $left, Expression $right)
        {
            return new ComparisonPredicate($left, CompOp::NotEquals, $right);
        }

        public function greaterThan(Expression $left, Expression $right)
        {
            return new ComparisonPredicate($left, CompOp::GreaterThan, $right);
        }

        public function greaterThanEq(Expression $left, Expression $right)
        {
            return new ComparisonPredicate($left, CompOp::GreaterThanEq, $right);
        }

        public function lessThan(Expression $left, Expression $right)
        {
            return new ComparisonPredicate($left, CompOp::LessThan, $right);
        }

        public function lessThanEq(Expression $left, Expression $right)
        {
            return new ComparisonPredicate($left, CompOp::LessThanEq, $right);
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
}