<?php
namespace Skwal\Visitor\Printer
{

    class Table implements \Skwal\Visitor\Correlatable
    {

        private $queryVisitor;

        private $fromStatement;

        public function setQueryVisitor(\Skwal\Visitor\Printer\Query $visitor)
        {
            $this->queryVisitor = $visitor;
        }

        public function getFromStatement(\Skwal\SelectQuery $query)
        {
        	$this->visit($query->getFirstTable());
        	
        	return $this->fromStatement;
        }

        public function visit(\Skwal\CorrelatableReference $reference)
        {
            $reference->acceptCorrelatableVisitor($this);
        }

        public function visitTable(\Skwal\TableReference $table)
        {
            $this->fromStatement = sprintf('%s AS %s', $table->getName(), $table->getCorrelationName());
        }

        public function visitQuery(\Skwal\SelectQuery $query)
        {
            $queryText = $this->queryVisitor->getQueryCommand($query);
            
            $this->fromStatement = sprintf('(%s) AS %s', $queryText, $query->getCorrelationName());
        }
    }
}