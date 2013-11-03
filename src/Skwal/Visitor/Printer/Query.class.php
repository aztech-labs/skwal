<?php
namespace Skwal\Visitor\Printer
{
    class Query implements \Skwal\Visitor\Query
    {

        /**
         *
         * @var \SplStack
         */
        private $queryStack = null;

        /**
         *
         * @var \Skwal\Visitor\Printer\Expression
         */
        private $expressionVisitor;

        /**
         *
         * @var \Skwal\Visitor\Printer\Correlatable
         */
        private $correlationVisitor;

        /**
         *
         * @var \Skwal\Visitor\Printer\Predicate
         */
        private $predicateVisitor;

        /**
         * Initializes a new instance with default dependencies set.
         */
        public function __construct()
        {
            $this->queryStack = new \SplStack();
            $this->expressionVisitor = $this->buildExpressionVisitor();
            $this->correlationVisitor = $this->buildCorrelationVisitor();
            $this->predicateVisitor  = $this->buildPredicateVisitor();
        }

        /**
         * Sets the visitor instance for used to output expressions.
         * @param \Skwal\Visitor\Printer\Expression $visitor
         * @codeCoverageIgnore
         */
        public function setExpressionVisitor(\Skwal\Visitor\Printer\Expression $visitor)
        {
            $this->expressionVisitor = $visitor;
        }

        /**
         * Sets the visitor instance for used to output correlated references.
         * @param \Skwal\Visitor\Printer\Table $visitor
         * @codeCoverageIgnore
         */
        public function setCorrelationVisitor(\Skwal\Visitor\Printer\Table $visitor)
        {
            $this->correlationVisitor = $visitor;
        }

        /**
         * Sets the visitor instance for used to output predicates.
         * @param \Skwal\Visitor\Printer\Predicate $visitor
         * @codeCoverageIgnore
         */
        public function setPredicateVisitor(\Skwal\Visitor\Printer\Predicate $visitor)
        {
            $this->predicateVisitor = $visitor;
        }

        /**
         *
         * @return \Skwal\Visitor\Printer\Expression
         */
        private function buildExpressionVisitor()
        {
            $visitor = new Expression();

            return $visitor;
        }

        /**
         *
         * @return \Skwal\Visitor\Printer\Table
         */
        private function buildCorrelationVisitor()
        {
            $visitor = new Correlatable();

            $visitor->setQueryVisitor($this);

            return $visitor;
        }

        /**
         *
         * @return \Skwal\Visitor\Printer\Predicate
         */
        private function buildPredicateVisitor()
        {
            $visitor = new Predicate();

            $visitor->setExpressionPrinter($this->expressionVisitor);

            return $visitor;
        }

        /**
         * Generates the SQL command for a given query.
         * @param \Skwal\Query $query
         * @return mixed
         */
        public function printQuery(\Skwal\Query $query)
        {
            $this->visit($query);

            return $this->queryStack->pop();
        }

        /**
         * (non-PHPdoc)
         * @see \Skwal\Visitor\Query::visit()
         */
        public function visit(\Skwal\Query $query)
        {
            $query->acceptQueryVisitor($this);
        }

        /**
         * (non-PHPdoc)
         * @see \Skwal\Visitor\Query::visitSelect()
         */
        public function visitSelect(\Skwal\Query\Select $query)
        {
            $assembler = new \Skwal\Visitor\Printer\Assembler\Select();

            $this->appendSelectList($assembler, $query);
            $this->appendFromClause($assembler, $query);
            $this->appendWhereClauseIfNecessary($assembler, $query);
            $this->appendGroupByList($assembler, $query);
            $this->appendOrderByList($assembler, $query);

            $this->queryStack->push($assembler->getAssembledStatement());
        }

        /**
         * Adds the select list elements of a query to a query assembler.
         * @param \Skwal\Visitor\Printer\Assembler\Select $assembler
         * @param \Skwal\Query\Select $query
         */
        private function appendSelectList(\Skwal\Visitor\Printer\Assembler\Select $assembler, \Skwal\Query\Select $query)
        {
            $this->expressionVisitor->useAliases(true);

            $selectList = array();

            foreach ($query->getColumns() as $column) {
                $selectList[] = $this->expressionVisitor->printExpression($column);
            }

            $assembler->setSelectList($selectList);
        }

        /**
         * Adds the from clause of a query to a query assembler.
         * @param \Skwal\Visitor\Printer\Assembler\Select $assembler
         * @param \Skwal\Query\Select $query
         */
        private function appendFromClause(\Skwal\Visitor\Printer\Assembler\Select $assembler, \Skwal\Query\Select $query)
        {
            $fromStatement = $this->correlationVisitor->printCorrelatableStatement($query->getTable());
            $assembler->setFromClause($fromStatement);
        }

        /**
         * Adds the where clause of a query to a query assembler if the given query has a selection condition.
         * @param \Skwal\Visitor\Printer\Assembler\Select $assembler
         * @param \Skwal\Query\Select $query
         */
        private function appendWhereClauseIfNecessary(\Skwal\Visitor\Printer\Assembler\Select $assembler, \Skwal\Query\Select $query)
        {
            if ($query->getCondition() != null) {
                $whereClause = $this->predicateVisitor->printPredicateStatement($query->getCondition());
                $assembler->setWhereClause($whereClause);
            }
        }

        /**
         * Adds the group by list from a query to a query assembler.
         * @param \Skwal\Visitor\Printer\Assembler\Select $assembler
         * @param \Skwal\Query\Select $query
         */
        private function appendGroupByList(\Skwal\Visitor\Printer\Assembler\Select $assembler, \Skwal\Query\Select $query)
        {
            $this->expressionVisitor->useAliases(false);

            $groupByList = array();

            foreach ($query->getGroupingColumns() as $groupingColumn) {
                $groupByList[] = $this->expressionVisitor->printExpression($groupingColumn);
            }

            $assembler->setGroupByList($groupByList);
        }

        private function appendOrderByList(\Skwal\Visitor\Printer\Assembler\Select $assembler, \Skwal\Query\Select $query)
        {
            $this->expressionVisitor->useAliases(false);

            $orderByList = array();

            foreach ($query->getSortingColumns() as $sortingColumn) {
                $direction = ($sortingColumn->isDescending()) ? ' DESC' : ' ASC';
                $orderByList[] = $this->expressionVisitor->printExpression($sortingColumn->getExpression()) . $direction;
            }

            $assembler->setOrderByList($orderByList);
        }

        public function visitUpdate()
        {
            throw new \RuntimeException('Not implemented');
        }

        public function visitDelete()
        {
            throw new \RuntimeException('Not implemented');
        }

        public function visitInsert()
        {
            throw new \RuntimeException('Not implemented');
        }
    }
}