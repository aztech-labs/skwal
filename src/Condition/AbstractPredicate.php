<?php

namespace Aztech\Skwal\Condition;

abstract class AbstractPredicate implements Predicate
{

    public function bAnd(Predicate $predicate)
    {
        return new AndPredicate($this, $predicate);
    }

    public function bOr(Predicate $predicate)
    {
        return new OrPredicate($this, $predicate);
    }

    abstract function acceptPredicateVisitor(\Aztech\Skwal\Visitor\Predicate $visitor);
}
