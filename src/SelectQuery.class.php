<?php
namespace Skwal
{

    /**
     * Defines a select query.
     *
     * @author thibaud
     *
     * @todo Review accept function names to allow implementation of multiple
     *       Visitor patterns.
     */
    class SelectQuery implements CorrelatableReference, Query
    {

        /**
         *
         * @var string
         */
        private $alias;

        /**
         *
         * @var Skwal_CorrelatedReference[]
         */
        private $tables = array();

        /**
         *
         * @var Skwal_AliasExpression[]
         */
        private $columns = array();

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
         * @see Skwal_CorrelatableReference::getCorrelationName()
         */
        public function getCorrelationName()
        {
            return $this->alias;
        }

        /**
         * Adds a correlated reference (table, nested query...) to the current query.
         *
         * @param Skwal_CorrelatableReference $table
         * @return Skwal_SelectQuery A new query with the added table
         *         in its from clause.
         */
        public function addTable(CorrelatableReference $table)
        {
            $clone = clone $this;

            $clone->tables[] = $table;

            return $clone;
        }

        /**
         *
         * @return Skwal_CorrelatableReference First table found in from clause,
         *         or boolean false if no tables have been added.
         */
        public function getFirstTable()
        {
            return reset($this->tables);
        }

        /**
         * Adds a derived column to the select list of the query.
         *
         * @param Skwal_AliasExpression $column
         * @return Skwal_SelectQuery A new query with the added column in its select list.
         */
        public function addColumn(AliasExpression $column)
        {
            $clone = clone $this;

            $clone->columns[] = $column;

            return $clone;
        }

        public function __clone()
        {
            $tableClones = array();
            $columnClones = array();

            foreach ($this->tables as $table)
                $tableClones[] = clone $table;
            foreach ($this->columns as $column)
                $columnClones[] = clone $column;

            $this->tables = $tableClones;
            $this->columns = $columnClones;
        }

        public function acceptQueryVisitor(\Skwal\Visitor\Query $visitor)
        {
            $visitor->visitSelect($query);
        }

        public function acceptCorrelatableVisitor(\Skwal\Visitor\Correlatable $visitor)
        {
            $visitor->visitQuery($query);
        }
    }
}