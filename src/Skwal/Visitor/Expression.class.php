<?php
namespace Skwal\Visitor
{

    /**
     * Visitor interface for the AliasExpression class hierarchy.
     * @author thibaud
     *
     */
    interface Expression
    {

        function visit(\Skwal\Expression\AliasExpression $alias);

        function visitColumn(\Skwal\Expression\DerivedColumn $column);

        function visitLiteral(\Skwal\Expression\LiteralExpression $literal);
    }
}