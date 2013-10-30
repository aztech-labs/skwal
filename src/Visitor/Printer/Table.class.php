<?php
namespace Skwal\Visitor\Printer
{

    class Correlatable implements \Skwal\Visitor\Correlatable
    {

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