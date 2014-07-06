<?php

namespace Aztech\Skwal;

/**
 * @desc Abstract expression class defining the visitation method for expression visitors.
 * @author thibaud
 */
interface Expression
{

    function acceptExpressionVisitor(\Aztech\Skwal\Visitor\Expression $visitor);
}
