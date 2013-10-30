<?php

interface Skwal_CorrelatableReference
{
    /**
     * @return string
     */
    function getCorrelationName();

    function acceptCorrelatableVisitor(Skwal_Visitor_Correlatable $visitor);
}