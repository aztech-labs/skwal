<?php

namespace Skwal\Expression
{

    interface AliasExpression
    {
        function getAlias();
        
        function acceptExpressionVisitor(\Skwal\Visitor\Expression $visitor);
    }

}