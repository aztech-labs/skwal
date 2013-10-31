<?php
namespace Skwal\Condition
{

    use Skwal\Expression\ValueExpression;

    class ComparisonPredicate extends AbstractPredicate
    {

        private $operator;

        private $leftOperand;

        private $rightOperand;

        public function __construct(ValueExpression $left, $operator, ValueExpression $right)
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
