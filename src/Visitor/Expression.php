<?php
namespace Aztech\Skwal\Visitor
{

    /**
     * Visitor interface for the AliasExpression class hierarchy.
     *
     * @author thibaud
     *
     */
    interface Expression
    {

        function visit(\Aztech\Skwal\Expression $expression);

        function visitColumn(\Aztech\Skwal\Expression\DerivedColumn $column);

        function visitLiteral(\Aztech\Skwal\Expression\LiteralExpression $literal);

        function visitParameter(\Aztech\Skwal\Expression\ParameterExpression $parameter);

        function visitScalarSelect(\Aztech\Skwal\Query\ScalarSelect $query);

        function visitAssignmentExpression(\Aztech\Skwal\Expression\AssignmentExpression $assignment);
    }
}