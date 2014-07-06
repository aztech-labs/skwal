<?php
namespace Aztech\Skwal\Visitor
{

    use Aztech\Skwal\Condition\AndPredicate;
    use Aztech\Skwal\Condition\OrPredicate;
    use Aztech\Skwal\Condition\ComparisonPredicate;

    /**
     * Visitor interface for the Predicate class hierarchy.
     * @author thibaud
     *
     */
    interface Predicate
    {

        function visit(\Aztech\Skwal\Condition\Predicate $predicate);

        function visitAndPredicate(AndPredicate $predicate);

        function visitOrPredicate(OrPredicate $predicate);

        function visitComparisonPredicate(ComparisonPredicate $predicate);
    }
}