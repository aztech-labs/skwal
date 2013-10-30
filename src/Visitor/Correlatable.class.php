<?php

interface Skwal_Visitor_Correlatable
{
    function visit(Skwal_CorrelatableReference $reference);
    
    function visitTable(Skwal_TableReference $table);
    
    function visitQuery(Skwal_SelectQuery $query);
}