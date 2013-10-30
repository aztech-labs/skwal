<?php
namespace Skwal
{
    interface Query extends CorrelatableReference
    {
        function acceptQueryVisitor(\Skwal\Visitor\Query $visitor);
    }
}