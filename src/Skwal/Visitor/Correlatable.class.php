<?php
namespace Skwal\Visitor
{

    interface Correlatable
    {

        function visit(\Skwal\CorrelatableReference $reference);

        function visitTable(\Skwal\TableReference $table);

        function visitQuery(\Skwal\Query\Select $query);
    }
}