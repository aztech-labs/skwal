<?php
namespace Aztech\Skwal\Expression
{

    use Aztech\Skwal\Expression;

    class AssignmentExpression implements Expression
    {
        /**
         *
         * @var \Aztech\Skwal\Expression\AssignableExpression
         */
        private $assignee;

        /**
         *
         * @var \Aztech\Skwal\Expression\AliasExpression
         */
        private $value;

        /**
         * @param AssignableExpression $assignee
         * @param AliasExpression $value
         */
        public function __construct(AssignableExpression $assignee, AliasExpression $value)
        {
            $this->assignee = $assignee;
            $this->value = $value;
        }

        public function getAssignee()
        {
            return $this->assignee;
        }

        public function getValue()
        {
            return $this->value;
        }

        public function acceptExpressionVisitor(\Aztech\Skwal\Visitor\Expression $visitor)
        {
            $visitor->visitAssignmentExpression($this);
        }

    }
}