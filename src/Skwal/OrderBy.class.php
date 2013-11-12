<?php

namespace Skwal
{
    class OrderBy
    {
        private $sortExpression;

        private $descending;

        public function __construct(\Skwal\Expression $expression, $descending = false)
        {
            $this->sortExpression = $expression;
            $this->descending = $descending;
        }

        public function getExpression()
        {
            return $this->sortExpression;
        }

        public function isDescending()
        {
            return $this->descending;
        }
    }
}