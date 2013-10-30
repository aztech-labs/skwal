<?php
namespace Skwal
{
    interface Query extends CorrelatableReference
    {
        function acceptQueryVisitor(Skwal_Visitor_Query $visitor);
    }
}