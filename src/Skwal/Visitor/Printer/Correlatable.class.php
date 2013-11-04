<?php
namespace Skwal\Visitor\Printer
{

    class Correlatable implements \Skwal\Visitor\Correlatable
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

        public function printCorrelatableStatement(\Skwal\CorrelatableReference $reference)
        {
        	$this->visit($reference);

        	return $this->fromStatement;
        }

        public function visit(\Skwal\CorrelatableReference $reference)
        {
            $reference->acceptCorrelatableVisitor($this);
        }

        public function visitTable(\Skwal\TableReference $table)
        {
            $fromStatement = sprintf('%s AS %s', $table->getName(), $table->getCorrelationName());

            $this->fromStatement = $fromStatement;
        }

        public function visitQuery(\Skwal\Query\Select $query)
        {
            $queryText = $this->queryVisitor->printQuery($query);

            $this->fromStatement = sprintf('(%s) AS %s', $queryText, $query->getCorrelationName());
        }
    }
}