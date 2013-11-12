<?php
namespace Skwal\Visitor\Printer
{

    use Skwal\Condition\AndPredicate;
    use Skwal\Condition\OrPredicate;
    use Skwal\Condition\ComparisonPredicate;

    /**
     * Generates SQL for predicate expressions.
     * 
     * @author thibaud
     *
     */
    class Predicate implements \Skwal\Visitor\Predicate
    {

        private $expressionPrinter;

        private $predicateStatement = '';

        public function setExpressionPrinter(\Skwal\Visitor\Printer\Expression $expressionPrinter)
        {
            $this->expressionPrinter = $expressionPrinter;
        }

        public function printPredicateStatement(\Skwal\Condition\Predicate $predicate)
        {
            $predicate->acceptPredicateVisitor($this);
            
            return $this->predicateStatement;
        }

        public function visit(\Skwal\Condition\Predicate $predicate)
        {
            $predicate->acceptPredicateVisitor($this);
        }

        public function visitAndPredicate(AndPredicate $predicate)
        {
            $first = $this->printPredicateStatement($predicate->getFirstPredicate());
            $second = $this->printPredicateStatement($predicate->getSecondPredicate());
            
            $this->predicateStatement = sprintf('(%s AND %s)', $first, $second);
        }

        public function visitOrPredicate(OrPredicate $predicate)
        {
            $first = $this->printPredicateStatement($predicate->getFirstPredicate());
            $second = $this->printPredicateStatement($predicate->getSecondPredicate());
            
            $this->predicateStatement = sprintf('(%s OR %s)', $first, $second);
        }

        public function visitComparisonPredicate(ComparisonPredicate $predicate)
        {
            $this->expressionPrinter->useAliases(false);
            
            $left = $this->expressionPrinter->printExpression($predicate->getLeftOperand());
            $right = $this->expressionPrinter->printExpression($predicate->getRightOperand());
            $operand = $predicate->getOperator();
            
            $this->predicateStatement = sprintf('%s %s %s', $left, $operand, $right);
        }
    }
}