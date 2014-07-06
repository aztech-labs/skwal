<?php

namespace Aztech\Skwal
{
    class OrderBy
    {
        private $sortExpression;

        private $descending;

        public function __construct(\Aztech\Skwal\Expression $expression, $descending = false)
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