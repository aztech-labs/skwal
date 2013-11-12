<?php
namespace Skwal\Query
{
    use Skwal\Condition\Predicate;

    class JoinBuilder
    {
        private $queryBuilder;

        public function __construct(Builder $queryBuilder)
        {
            $this->queryBuilder = $queryBuilder;
        }

        public function inner()
        {
            return $this;
        }

        public function outerLeft()
        {
            return $this;
        }

        public function outerRight()
        {
            return $this;
        }

        public function cross()
        {
            return $this;
        }

        public function on(Predicate $condition)
        {
            return $this;
        }
    }
}