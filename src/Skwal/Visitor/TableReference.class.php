<?php
namespace Skwal\Visitor
{
    /**
     * Visitor interface for the CorrelatableReference class hierarchy.
     * @author thibaud
     * @todo Rename class into TableReference visitor
     */
    interface TableReference
    {

        function visit(\Skwal\TableReference $reference);

        function visitTable(\Skwal\Table $table);

        function visitJoinedTable(\Skwal\JoinedTable $table);
        
        function visitQuery(\Skwal\Query\Select $query);
    }
}