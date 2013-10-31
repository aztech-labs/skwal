<?php
namespace Skwal\Condition
{
    use Skwal\Expression\ValueExpression;

    class ComparisonPredicate extends AbstractPredicate
    {

        private $operator;

        private $leftOperand;

        private $rightOperand;

        public function __construct(ValueExpression $expression, $operator, ValueExpression $expression)
        {
            // @todo Operator checking
            $this->operator = $operator;
            $this->leftOperand = $expression;
            $this->rightOperand = $expression;
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
    }
}
