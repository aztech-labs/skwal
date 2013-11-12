<?php
namespace Skwal
{

    use Skwal\Condition\Predicate;

    class JoinedTable implements TableReference
    {

        private $tables;

        public function addTable(TableReference $reference, Predicate $condition)
        {}

        /**
         *
         * @return TableReference[]
         */
        public function getTables()
        {}

        public function acceptTableVisitor(\Skwal\Visitor\TableReference $visitor)
        {}
    }
}