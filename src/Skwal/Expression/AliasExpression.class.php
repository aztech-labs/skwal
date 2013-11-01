<?php

namespace Skwal\Expression
{

    interface AliasExpression extends ValueExpression
    {
        function getAlias();

        function acceptExpressionVisitor(\Skwal\Visitor\Expression $visitor);
    }

}