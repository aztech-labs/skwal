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
         */
        public function setExpressionVisitor(\Skwal\Visitor\Printer\Expression $visitor)
        {
            $this->expressionVisitor = $visitor;
        }

        /**
         * Sets the visitor instance for used to output correlated references.
         * @param \Skwal\Visitor\Printer\Table $visitor
         */
        public function setCorrelationVisitor(\Skwal\Visitor\Printer\Table $visitor)
        {
            $this->correlationVisitor = $visitor;
        }

        /**
         * * Sets the visitor instance for used to output predicates.
         * @param \Skwal\Visitor\Printer\Predicate $visitor
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

        private function buildPredicateVisitor()
        {
            $visitor = new Predicate();

            $visitor->setExpressionPrinter($this->expressionVisitor);

            return $visitor;
        }

        public function printQuery(\Skwal\Query $query)
        {
            $this->visit($query);

            return $this->queryStack->pop();
        }

        public function visit(\Skwal\Query $query)
        {
            $query->acceptQueryVisitor($this);
        }

        public function visitSelect(\Skwal\Query\Select $query)
        {
            $assembler = new \Skwal\Visitor\Printer\Assembler\Select();

            $this->expressionVisitor->useAliases(true);

            $selectList = array();
            foreach ($query->getColumns() as $column) {
                $selectList[] = $this->expressionVisitor->printExpression($column);
            }
            $assembler->setSelectList($selectList);

            $fromStatement = $this->correlationVisitor->printCorrelatableStatement($query->getTable());
            $assembler->setFromClause($fromStatement);

            if ($query->getCondition() != null) {
                $whereClause = $this->predicateVisitor->printPredicateStatement($query->getCondition());
                $assembler->setWhereClause($whereClause);
            }

            $this->expressionVisitor->useAliases(false);
            $groupByList = array();
            foreach ($query->getGroupingColumns() as $groupingColumn) {
                $groupByList[] = $this->expressionVisitor->printExpression($groupingColumn);
            }
            $assembler->setGroupByList($groupByList);

            $this->queryStack->push($assembler->getAssembledStatement());
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