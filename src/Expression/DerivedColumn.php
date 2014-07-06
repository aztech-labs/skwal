<?php

namespace Aztech\Skwal\Expression;

use Aztech\Skwal\CorrelatableReference;
use Aztech\Skwal\Expression;

class DerivedColumn extends AbstractExpression implements Expression, AssignableExpression
{

    private $columnName;

    private $alias;

    /**
     *
     * @var \Aztech\Skwal\CorrelatableReference
     */
    private $correlatedParent;

    public function __construct($columnName, $alias = '')
    {
        $this->columnName = trim($columnName);
        $this->alias = trim($alias);
    }

    public function getValue()
    {
        return $this->columnName;
    }

    public function getAlias()
    {
        if (empty($this->alias)) {
            return $this->columnName;
        }
        
        return $this->alias;
    }

    public function getTable()
    {
        return $this->correlatedParent;
    }

    public function setTable(CorrelatableReference $reference = null)
    {
        // Not using cloning to avoid unnecessary cloning of the attached
        // correlated reference.
        $clone = new self($this->columnName, $this->alias);
        
        $clone->correlatedParent = $reference;
        
        return $clone;
    }

    public function __clone()
    {
        if ($this->correlatedParent != null) {
            $this->correlatedParent = clone $this->correlatedParent;
        }
    }

    /**
     * (non-PHPdoc)
     *
     * @see Aztech\Skwal_AliasExpression::accept()
     */
    public function acceptExpressionVisitor(\Aztech\Skwal\Visitor\Expression $visitor)
    {
        return $visitor->visitColumn($this);
    }
}
