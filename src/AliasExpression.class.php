<?php

interface Skwal_AliasExpression
{
    function getAlias();

    function acceptExpressionVisitor(Skwal_Visitor_Expression $visitor);
}