<?php
namespace Skwal
{

    interface Query
    {

        function acceptQueryVisitor(Skwal_Visitor_Query $visitor);
    }
}