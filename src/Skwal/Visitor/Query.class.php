<?php
namespace Skwal\Visitor
{

    interface Query
    {
        function visit(\Skwal\Query $query);

        function visitSelect(\Skwal\SelectQuery $query);

        function visitUpdate();

        function visitInsert();

        function visitDelete();
    }
}