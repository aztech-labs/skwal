<?php
namespace Skwal\Condition
{

    use Skwal\Expression;

    class ComparisonPredicate extends AbstractPredicate
    {

        private $operator;

        private $leftOperand;

        private $rightOperand;

        public function __construct(Expression $left, $operator, Expression $right)
        {
            // @todo Operator checking
            $this->operator = $operator;
            $this->leftOperand = $left;
            $this->rightOperand = $right;
        }

        public function getOperator()
        {
            return $this->operator;
        }

        public function getLeftOperand()
        {
            return $this->leftOperand;
        }

        public function getRightOperand()
        {
            return $this->rightOperand;
        }

        function acceptPredicateVisitor(\Skwal\Visitor\Predicate $visitor)
        {
        	$visitor->visitComparisonPredicate($this);
        }
    }
}
