<?php
namespace Skwal\Visitor
{

    /**
     * Visitor interface for the AliasExpression class hierarchy.
     *
     * @author thibaud
     *
     */
    interface Expression
    {

        function visit(\Skwal\Expression $expression);

        function visitColumn(\Skwal\Expression\DerivedColumn $column);

        function visitLiteral(\Skwal\Expression\LiteralExpression $literal);

        function visitParameter(\Skwal\Expression\ParameterExpression $parameter);

        function visitScalarSelect(\Skwal\Query\ScalarSelect $query);

        function visitAssignmentExpression(\Skwal\Expression\AssignmentExpression $assignment);
    }
}