<?php
namespace Skwal\Visitor\Printer
{

    class TableReference implements \Skwal\Visitor\TableReference
    {
        private $queryVisitor;

        private $predicateVisitor;

        private $fromStatement = '';

        /**
         *
         * @param \Skwal\Visitor\Printer\Query $visitor
         * @codeCoverageIgnore
         */
        public function setQueryVisitor(\Skwal\Visitor\Printer\Query $visitor)
        {
            $this->queryVisitor = $visitor;
        }

        public function setPredicateVisitor(\Skwal\Visitor\Printer\Predicate $predicateVisitor)
        {
            $this->predicateVisitor = $predicateVisitor;
        }

        public function getLastStatement()
        {
            return $this->fromStatement;
        }

        public function printTableStatement(\Skwal\TableReference $reference)
        {
        	$this->visit($reference);

        	return $this->fromStatement;
        }

        public function visit(\Skwal\TableReference $reference)
        {
            $reference->acceptTableVisitor($this);
        }

        public function visitTable(\Skwal\Table $table)
        {
            $fromStatement = sprintf('%s AS %s', $table->getName(), $table->getCorrelationName());

            $this->fromStatement = $fromStatement;
        }

        public function visitJoinedTable(\Skwal\JoinedTable $table)
        {
            $fromStatements = array();
            $fromStatements[] = $this->printTableStatement($table->getFirstTable());

            foreach ($table->getJoins() as $join)
            {
                $fromStatements[] = sprintf("%s JOIN %s ON (%s)", $join->getType(), $this->printTableStatement($join->getTable()),
                    $this->predicateVisitor->printPredicateStatement($join->getPredicate()));
            }

            $this->fromStatement = implode(' ', $fromStatements);
        }

        public function visitQuery(\Skwal\Query\Select $query)
        {
            $queryText = $this->queryVisitor->printQuery($query);

            $this->fromStatement = sprintf('(%s) AS %s', $queryText, $query->getCorrelationName());
        }
    }
}