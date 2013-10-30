<?php
namespace Skwal\Visitor\Printer
{

    class Query implements \Skwal\Visitor\Query
    {

        private $queryCommand = '';

        private $buffer = '';

        private $expressionVisitor;

        private $correlationVisitor;

        public function initialize()
        {
            $this->expressionVisitor = new \Skwal\Visitor\Printer\Expression();
            $this->correlationVisitor = $this->getCorrelationVisitor();
            $this->queryCommand = '';
            $this->buffer = '';
        }

        private function getCorrelationVisitor()
        {
            $visitor = new \Skwal\Visitor\Printer\Table();

            return $visitor;
        }

        public function getPrintBuffer()
        {
            $command = $this->queryCommand;

            return sprintf('%s %s %s', $this->queryCommand);
        }

        public function visit(\Skwal\Query $query)
        {
            $query->acceptQueryVisitor($this);
        }

        public function visitExpression(\Skwal\AliasExpression $expression)
        {
            $this->expressionVisitor->visit($expression);
        }

        public function visitCorrelatedReference(\Skwal\CorrelatableReference $reference)
        {
            $this->correlationVisitor->visit($reference);
        }

        public function visitSelect(\Skwal\SelectQuery $query)
        {
            $this->queryCommand = 'SELECT';
            $this->expressionVisitor->useAliases(true);
            $this->fromStatement = $this->correlationVisitor->getFromStatement($query);
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
}