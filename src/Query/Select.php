<?php

namespace Aztech\Skwal\Query;

use Aztech\Skwal\Expression\AliasExpression;
use Aztech\Skwal\Expression\DerivedColumn;
use Aztech\Skwal\Condition\Predicate;
use Aztech\Skwal\CorrelatableReference;
use Aztech\Skwal\Query;
use Aztech\Skwal\Expression;
use Aztech\Skwal\OrderBy;

/**
 * Defines a select query.
 *
 * @author thibaud
 *        
 * @todo Review accept function names to allow implementation of multiple
 *       Visitor patterns.
 */
class Select implements CorrelatableReference, Query
{

    /**
     *
     * @var string
     */
    private $alias;

    /**
     *
     * @var \Aztech\Skwal\TableReference
     */
    private $table = null;

    /**
     *
     * @var \Aztech\Skwal\Expression\AliasExpression[]
     */
    private $columns = array();

    /**
     *
     * @var \Aztech\Skwal\Expression\AliasExpression[]
     */
    private $aggregateColumns = array();

    /**
     *
     * @var multitype:\Aztech\Skwal\OrderBy
     */
    private $sortList = array();

    /**
     *
     * @var \Aztech\Skwal\Condition\Predicate
     */
    private $condition;

    /**
     *
     * @var bool
     */
    private $distinct = false;

    /**
     * Initialize a new instance with an optional alias.
     *
     * @param string $alias            
     */
    public function __construct($alias = '')
    {
        $this->alias = $alias;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \Aztech\Skwal\CorrelatableReference::getCorrelationName()
     */
    public function getCorrelationName()
    {
        return $this->alias;
    }

    /**
     * Adds a correlated reference (table, nested query...) to the current query.
     *
     * @param \Aztech\Skwal\TableReference $table            
     * @return \Aztech\Skwal\Query\Select A new query with the added table
     *         in its from clause.
     * @todo Avoid duplicate table cloning
     */
    public function setTable(\Aztech\Skwal\TableReference $table)
    {
        $clone = clone $this;
        
        $clone->table = $table;
        
        return $clone;
    }

    /**
     *
     * @return \Aztech\Skwal\CorrelatableReference First table found in from clause,
     *         or boolean false if no tables have been added.
     */
    public function getTable()
    {
        return $this->table;
    }

    public function addJoin(CorrelatableReference $reference, Predicate $condition)
    {
        $this->joins[] = array(
            $reference,
            $condition
        );
    }

    public function getJoinedTables()
    {
        return array_map(function ($element)
        {
            return $element[0];
        }, $this->joins);
    }

    /**
     * Indicates whether columns can be addded to the query.
     *
     * @return boolean
     */
    public function canAddColumn()
    {
        return true;
    }

    /**
     * Adds a derived column to the select list of the query.
     *
     * @param \Aztech\Skwal\Expression\AliasExpression $column            
     * @return \Aztech\Skwal\Query\Select A new query with the added column in its select list.
     * @throws \Exception if no more columns can be added to the query.
     */
    public function addColumn(AliasExpression $column)
    {
        $clone = clone $this;
        
        $clone->columns[] = $column;
        
        return $clone;
    }

    public function groupBy(AliasExpression $column)
    {
        $clone = clone $this;
        
        $clone->aggregateColumns[] = $column;
        
        return $clone;
    }

    public function orderBy(OrderBy $column)
    {
        $clone = clone $this;
        
        $clone->sortList[] = $column;
        
        return $clone;
    }

    /**
     * @param integer $index
     */
    private function validateColumnIndex($index)
    {
        if ($index < 0 || $index >= count($this->columns)) {
            throw new \OutOfRangeException('$index is out of range.');
        }
    }

    /**
     * Derives an expression in the query's select clause as a column of the query's associated resultset.
     *
     * @param int $index            
     * @throws \OutOfRangeException
     * @return multitype:\Aztech\Skwal\Expression\AliasExpression
     */
    public function deriveColumn($index)
    {
        $this->validateColumnIndex($index);
        
        $column = new DerivedColumn($this->columns[$index]->getAlias());
        
        return $column->setTable($this);
    }

    /**
     * Derives all expressions in the query's select clause as columns of the query's associated resultset.
     *
     * @return multitype:Ambigous <\Aztech\Skwal\Query\multitype:\Aztech\Skwal\Expression\AliasExpression, \Aztech\Skwal\Expression\DerivedColumn>
     */
    public function deriveColumns()
    {
        $derived = array();
        
        for ($i = 0; $i < count($this->columns); $i ++) {
            $derived[] = $this->deriveColumn($i);
        }
        
        return $derived;
    }

    /**
     * Gets a column identified by its index
     *
     * @param int $index            
     * @throws \OutOfRangeException If $index is out of the column's count range.
     * @return multitype:\Aztech\Skwal\Aztech\Skwal_AliasExpression
     */
    public function getColumn($index)
    {
        $this->validateColumnIndex($index);
        
        return $this->columns[$index];
    }

    /**
     *
     * @param Predicate $predicate            
     * @return \Aztech\Skwal\Query\Select
     */
    public function setCondition(Predicate $predicate)
    {
        $clone = clone $this;
        
        $clone->condition = $predicate;
        
        return $clone;
    }

    /**
     *
     * @return \Aztech\Skwal\Condition\Predicate
     */
    public function getCondition()
    {
        return $this->condition;
    }

    /**
     *
     * @return AliasExpression[]
     */
    public function getColumns()
    {
        return $this->columns;
    }

    /**
     *
     * @return multitype:\Aztech\Skwal\Expression\AliasExpression
     */
    public function getGroupingColumns()
    {
        return $this->aggregateColumns;
    }

    /**
     *
     * @return \Aztech\Skwal\Query\multitype:\Aztech\Skwal\OrderBy
     */
    public function getSortingColumns()
    {
        return $this->sortList;
    }

    /**
     *
     * @return \Aztech\Skwal\Query\Select
     */
    public function selectDistinct()
    {
        if (! $this->distinct) {
            $clone = clone $this;
            $clone->distinct = true;
            return $clone;
        }
        
        return $this;
    }

    /**
     *
     * @return \Aztech\Skwal\Query\Select
     */
    public function selectAll()
    {
        if ($this->distinct) {
            $clone = clone $this;
            $clone->distinct = false;
            return $clone;
        }
        
        return $this;
    }

    public function isDistinct()
    {
        return $this->distinct;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \Aztech\Skwal\Query::acceptQueryVisitor()
     */
    public function acceptQueryVisitor(\Aztech\Skwal\Visitor\Query $visitor)
    {
        $visitor->visitSelect($this);
    }

    /**
     * (non-PHPdoc)
     *
     * @see \Aztech\Skwal\CorrelatableReference::acceptCorrelatableVisitor()
     */
    public function acceptTableVisitor(\Aztech\Skwal\Visitor\TableReference $visitor)
    {
        $visitor->visitQuery($this);
    }
}
