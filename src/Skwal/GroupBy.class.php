<?php
namespace Skwal
{

    class GroupBy
    {

        private $expressions = array();

        public function addExpression(\Skwal\Expression\Expression $expression)
        {
            $clone = clone $this;

            $clone->expressions[] = $expression;

            return $clone;
        }

        public function getExpressions()
        {
            return $this->expressions;
        }
    }
}
