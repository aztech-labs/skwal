<?php

/**
 * Literal value expression. This class is immutable meaning any setters/modifier methods will return
 * a new instance reflecting the changes.
 * @author thibaud
 *
 */
class Skwal_LiteralExpression implements Skwal_AliasExpression, Skwal_ValueExpression
{

    /**
     *
     * @var mixed
     */
    private $value;

    /**
     *
     * @var string
     */
    private $alias;

    /**
     * Initialize a new instance using a value and optionally an alias.
     *
     * @param mixed $value
     * @param string $alias
     */
    public function __construct($value, $alias = '')
    {
        $this->value = $value;
        $this->alias = $alias;
    }

    /**
     * (non-PHPdoc)
     *
     * @see Skwal_ValueExpression::getValue()
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * (non-PHPdoc)
     *
     * @see Skwal_AliasExpression::getAlias()
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * Sets the alias.
     * @param string $alias Name by which the literal can be referenced in contexts
     * where it acts as a derived column.
     * @return Skwal_LiteralExpression
     */
    public function setAlias($alias)
    {
        $clone = clone $this;

        $clone->alias = $alias;

        return $alias;
    }

    /**
     * (non-PHPdoc)
     * @see Skwal_AliasExpression::accept()
     */
    public function acceptExpressionVisitor(Skwal_Visitor_Expression $visitor)
    {
        return $visitor->visitLiteral($this);
    }
}