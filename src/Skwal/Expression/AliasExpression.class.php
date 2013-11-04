<?php
namespace Skwal\Expression
{

    use Skwal\Expression;

    /**
     * Interface for expression classes that can be aliased
     *
     * @author thibaud
     *
     */
    interface AliasExpression extends Expression
    {

        function getAlias();

    }
}