<?php
namespace Skwal\Visitor
{
    /**
     * Visitor interface for the CorrelatableReference class hierarchy.
     * @author thibaud
     *
     */
    interface Correlatable
    {

        function visit(\Skwal\CorrelatableReference $reference);

        function visitTable(\Skwal\TableReference $table);

        function visitQuery(\Skwal\Query\Select $query);
    }
}