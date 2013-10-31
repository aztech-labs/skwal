<?php

namespace Skwal\Visitor
{

    use Skwal\Condition\AndPredicate;
    use Skwal\Condition\OrPredicate;
    use Skwal\Condition\ComparisonPredicate;

    interface Predicate
    {

        function visit(\Skwal\Condition\Predicate $predicate);

        function visitAndPredicate(AndPredicate $predicate);

        function visitOrPredicate(OrPredicate $predicate);

        function visitComparisonPredicate(ComparisonPredicate $predicate);
    }
}