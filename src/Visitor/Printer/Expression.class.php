<?php

namespace Skwal\Visitor\Printer
{

class Expression implements \Skwal\Visitor\Expression
{
    private $useAliases = true;

    public function useAliases($useFlag)
    {
        $this->useAliases = $useFlag;
    }

    public function visit(\Skwal\AliasExpression $expression)
    {
        return $expression->acceptExpressionVisitor($this);
    }

    public function visitColumn(\Skwal\DerivedColumn $column)
    {

    }

    public function visitLiteral(\Skwal\LiteralExpression $literal)
    {

    }
}

}