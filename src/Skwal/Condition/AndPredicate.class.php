<?php
namespace Skwal\Condition
{

    class AndPredicate extends AbstractPredicate
    {
        private $first;
        
        private $second;
        
        public function __construct(Predicate $first, Predicate $second)
        {
            $this->first = $first;
            $this->second = $second;
        }
        
        function getFirstPredicate()
        {
            return $this->first;
        }
        
        function getSecondPredicate()
        {
            return $this->second;
        }
    }
}