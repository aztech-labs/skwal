<?php

interface Skwal_Query
{
    function acceptQueryVisitor(Skwal_Visitor_Query $visitor);
}