<?php

/**
 * Defines a select query.
 * @author thibaud
 *
 * @todo Review accept function names to allow implementation of multiple
 * Visitor patterns.
 */
class Skwal_SelectQuery implements Skwal_CorrelatableReference
{
    private $alias;
    
    private $tables = array();
    
    private $columns = array();
    
    public function __construct($alias = '')
    {
        $this->alias = $alias;
    }
    
    public function getCorrelationName()
    {
        return $this->alias;
    }
    
    public function addTable(Skwal_CorrelatableReference $table)
    {
        $clone = clone $this;
        
        $clone->tables[] = $table;
        
        return $clone;
    }
    
    /**
     * @return Skwal_CorrelatableReference First table found in from clause
     */
    public function getFirstTable()
    {
        return $this->tables[0];
    }
    
    public function addColumn(Skwal_AliasExpression $column)
    {
        $clone = clone $this;
        
        $clone->columns[] = $column;
        
        return $clone;
    }
    
    public function __clone()
    {
        $clones = array();
        foreach($this->tables as $table)
        {
            $clones[] = clone $table;
        }
        
        $this->tables = $clones;
    }
    
    public function accept(Skwal_Visitor_Query $visitor)
    {
        $visitor->visitSelect($query);
    }
    
    public function accept(Skwal_Visitor_Correlatable $visitor)
    {
        $visitor->visitQuery($query);
    }
}