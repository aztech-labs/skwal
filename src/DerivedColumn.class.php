<?php

class Skwal_DerivedColumn implements Skwal_AliasExpression
{
    private $columnName;

    private $alias;

    private $correlatedParent;

    public function __construct($columnName, $alias = '')
    {
        $this->columnName = $columnName;
        $this->alias = $alias;
    }

    public function getValue()
    {
        return $this->columnName;
    }

    public function getAlias()
    {
        return $this->alias;
    }

    public function setTable(Skwal_CorrelatableReference $reference = null)
    {
        // Not using cloning to avoid unnecessary cloning of the attached
        // correlated reference.
        $clone = new self($this->columnName, $this->alias);

        $clone->correlatedParent = $reference;

        return $clone;
    }

    public function __clone()
    {
        $this->correlatedParent = clone $this->correlatedParent;
    }

    /**
     * (non-PHPdoc)
     * @see Skwal_AliasExpression::accept()
     */
    public function acceptExpressionVisitor(Skwal_Visitor_Expression $visitor)
    {
        return $visitor->visitColumn($this);
    }
}