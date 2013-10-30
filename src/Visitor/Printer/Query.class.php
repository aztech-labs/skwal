<?php
namespace Skwal\Visitor\Printer
{

    class Query implements \Skwal\Visitor\Query
    {

        private $queryCommand = '';

        private $buffer = '';

        private $expressionVisitor;

        /**
         *
         * @var \Skwal\Visitor\Printer\Correlatable
         */
        private $correlationVisitor;

        public function initialize()
        {
            $this->expressionVisitor = $this->getExpressionVisitor();
            $this->correlationVisitor = $this->getCorrelationVisitor();
            $this->queryCommand = '';
            $this->buffer = '';
        }

        private function getExpressionVisitor()
        {
            $visitor = new Expression();
        }

        private function getCorrelationVisitor()
        {
            $visitor = new Table();

            $visitor->setQueryVisitor($this);

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