<?php

interface Skwal_Visitor_Query
{
    function visit(Skwal_Query $query);
    
    function visitSelect(Skwal_SelectQuery $query);
    function visitUpdate();
    function visitInsert();
    function visitDelete();
}