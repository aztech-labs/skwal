<?php

namespace Aztech\Skwal;

interface Query extends CorrelatableReference
{
    /**
     * @return void
     */
    function acceptQueryVisitor(\Aztech\Skwal\Visitor\Query $visitor);
}
