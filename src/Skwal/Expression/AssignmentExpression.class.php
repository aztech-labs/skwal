<?php
namespace Skwal\Expression
{

    use Skwal\Expression;

    class AssignmentExpression implements Expression
    {
        /**
         *
         * @var \Skwal\Expression\AssignableExpression
         */
        private $assignee;

        /**
         *
         * @var \Skwal\Expression\AliasExpression
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

        public function acceptExpressionVisitor(\Skwal\Visitor\Expression $visitor)
        {
            $visitor->visitAssignmentExpression($this);
        }

    }
}