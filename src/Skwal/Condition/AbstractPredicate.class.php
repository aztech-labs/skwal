<?php
namespace Skwal\Condition
{

    class AbstractPredicate implements Predicate
    {

        function BAnd(Predicate $predicate)
        {
            return new AndPredicate($this, $predicate);
        }

        function BOr(Predicate $predicate)
        {
            return new OrPredicate($this, $predicate);
        }
    }
}