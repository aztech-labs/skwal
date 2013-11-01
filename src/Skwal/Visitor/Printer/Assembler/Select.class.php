<?php
namespace Skwal\Visitor\Printer\Assembler
{

    class Select
    {

        private $selectList = array();

        private $fromClause = '';

        private $whereClause = '';

        private $groupByList = array();

        private $orderByClause = '';

        private $limitClause = '';

        private $offsetClause = '';

        public function setSelectList(array $expressions = array())
        {
            $this->selectList = $expressions;
        }

        public function setFromClause($statement)
        {
            $this->fromClause = $statement;
        }

        public function setWhereClause($statement)
        {
            $this->whereClause = $statement;
        }

        public function setGroupByList(array $expressions = array())
        {
            $this->groupByList = $expressions;
        }

        public function setOrderByClause($statement)
        {
            $this->orderByClause = $statement;
        }

        public function setLimitClause($limitStatement, $offsetStatement)
        {
            $this->limitClause = $limitStatement;
            $this->offsetStatement = $offsetStatement;
        }

        public function getAssembledStatement()
        {
            $command = '';

            $this->appendSelectList($command);
            $this->appendFromClause($command);
            $this->appendWhereIfNecessary($command);
            $this->appendGroupByIfNecessary($command);

            return $command;
        }

        private function appendSelectList(&$command)
        {
            if (! count($this->selectList)) {
                throw new \RuntimeException('Select list cannot be empty.');
            }

            $command .= 'SELECT ' . implode(', ', $this->selectList);
        }

        private function appendFromClause(&$command)
        {
            if (trim($this->fromClause) == '') {
                throw new \RuntimeException('From clause is required.');
            }

            $command .= ' FROM ' . $this->fromClause;
        }

        private function appendWhereIfNecessary(&$command)
        {
            if (trim($this->whereClause) != '') {
                $command .= ' WHERE ' . $this->whereClause;
            }
        }

        private function appendGroupByIfNecessary(&$command)
        {
            if (count($this->groupByList)) {
                $command .= ' GROUP BY ' . implode(', ', $this->groupByList);
            }
        }
    }
}