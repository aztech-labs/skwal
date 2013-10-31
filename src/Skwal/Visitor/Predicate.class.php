<?php

namespace Skwal\Visitor
{

    use Skwal\Condition\Predicate;
    use Skwal\Condition\AndPredicate;
    use Skwal\Condition\OrPredicate;
    use Skwal\Condition\ComparisonPredicate;

    interface Predicate
    {

        function visit(Predicate $predicate);

        function visitAndPredicate(AndPredicate $predicate);

        function visitOrPredicate(OrPredicate $predicate);

        function visitComparisonPredicate(ComparisonPredicate $predicate);
    }
}