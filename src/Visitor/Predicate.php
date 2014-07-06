<?php

namespace Aztech\Skwal\Visitor;

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

    /**
     * @return void
     */
    function visit(\Aztech\Skwal\Condition\Predicate $predicate);

    /**
     * @return void
     */
    function visitAndPredicate(AndPredicate $predicate);

    /**
     * @return void
     */
    function visitOrPredicate(OrPredicate $predicate);

    /**
     * @return void
     */
    function visitComparisonPredicate(ComparisonPredicate $predicate);
}
