<?php

namespace Aztech\Skwal\Visitor;

/**
 * Visitor interface for the Query class hierarchy.
 * @author thibaud
 *
 */
interface Query
{
    /**
     * @return void
     */
    function visit(\Aztech\Skwal\Query $query);

    /**
     * @return void
     */
    function visitSelect(\Aztech\Skwal\Query\Select $query);

    function visitUpdate();

    function visitInsert();

    function visitDelete();
}
