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

    function acceptTableVisitor(\Aztech\Skwal\Visitor\TableReference $visitor);
}
