<?php

namespace Skwal\Visitor
{

interface Expression
{
    function visit(\Skwal\Expression\AliasExpression $alias);

    function visitColumn(\Skwal\Expression\DerivedColumn $column);

    function visitLiteral(\Skwal\Expression\LiteralExpression $literal);
}

}