<?php
namespace Skwal\Expression
{

    use Skwal\Expression;

    class ParameterExpression implements Expression
    {
        private $name;

        public function __construct($name)
        {
            $this->name = $name;
        }

        public function getName()
        {
            return $this->name;
        }

        public function acceptExpressionVisitor(\Skwal\Visitor\Expression $visitor)
        {
            $visitor->visitParameter($this);
        }
    }
}