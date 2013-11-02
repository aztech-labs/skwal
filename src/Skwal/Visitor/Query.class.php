<?php
namespace Skwal\Visitor
{

    /**
     * Visitor interface for the Query class hierarchy.
     * @author thibaud
     *
     */
    interface Query
    {
        function visit(\Skwal\Query $query);

        function visitSelect(\Skwal\Query\Select $query);

        function visitUpdate();

        function visitInsert();

        function visitDelete();
    }
}