<?php

namespace Aztech\Skwal\Visitor;

/**
 * Visitor interface for the AliasExpression class hierarchy.
 *
 * @author thibaud
 *
 */
interface Expression
{

    /**
     * @return void
     */
    function visit(\Aztech\Skwal\Expression $expression);

    /**
     * @return void
     */
    function visitColumn(\Aztech\Skwal\Expression\DerivedColumn $column);

    /**
     * @return void
     */
    function visitLiteral(\Aztech\Skwal\Expression\LiteralExpression $literal);

    /**
     * @return void
     */
    function visitParameter(\Aztech\Skwal\Expression\ParameterExpression $parameter);

    /**
     * @return void
     */
    function visitScalarSelect(\Aztech\Skwal\Query\ScalarSelect $query);

    /**
     * @return void
     */
    function visitAssignmentExpression(\Aztech\Skwal\Expression\AssignmentExpression $assignment);
}
