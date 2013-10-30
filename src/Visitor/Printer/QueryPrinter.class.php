<?php

class Skwal_Visitor_Printer_Query implements Skwal_Visitor_Query
{
    private $queryCommand = '';

    private $buffer = '';

    private $expressionVisitor;

    private $correlationVisitor;

    public function initialize()
    {
        $this->expressionVisitor = new Skwal_Visitor_Printer_Expression();
        $this->queryCommand = '';
        $this->buffer = '';
    }

    public function getPrintBuffer()
    {
        $command = $this->queryCommand;

        return sprintf('%s %s %s', $this->queryCommand);
    }

    public function visit(Skwal_Query $query)
    {
        $query->acceptQueryVisitor($this);
    }

    public function visitExpression(Skwal_AliasExpression $expression)
    {
        $this->expressionVisitor->visit($expression);
    }

    public function visitCorrelatedReference(Skwal_CorrelatableReference $reference)
    {
        $this->correlationVisitor->visit($reference);
    }

    public function visitSelect(Skwal_SelectQuery $query)
    {
        $this->queryCommand = 'SELECT';
        $this->expressionVisitor->useAliases(true);
        $this->fromStatement = $query->getFirstTable()->
    }

    public function visitUpdate()
    {
        throw new RuntimeException('Not implemented');
    }

    public function visitDelete()
    {
        throw new RuntimeException('Not implemented');
    }

    public function visitInsert()
    {
        throw new RuntimeException('Not implemented');
    }
}