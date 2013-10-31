<?php

namespace Skwal {

    /**
     * @todo Remove abstract class
     * @author thibaud
     *
     */
    abstract class AbstractExpression implements AliasExpression
    {
        abstract function getAlias();
        abstract function getValue();
    } 

}