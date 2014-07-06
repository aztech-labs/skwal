<?php

namespace Aztech\Skwal;

interface Query extends CorrelatableReference
{
    function acceptQueryVisitor(\Aztech\Skwal\Visitor\Query $visitor);
}
