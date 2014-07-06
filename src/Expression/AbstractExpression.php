<?php

namespace Aztech\Skwal\Expression;

/**
 *
 * @todo Remove abstract class
 * @author thibaud
 * @deprecated Class has no added value
 */
abstract class AbstractExpression implements AliasExpression
{

    abstract function getAlias();

    abstract function getValue();
}
