<?php
namespace Skwal\Visitor\Printer
{

    use Skwal\Expression\ParameterExpression;
    use Skwal\Query\ScalarSelect;

    class Expression implements \Skwal\Visitor\Expression
    {
        /**
         *
         * @var Query
         */
        private $queryPrinter;

        private $printedExpression;

        private $useAliases = true;

        public function useAliases($useFlag)
        {
            $this->useAliases = $useFlag;
        }

        public function setQueryPrinter(Query $printer)
        {
            $this->queryPrinter = $printer;
        }

        public function printExpression(\Skwal\Expression $expression)
        {
            $this->visit($expression);

            return $this->printedExpression;
        }

        public function visit(\Skwal\Expression $expression)
        {
            $expression->acceptExpressionVisitor($this);
        }

        public function visitColumn(\Skwal\Expression\DerivedColumn $column)
        {
            $scope = $column->getTable();

            $this->printedExpression = sprintf('%s.%s', $scope->getCorrelationName(), $column->getValue());

            if ($this->useAliases) {
                $this->printedExpression .= sprintf(' AS %s', $column->getAlias());
            }
        }

        public function visitLiteral(\Skwal\Expression\LiteralExpression $literal)
        {
            $value = $literal->getValue();

            if (is_string($value)) {
                $value = "'$value'";
            }
            else
                if (is_bool($value)) {
                    $value = $value ? 'TRUE' : 'FALSE';
                }
                else
                    if ($value === null) {
                        $value = 'NULL';
                    }

            $this->printedExpression = $value;

            if ($this->useAliases && trim($literal->getAlias()) != '') {
                $this->printedExpression .= sprintf(' AS %s', $literal->getAlias());
            }
        }

        public function visitParameter(ParameterExpression $parameter)
        {
            $this->printedExpression = sprintf(':%s', $parameter->getName());
        }

        public function visitScalarSelect(ScalarSelect $query)
        {
            $this->printedExpression = sprintf('(%s) AS %s', $this->queryPrinter->printQuery($query), $query->getAlias());
        }
    }
}