<?php

/**
 * References a table in a schema.
 * @author thibaud
 *
 */
class Skwal_TableReference implements Skwal_CorrelatableReference
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

    /**
     * Contains the fields referenced in the table
     *
     * @var Skwal_Field[]
     */
    private $fields = array();

    /**
     * Creates a new table using a name and optionally an alias.
     *
     * @param string $name
     * @param string $alias
     * @throws InvalidArgumentException if $name is an empty string.
     */
    public function __construct($name, $alias = '')
    {
        if (empty(trim($name))) {
            $message = 'Argument $name is required.';
            throw new InvalidArgumentException($message);
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
     * @return Skwal_TableReference
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

    public function acceptCorrelatableVisitor(Skwal_Visitor_Correlatable $visitor)
    {
        $visitor->visitTable($this);
    }
}