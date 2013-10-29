<?php

interface Skwal_CorrelatableReference
{
    /**
     * @return string
     */
    function getCorrelationName();
    
    
    function accept(Skwal_Visitor_Correlatable $visitor);
}