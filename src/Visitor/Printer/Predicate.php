<?php
namespace Aztech\Skwal\Visitor\Printer
{

    use Aztech\Skwal\Condition\AndPredicate;
    use Aztech\Skwal\Condition\OrPredicate;
    use Aztech\Skwal\Condition\ComparisonPredicate;

    /**
     * Generates SQL for predicate expressions.
     * 
     * @author thibaud
     *
     */
    class Predicate implements \Aztech\Skwal\Visitor\Predicate
    {

        private $expressionPrinter;

        private $predicateStatement = '';

        public function setExpressionPrinter(\Aztech\Skwal\Visitor\Printer\Expression $expressionPrinter)
        {
            $this->expressionPrinter = $expressionPrinter;
        }

        public function printPredicateStatement(\Aztech\Skwal\Condition\Predicate $predicate)
        {
            $predicate->acceptPredicateVisitor($this);
            
            return $this->predicateStatement;
        }

        public function visit(\Aztech\Skwal\Condition\Predicate $predicate)
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