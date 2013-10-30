<?php
namespace Skwal\Visitor\Printer
{

    class Expression implements \Skwal\Visitor\Expression
    {

        private $printedExpression;

        private $useAliases = true;

        public function useAliases($useFlag)
        {
            $this->useAliases = $useFlag;
        }

        public function printExpression(\Skwal\AliasExpression $expression)
        {
            $this->visit($expression);
            
            return $this->printedExpression;
        }

        public function visit(\Skwal\AliasExpression $expression)
        {
            return $expression->acceptExpressionVisitor($this);
        }

        public function visitColumn(\Skwal\DerivedColumn $column)
        {
            $this->printedExpression = sprintf('%s.%s AS %s', $column->getTable()->getCorrelationName(), $column->getValue(), $column->getAlias());
        }

        public function visitLiteral(\Skwal\LiteralExpression $literal)
        {
            $this->printedExpression = sprintf('%s AS %s', $literal->getValue(), $literal->getAlias());
        }
    }
}