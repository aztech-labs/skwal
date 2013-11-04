<?php
namespace Skwal\Query
{

    use Skwal\TableReference;
    use Skwal\Condition\Predicate;

    class Builder
    {

        /**
         *
         * @var \Skwal\Query\Select
         */
        private $query;

        /**
         *
         * @var TableReference
         */
        private $table;

        public function exprs()
        {
            $builder = new \Skwal\Expression\Builder();
            $builder->setQueryBuilder($this);

            return $builder;
        }

        /**
         *
         * @param string $tableName
         * @return \Skwal\Query\Builder
         */
        public function select($tableName)
        {
            $builder = $this;

            $builder->table = new TableReference($tableName);
            $builder->query = new Select();

            $builder->query = $builder->query->setTable($builder->table);

            return $builder;
        }

        public function getTable($tableName)
        {
            return $this->findTable($this->table, $tableName);
        }

        private function findTable($table, $tableName)
        {
            if ($table->getCorrelationName() == $tableName) {
                return $table;
            }

            foreach ($this->query->getJoinedTables() as $child) {
                if ($join = $this->findTable($child, $tableName)) {
                    return $join;
                }
            }

            return null;
        }

        public function innerJoin($tableName)
        {
            $builder = $this;

            return $builder;
        }

        public function crossJoin($tableName)
        {
            return $this;
        }

        public function outerLeftJoin($tableName)
        {
            return $this;
        }

        public function outerRightJoin($tableName)
        {
            return $this;
        }

        public function on(Predicate $predicate)
        {
            return $this;
        }

        public function addColumn($name, $alias = '', $table = '')
        {
            $context = debug_backtrace();

            $this->query = $this->query->addColumn($this->table->getColumn($name, $alias));

            return $this;
        }

        public function getColumn($alias)
        {
            foreach ($this->query->getColumns() as $column) {
                if ($column->getAlias() == $alias) {
                    return $column;
                }
            }

            throw new \RuntimeException('Column not found.');
        }

        public function where(Predicate $condition)
        {
            if ($this->query->getCondition() == null) {
                $this->query = $this->query->setCondition($condition);
            }
            else {
                $this->query = $this->query->setCondition(
                    $this->query->getCondition()
                        ->BAnd($condition));
            }

            return $this;
        }

        public function getQuery()
        {
            return $this->query;
        }
    }
}