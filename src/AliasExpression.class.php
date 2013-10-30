<?php

interface Skwal_AliasExpression
{
    function getAlias();
    
    function accept(Skwal_Visitor_Expression $visitor);
}