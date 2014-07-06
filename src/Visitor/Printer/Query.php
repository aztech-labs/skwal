<?php

namespace Aztech\Skwal\Visitor\Printer;

use Aztech\Skwal\OrderBy;

/**
 * Generates SQL from a given query.
 * 
 * @author thibaud
 *
 */
class Query implements \Aztech\Skwal\Visitor\Query
{

    /**
     *
     * @var \SplStack
     */
    private $queryStack = null;

    /**
     *
     * @var \Aztech\Skwal\Visitor\Printer\Expression
     */
    private $expressionVisitor;

    /**
     *
     * @var \Aztech\Skwal\Visitor\Printer\TableReference
     */
    private $tableReferenceVisitor;

    /**
     *
     * @var \Aztech\Skwal\Visitor\Printer\Predicate
     */
    private $predicateVisitor;

    /**
     * Initializes a new instance with default dependencies set.
     */
    public function __construct()
    {
        $this->queryStack = new \SplStack();
        $this->expressionVisitor = $this->buildExpressionVisitor();
        $this->predicateVisitor = $this->buildPredicateVisitor();
        $this->tableReferenceVisitor = $this->buildTableReferenceVisitor();
    }

    /**
     * Sets the visitor instance for used to output expressions.
     *
     * @param \Aztech\Skwal\Visitor\Printer\Expression $visitor
     * @codeCoverageIgnore Cannot be tested as there are no getters
     */
    public function setExpressionVisitor(\Aztech\Skwal\Visitor\Printer\Expression $visitor)
    {
        $this->expressionVisitor = $visitor;
    }

    /**
     * Sets the visitor instance for used to output correlated references.
     *
     * @param \Aztech\Skwal\Visitor\Printer\Table $visitor
     * @codeCoverageIgnore Cannot be tested as there are no getters
     */
    public function setTableReferenceVisitor(\Aztech\Skwal\Visitor\Printer\Table $visitor)
    {
        $this->tableReferenceVisitor = $visitor;
    }

    /**
     * Sets the visitor instance for used to output predicates.
     *
     * @param \Aztech\Skwal\Visitor\Printer\Predicate $visitor
     * @codeCoverageIgnore
     */
    public function setPredicateVisitor(\Aztech\Skwal\Visitor\Printer\Predicate $visitor)
    {
        $this->predicateVisitor = $visitor;
    }

    /**
     *
     * @return \Aztech\Skwal\Visitor\Printer\Expression
     */
    private function buildExpressionVisitor()
    {
        $visitor = new Expression();
        
        $visitor->setQueryPrinter($this);
        
        return $visitor;
    }

    /**
     *
     * @return TableReference
     */
    private function buildTableReferenceVisitor()
    {
        $visitor = new TableReference();
        
        $visitor->setQueryVisitor($this);
        $visitor->setPredicateVisitor($this->predicateVisitor);
        
        return $visitor;
    }

    /**
     *
     * @return \Aztech\Skwal\Visitor\Printer\Predicate
     */
    private function buildPredicateVisitor()
    {
        $visitor = new Predicate();
        
        $visitor->setExpressionPrinter($this->expressionVisitor);
        
        return $visitor;
    }

    /**
     * Generates the SQL command for a given query.
     *
     * @param \Aztech\Skwal\Query $query 
     * @return mixed
     */
    public function printQuery(\Aztech\Skwal\Query $query)
    {
        $this->visit($query);
        
        return $this->queryStack->pop();
    }

    /**
     * (non-PHPdoc)
     *
     * @see \Aztech\Skwal\Visitor\Query::visit()
     */
    public function visit(\Aztech\Skwal\Query $query)
    {
        $query->acceptQueryVisitor($this);
    }

    /**
     * (non-PHPdoc)
     *
     * @see \Aztech\Skwal\Visitor\Query::visitSelect()
     */
    public function visitSelect(\Aztech\Skwal\Query\Select $query)
    {
        $assembler = new \Aztech\Skwal\Visitor\Printer\Assembler\Select();
        
        $this->appendSelectList($assembler, $query);
        $this->appendFromClause($assembler, $query);
        $this->appendWhereClauseIfNecessary($assembler, $query);
        $this->appendGroupByList($assembler, $query);
        $this->appendOrderByList($assembler, $query);
        
        $this->queryStack->push($assembler->getAssembledStatement());
    }

    /**
     * Adds the select list elements of a query to a query assembler.
     *
     * @param \Aztech\Skwal\Visitor\Printer\Assembler\Select $assembler 
     * @param \Aztech\Skwal\Query\Select $query 
     */
    private function appendSelectList(\Aztech\Skwal\Visitor\Printer\Assembler\Select $assembler,\Aztech\Skwal\Query\Select $query)
    {
        $this->expressionVisitor->useAliases(true);
        
        $selectList = array();
        
        foreach ($query->getColumns() as $column) {
            $selectList[] = $this->expressionVisitor->printExpression($column);
        }
        
        $assembler->setSelectList($selectList);
    }

    /**
     * Adds the from clause of a query to a query assembler.
     *
     * @param \Aztech\Skwal\Visitor\Printer\Assembler\Select $assembler 
     * @param \Aztech\Skwal\Query\Select $query 
     */
    private function appendFromClause(\Aztech\Skwal\Visitor\Printer\Assembler\Select $assembler,\Aztech\Skwal\Query\Select $query)
    {
        $fromStatement = $this->tableReferenceVisitor->printTableStatement($query->getTable());
        $assembler->setFromClause($fromStatement);
    }

    /**
     * Adds the where clause of a query to a query assembler if the given query has a selection condition.
     *
     * @param \Aztech\Skwal\Visitor\Printer\Assembler\Select $assembler 
     * @param \Aztech\Skwal\Query\Select $query 
     */
    private function appendWhereClauseIfNecessary(\Aztech\Skwal\Visitor\Printer\Assembler\Select $assembler,\Aztech\Skwal\Query\Select $query)
    {
        if ($query->getCondition() != null) {
            $whereClause = $this->predicateVisitor->printPredicateStatement($query->getCondition());
            $assembler->setWhereClause($whereClause);
        }
    }

    /**
     * Adds the group by list from a query to a query assembler.
     *
     * @param \Aztech\Skwal\Visitor\Printer\Assembler\Select $assembler 
     * @param \Aztech\Skwal\Query\Select $query 
     */
    private function appendGroupByList(\Aztech\Skwal\Visitor\Printer\Assembler\Select $assembler,\Aztech\Skwal\Query\Select $query)
    {
        $this->expressionVisitor->useAliases(false);
        
        $groupByList = array();
        
        foreach ($query->getGroupingColumns() as $groupingColumn) {
            $groupByList[] = $this->expressionVisitor->printExpression($groupingColumn);
        }
        
        $assembler->setGroupByList($groupByList);
    }

    /**
     * Adds the sort expressions from a query to a query assembler.
     *
     * @param \Aztech\Skwal\Visitor\Printer\Assembler\Select $assembler 
     * @param \Aztech\Skwal\Query\Select $query 
     */
    private function appendOrderByList(\Aztech\Skwal\Visitor\Printer\Assembler\Select $assembler,\Aztech\Skwal\Query\Select $query)
    {
        $this->expressionVisitor->useAliases(false);
        
        $orderByList = array();
        
        foreach ($query->getSortingColumns() as $sortingColumn) {
            $direction = $this->getSortDirectionText($sortingColumn);
            $orderByList[] = $this->expressionVisitor->printExpression($sortingColumn->getExpression()) . $direction;
        }
        
        $assembler->setOrderByList($orderByList);
    }

    private function getSortDirectionText(OrderBy $sortingColumn)
    {
        return $sortingColumn->isDescending() ? ' DESC' : ' ASC';
    }

    public function visitUpdate()
    {
        throw new \RuntimeException('Not implemented');
    }

    public function visitDelete()
    {
        throw new \RuntimeException('Not implemented');
    }

    public function visitInsert()
    {
        throw new \RuntimeException('Not implemented');
    }
}
