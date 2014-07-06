<?php
namespace Aztech\Skwal\Condition
{

    /**
     * Interface for boolean primarys.
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
        function BAnd(Predicate $predicate);

        /**
         * Performs a boolean or composition with another predicate
         *
         * @param Predicate $predicate
         * @return Predicate
         */
        function BOr(Predicate $predicate);

        /**
         * Accepts a predicate visitor.
         * Implementations should dispatch the call to the
         * appropriate \Aztech\Skwal\Visitor\Predicate::visit*() method.
         *
         * @param \Aztech\Skwal\Visitor\Predicate $visitor
         */
        function acceptPredicateVisitor(\Aztech\Skwal\Visitor\Predicate $visitor);
    }
}