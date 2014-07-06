<?php

namespace Aztech\Skwal;

use Aztech\Skwal\Expression\DerivedColumn;

/**
 * References a table in a schema.
 *
 * @author thibaud
 *
 */
class Table implements CorrelatableReference
{

    /**
     * Table's name in underlying schema.
     *
     * @var string
     */
    private $name;

    /**
     * Table's alias by which table should be referenced.
     *
     * @var string
     */
    private $alias = null;

    private $joins = array();

    /**
     * Creates a new table using a name and optionally an alias.
     *
     * @param string $name
     * @param string $alias
     * @throws InvalidArgumentException if $name is an empty string.
     */
    public function __construct($name, $alias = '')
    {
        if (! trim($name)) {
            $message = 'Argument $name is required.';
            throw new \InvalidArgumentException($message);
        }

        $this->name = trim($name);
        $this->alias = trim($alias);
    }

    /**
     * Returns the name of the table as it is defined in the table's schema.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the name of the table as it is defined in the table's schema/
     *
     * @param string $name
     * @return Aztech\Skwal_Table
     */
    public function setName($name)
    {
        return new self($name, $this->alias);
    }

    /**
     * Returns the alias for the current table or its name if none is defined.
     *
     * @return string
     */
    public function getCorrelationName()
    {
        if (empty($this->alias)) {
            return $this->name;
        }

        return $this->alias;
    }

    /**
     * Returns a column object correlated to the current table.
     *
     * @param string $name
     *            Name of the column to return.
     * @param string $alias
     *            Alias to use on the column.
     * @return \Aztech\Skwal\DerivedColumn
     */
    public function getColumn($name, $alias = '')
    {
        $column = new DerivedColumn($name, $alias);

        return $column->setTable($this);
    }

    /**
     * (non-PHPdoc)
     *
     * @see \Aztech\Skwal\CorrelatableReference::acceptCorrelatableVisitor()
     */
    public function acceptTableVisitor(\Aztech\Skwal\Visitor\TableReference $visitor)
    {
        $visitor->visitTable($this);
    }
}
