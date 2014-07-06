<?php

namespace Aztech\Skwal;

/**
 * Marker interface for table references.
 * 
 * @author thibaud
 *        
 */
interface TableReference
{

    /**
     * @return void
     */
    function acceptTableVisitor(\Aztech\Skwal\Visitor\TableReference $visitor);
}
