<?php

namespace Aztech\Skwal\Visitor;

/**
 * Visitor interface for the CorrelatableReference class hierarchy.
 * @author thibaud
 * @todo Rename class into TableReference visitor
 */
interface TableReference
{

    function visit(\Aztech\Skwal\TableReference $reference);

    function visitTable(\Aztech\Skwal\Table $table);

    function visitJoinedTable(\Aztech\Skwal\JoinedTable $table);
    
    function visitQuery(\Aztech\Skwal\Query\Select $query);
}
