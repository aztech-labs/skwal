<?php

namespace Aztech\Skwal\Visitor;

/**
 * Visitor interface for the Query class hierarchy.
 * @author thibaud
 *
 */
interface Query
{
    function visit(\Aztech\Skwal\Query $query);

    function visitSelect(\Aztech\Skwal\Query\Select $query);

    function visitUpdate();

    function visitInsert();

    function visitDelete();
}
