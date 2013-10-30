<?php

namespace Skwal
{

    interface AliasExpression
    {
        function getAlias();

        function acceptExpressionVisitor(\Skwal\Visitor\Expression $visitor);
    }

}