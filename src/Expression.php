<?php
namespace Aztech\Skwal
{

    interface Expression
    {

        function acceptExpressionVisitor(\Aztech\Skwal\Visitor\Expression $visitor);
    }
}