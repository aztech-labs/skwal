<?php

interface Skwal_Visitor_Expression
{    
    function visit(Skwal_AliasExpression);
    
    function visitColumn(Skwal_DerivedColumn $column);
    
    function visitLiteral(Skwal_LiteralExpression $literal);
}