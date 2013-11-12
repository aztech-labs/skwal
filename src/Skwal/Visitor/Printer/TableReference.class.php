<?php
namespace Skwal\Visitor\Printer
{

    class TableReference implements \Skwal\Visitor\TableReference
    {
        private $queryVisitor;

        private $fromStatement = '';

        public function setQueryVisitor(\Skwal\Visitor\Printer\Query $visitor)
        {
            $this->queryVisitor = $visitor;
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
            $this->fromStatement = 'joined table';
        }

        public function visitQuery(\Skwal\Query\Select $query)
        {
            $queryText = $this->queryVisitor->printQuery($query);

            $this->fromStatement = sprintf('(%s) AS %s', $queryText, $query->getCorrelationName());
        }
    }
}