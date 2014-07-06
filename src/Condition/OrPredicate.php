<?php
namespace Aztech\Skwal\Condition
{

    class OrPredicate extends AbstractPredicate
    {

        private $first;

        private $second;

        public function __construct(Predicate $first, Predicate $second)
        {
            $this->first = $first;
            $this->second = $second;
        }

        public function getFirstPredicate()
        {
            return $this->first;
        }

        public function getSecondPredicate()
        {
            return $this->second;
        }

        function acceptPredicateVisitor(\Aztech\Skwal\Visitor\Predicate $visitor)
        {
        	$visitor->visitOrPredicate($this);
        }
    }
}