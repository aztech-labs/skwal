<?php

class Skwal_Visitor_Printer_Expression implements Skwal_Visitor_Expression
{
    private $useAliases = true;

    public function useAliases($useFlag)
    {
        $this->useAliases = $useFlag;
    }

    public function visit(Skwal_AliasExpression $expression)
    {
        return $expression->acceptExpressionVisitor($this);
    }

    public function visitColumn(Skwal_DerivedColumn $column)
    {

    }

    public function visitLiteral(Skwal_LiteralExpression $literal)
    {

    }
}
