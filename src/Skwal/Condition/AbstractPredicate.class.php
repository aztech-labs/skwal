<?php
namespace Skwal\Condition
{

    abstract class AbstractPredicate implements Predicate
    {

        public function BAnd(Predicate $predicate)
        {
            return new AndPredicate($this, $predicate);
        }

        public function BOr(Predicate $predicate)
        {
            return new OrPredicate($this, $predicate);
        }

        abstract function acceptPredicateVisitor(\Skwal\Visitor\Predicate $visitor);
    }
}