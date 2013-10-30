<?php

namespace Skwal\Visitor
{

interface Expression
{
    function visit(\Skwal\AliasExpression $alias);

    function visitColumn(\Skwal\DerivedColumn $column);

    function visitLiteral(\Skwal\LiteralExpression $literal);
}

}