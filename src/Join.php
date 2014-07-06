<?php

namespace Aztech\Skwal;

use Aztech\Skwal\Condition\Predicate;

class Join
{

    private $table;

    private $predicate;

    private $type;

    public function __construct(TableReference $table, Predicate $predicate, $joinType = JoinType::Inner)
    {
        $this->table = $table;
        $this->predicate = $predicate;
        $this->type = $joinType;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getTable()
    {
        return $this->table;
    }

    public function getPredicate()
    {
        return $this->predicate;
    }
}
