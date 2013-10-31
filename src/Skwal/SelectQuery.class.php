<?php
namespace Skwal
{
    use Skwal\Expression\AliasExpression;
    use Skwal\Expression\DerivedColumn;
				    
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
        
        private function validateColumnIndex($index)
        {
            if ($index < 0 || $index >= count($this->columns)) {
                throw new \OutOfRangeException('$index is out of range.');
            }
        }
        
        /**
         * Derives a column from an expression in the query's select clause.
         * @param int $index
         * @throws \OutOfRangeException
         * @return multitype:\Skwal\Skwal_AliasExpression
         */
        public function deriveColumn($index)
        {
            $this->validateColumnIndex($index);
            
            $column = new DerivedColumn($this->columns[$index]->getAlias());
            
            return $column->setTable($this);
        }
        
        public function deriveColumns()
        {
            $derived = array();
            
            for ($i = 0; $i < count($this->columns); $i++) {
                $derived[] = $this->deriveColumn($i);
            }
            
            return $derived;
        }

        /**
         * Gets a column identified by its index
         * @param int $index
         * @throws \OutOfRangeException If $index is out of the column's count range.
         * @return multitype:\Skwal\Skwal_AliasExpression
         */
        public function getColumn($index)
        {
            $this->validateColumnIndex($index);
        
            return $this->columns[$index];
        }
        
        /**
         *
         * @return \Skwal\Skwal_AliasExpression[]
         */
        public function getColumns()
        {
            return $this->columns;
        }

        public function __clone()
        {
            $this->cloneColumns();
            $this->cloneTables();
        }
        
        private function cloneColumns()
        {
            $columnClones = array();
            
            foreach ($this->columns as $column)
                $columnClones[] = clone $column;
            
            $this->columns = $columnClones;
        }
        
        private function cloneTables()
        {
            $tableClones = array();
            
            
            foreach ($this->tables as $table)
                $tableClones[] = clone $table;
            
            $this->tables = $tableClones;
        }

        public function acceptQueryVisitor(\Skwal\Visitor\Query $visitor)
        {
            $visitor->visitSelect($this);
        }

        public function acceptCorrelatableVisitor(\Skwal\Visitor\Correlatable $visitor)
        {
            $visitor->visitQuery($this);
        }
    }
}   