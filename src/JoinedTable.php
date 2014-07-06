<?php
namespace Aztech\Skwal
{

    use Aztech\Skwal\Condition\Predicate;

    class JoinedTable implements TableReference
    {

        /**
         *
         * @var \Aztech\Skwal\TableReference
         */
        private $topTable = null;

        /**
         *
         * @var \Aztech\Skwal\Join[]
         */
        private $joins = array();

        
        public function __construct(TableReference $firstTable)
        {
            $this->topTable = $firstTable;
        }
        
        public function getFirstTable()
        {
            return $this->topTable;
        }
        
        public function addJoin(Join $join)
        {
        	$this->joins[] = $join;
        }

        /**
         *
         * @return Join[]
         */
        public function getJoins()
        {
        	return $this->joins;
        }

        /**
         * (non-PHPdoc)
         * 
         * @see \Aztech\Skwal\TableReference::acceptTableVisitor()
         */
        public function acceptTableVisitor(\Aztech\Skwal\Visitor\TableReference $visitor)
        {
            $visitor->visitJoinedTable($this);
        }
    }
}