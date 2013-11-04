<?php
namespace Skwal
{

    interface Expression
    {

        function acceptExpressionVisitor(\Skwal\Visitor\Expression $visitor);
    }
}