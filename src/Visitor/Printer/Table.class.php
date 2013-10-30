<?php
namespace Skwal\Visitor\Printer
{
    class Table implements \Skwal\Visitor\Correlatable
    {
        private $queryVisitor;

        public function setQueryVisitor(\Skwal\Visitor\Query $visitor)
        {
            $this->queryVisitor = $visitor;
        }

        public function getFromStatement(\Skwal\Query $query)
        {

        }

        public function visit(\Skwal\CorrelatableReference $reference)
        {
            $reference->acceptCorrelatableVisitor($this);
        }

        public function visitTable(\Skwal\TableReference $table)
        {}

        public function visitQuery(\Skwal\Query $query)
        {}
    }
}