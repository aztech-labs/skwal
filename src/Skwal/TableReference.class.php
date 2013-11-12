<?php

namespace Skwal
{
    /**
     * Marker interface for table references.
     * @author thibaud
     *
     */
    interface TableReference 
    {
        function acceptTableVisitor(\Skwal\Visitor\TableReference $visitor);
    }
}