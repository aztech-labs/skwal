<?php

namespace Aztech\Skwal\Condition;

/**
 * Interface for boolean predicates.
 *
 * @author thibaud
 */
interface Predicate
{

    /**
     * Performs a boolean and composition with another predicate
     *
     * @param Predicate $predicate
     * @return Predicate
     */
    function bAnd(Predicate $predicate);

    /**
     * Performs a boolean or composition with another predicate
     *
     * @param Predicate $predicate
     * @return Predicate
     */
    function bOr(Predicate $predicate);

    /**
     * Accepts a predicate visitor.
     * Implementations should dispatch the call to the
     * appropriate \Aztech\Skwal\Visitor\Predicate::visit*() method.
     *
     * @param \Aztech\Skwal\Visitor\Predicate $visitor
     */
    function acceptPredicateVisitor(\Aztech\Skwal\Visitor\Predicate $visitor);
}
