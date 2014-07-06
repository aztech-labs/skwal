<?php

namespace Aztech\Skwal\Visitor\Printer\Assembler;

/**
 * Assembles query parts into the correct order to generate well-formed SQL
 * for select queries.
 *
 *
 * @author thibaud
 *
 */
class Select
{

    private $selectList = array();

    private $fromClause = '';

    private $whereClause = '';

    private $groupByList = array();

    private $orderByList = array();

    private $limitClause = '';

    private $offsetClause = '';

    public function setSelectList(array $expressions = array())
    {
        $this->selectList = $expressions;
    }

    /**
     * @param string $statement
     */
    public function setFromClause($statement)
    {
        $this->fromClause = $statement;
    }

    /**
     * @param string $statement
     */
    public function setWhereClause($statement)
    {
        $this->whereClause = $statement;
    }

    public function setGroupByList(array $expressions = array())
    {
        $this->groupByList = $expressions;
    }

    public function setOrderByList(array $expression = array())
    {
        $this->orderByList = $expression;
    }

    public function setLimitClause($limitStatement, $offsetStatement)
    {
        $this->limitClause = $limitStatement;
        $this->offsetStatement = $offsetStatement;
    }

    public function getAssembledStatement()
    {
        $command = '';
        
        $this->appendSelectList($command);
        $this->appendFromClause($command);
        $this->appendWhereIfNecessary($command);
        $this->appendGroupByIfNecessary($command);
        $this->appendOrderByIfNecessary($command);
        
        return $command;
    }

    /**
     * @param string $command
     */
    private function appendSelectList(&$command)
    {
        if (empty($this->selectList)) {
            throw new \RuntimeException('Select list cannot be empty.');
        }
        
        $command .= 'SELECT ' . implode(', ', $this->selectList);
    }

    private function appendFromClause(&$command)
    {
        if (trim($this->fromClause) == '') {
            throw new \RuntimeException('From clause is required.');
        }
        
        $command .= ' FROM ' . $this->fromClause;
    }

    private function appendWhereIfNecessary(&$command)
    {
        if (trim($this->whereClause) != '') {
            $command .= ' WHERE ' . $this->whereClause;
        }
    }

    private function appendGroupByIfNecessary(&$command)
    {
        if (! empty($this->groupByList)) {
            $command .= ' GROUP BY ' . implode(', ', $this->groupByList);
        }
    }

    private function appendOrderByIfNecessary(&$command)
    {
        if (count($this->orderByList)) {
            $command .= ' ORDER BY ' . implode(', ', $this->orderByList);
        }
    }
}
