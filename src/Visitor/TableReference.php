<?php

namespace Aztech\Skwal\Visitor;

/**
 * Visitor interface for the CorrelatableReference class hierarchy.
 * @author thibaud
 * @todo Rename class into TableReference visitor
 */
interface TableReference
{

    /**
     * @return void
     */
    function visit(\Aztech\Skwal\TableReference $reference);

    /**
     * @return void
     */
    function visitTable(\Aztech\Skwal\Table $table);

    /**
     * @return void
     */
    function visitJoinedTable(\Aztech\Skwal\JoinedTable $table);
    
    /**
     * @return void
     */
    function visitQuery(\Aztech\Skwal\Query\Select $query);
}
