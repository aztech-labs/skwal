<?php

namespace Aztech\Skwal\Visitor\Printer;

use Aztech\Skwal\Expression\ParameterExpression;
use Aztech\Skwal\Query\ScalarSelect;
use Aztech\Skwal\Expression\AssignmentExpression;

/**
 * Generates SQL for expressions.
 *
 * @author thibaud
 * @todo Fix alias rendering in where clause when using sub-queries in conditions
 */
class Expression implements \Aztech\Skwal\Visitor\Expression
{

    /**
     *
     * @var Query
     */
    private $queryPrinter;

    /**
     *
     * @var string
     */
    private $printedExpression;

    /**
     * Whether expressions that have aliases should be generated with an AS clause.
     * 
     * @var bool
     */
    private $useAliases = true;

    public function useAliases($useFlag)
    {
        $this->useAliases = $useFlag;
    }

    public function setQueryPrinter(Query $printer)
    {
        $this->queryPrinter = $printer;
    }

    public function printExpression(\Aztech\Skwal\Expression $expression)
    {
        $this->visit($expression);
        
        return $this->printedExpression;
    }

    public function visit(\Aztech\Skwal\Expression $expression)
    {
        $expression->acceptExpressionVisitor($this);
    }

    public function visitColumn(\Aztech\Skwal\Expression\DerivedColumn $column)
    {
        $scope = $column->getTable();
        
        $this->printedExpression = sprintf('%s.%s', $scope->getCorrelationName(), $column->getValue());
        
        if ($this->useAliases && trim($column->getAlias()) != '') {
            $this->printedExpression .= sprintf(' AS %s', $column->getAlias());
        }
    }

    public function visitLiteral(\Aztech\Skwal\Expression\LiteralExpression $literal)
    {
        $value = $literal->getValue();
        
        if (is_string($value)) {
            $value = "'$value'";
        }
        elseif (is_bool($value)) {
            $value = $value ? 'TRUE' : 'FALSE';
        }
        elseif ($value === null) {
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
        $this->printedExpression = sprintf('(%s)', $this->queryPrinter->printQuery($query), $query->getAlias());
        
        if ($this->useAliases && trim($query->getAlias() != '')) {
            $this->printedExpression .= sprintf(' AS %s', $query->getAlias());
        }
    }

    public function visitAssignmentExpression(AssignmentExpression $assignment)
    {}
}
