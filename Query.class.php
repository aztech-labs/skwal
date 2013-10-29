<?php

interface Skwal_Query
{
    function accept(Skwal_Visitor_Query $visitor);
}