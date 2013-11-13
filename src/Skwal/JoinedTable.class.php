<?php
namespace Skwal
{

    use Skwal\Condition\Predicate;

    class JoinedTable implements TableReference
    {

        /**
         *
         * @var \Skwal\TableReference
         */
        private $topTable = null;

        /**
         *
         * @var \Skwal\Join[]
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
         * @see \Skwal\TableReference::acceptTableVisitor()
         */
        public function acceptTableVisitor(\Skwal\Visitor\TableReference $visitor)
        {
            $visitor->visitJoinedTable($this);
        }
    }
}