<?php
namespace Skwal
{

    use Skwal\Condition\Predicate;

    class Join
    {

        private $table;
        
        private $predicate;
        
        public function __construct(TableReference $table, Predicate $predicate)
        {
        	$this->table = $table;
        	$this->predicate = $predicate;
        }
        
        public function getTable()
        {
            return $this->table;
        }
        
        public function getPredicate()
        {
            return $this->predicate;
        }
    }
}