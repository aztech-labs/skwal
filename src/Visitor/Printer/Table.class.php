<?php
namespace Skwal\Visitor\Printer
{

    class Table implements \Skwal\Visitor\Correlatable
    {

        private static $correlationFormat = '(%s) AS %s';

        private $queryVisitor;

        public function setQueryVisitor(\Skwal\Visitor\Printer\Query $visitor)
        {
            $this->queryVisitor = $visitor;
        }

        public function getFromStatement(\Skwal\Query $query)
        {

        }

        public function visit(\Skwal\CorrelatableReference $reference)
        {
            return $reference->acceptCorrelatableVisitor($this);
        }

        public function visitTable(\Skwal\TableReference $table)
        {
            return sprintf(self::$correlationFormat, $table->getName(), $table->getCorrelationName());
        }

        public function visitQuery(\Skwal\Query $query)
        {
            $queryText = $this->queryVisitor->visit($query);

            return sprintf(self::$correlationFormat, $queryText, $query->getCorrelationName());
        }
    }
}