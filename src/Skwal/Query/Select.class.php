<?php
namespace Skwal\Query
{

    use Skwal\Expression\AliasExpression;
    use Skwal\Expression\DerivedColumn;
    use Skwal\Condition\Predicate;
    use Skwal\CorrelatableReference;
    use Skwal\Query;
    use Skwal\Expression;
use Skwal\OrderBy;

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
         * @var \Skwal\CorrelatableReference
         */
        private $table = null;

        /**
         *
         * @var \Skwal\Expression\AliasExpression[]
         */
        private $columns = array();

        /**
         *
         * @var \Skwal\Expression\AliasExpression[]
         */
        private $aggregateColumns = array();

        /**
         *
         * @var multitype:\Skwal\OrderBy
         */
        private $sortList = array();

        /**
         *
         * @var \Skwal\Condition\Predicate
         */
        private $condition;

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
         * @see \Skwal\CorrelatableReference::getCorrelationName()
         */
        public function getCorrelationName()
        {
            return $this->alias;
        }

        /**
         * Adds a correlated reference (table, nested query...) to the current query.
         *
         * @param \Skwal\CorrelatableReference $table
         * @return \Skwal\Query\Select A new query with the added table
         *         in its from clause.
         * @todo Avoid duplicate table cloning
         */
        public function setTable(\Skwal\CorrelatableReference $table)
        {
            $clone = clone $this;

            $clone->table = $table;

            return $clone;
        }

        /**
         *
         * @return \Skwal\CorrelatableReference First table found in from clause,
         *         or boolean false if no tables have been added.
         */
        public function getTable()
        {
            return $this->table;
        }

        /**
         * Adds a derived column to the select list of the query.
         *
         * @param \Skwal\Expression\AliasExpression $column
         * @return \Skwal\Query\Select A new query with the added column in its select list.
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
         * @return multitype:\Skwal\Expression\AliasExpression
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
         * @return multitype:Ambigous <\Skwal\Query\multitype:\Skwal\Expression\AliasExpression, \Skwal\Expression\DerivedColumn>
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
         * @return multitype:\Skwal\Skwal_AliasExpression
         */
        public function getColumn($index)
        {
            $this->validateColumnIndex($index);

            return $this->columns[$index];
        }

        /**
         *
         * @param Predicate $predicate
         * @return \Skwal\Query\Select
         */
        public function setCondition(Predicate $predicate)
        {
            $clone = clone $this;

            $clone->condition = $predicate;

            return $clone;
        }

        /**
         *
         * @return \Skwal\Condition\Predicate
         */
        public function getCondition()
        {
            return $this->condition;
        }

        /**
         *
         * @return \Skwal\Skwal_AliasExpression[]
         */
        public function getColumns()
        {
            return $this->columns;
        }

        /**
         *
         * @return multitype:\Skwal\Expression\AliasExpression
         */
        public function getGroupingColumns()
        {
            return $this->aggregateColumns;
        }

        /**
         *
         * @return \Skwal\Query\multitype:\Skwal\OrderBy
         */
        public function getSortingColumns()
        {
            return $this->sortList;
        }

        /**
         * (non-PHPdoc)
         *
         * @see \Skwal\Query::acceptQueryVisitor()
         */
        public function acceptQueryVisitor(\Skwal\Visitor\Query $visitor)
        {
            $visitor->visitSelect($this);
        }

        /**
         * (non-PHPdoc)
         *
         * @see \Skwal\CorrelatableReference::acceptCorrelatableVisitor()
         */
        public function acceptCorrelatableVisitor(\Skwal\Visitor\Correlatable $visitor)
        {
            $visitor->visitQuery($this);
        }
    }
}