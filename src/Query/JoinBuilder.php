<?php
namespace Aztech\Skwal\Query
{
    use Aztech\Skwal\Condition\Predicate;

    class JoinBuilder
    {
        private $queryBuilder;

        public function __construct(Builder $queryBuilder)
        {
            $this->queryBuilder = $queryBuilder;
        }

        public function inner($tableName)
        {
            return $this;
        }

        public function outerLeft($tableName)
        {
            return $this;
        }

        public function outerRight($tableName)
        {
            return $this;
        }

        public function cross($tableName)
        {
            return $this;
        }

        public function on(Predicate $condition)
        {
            return $this;
        }
    }
}