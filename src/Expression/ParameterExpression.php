<?php
namespace Aztech\Skwal\Expression
{

    use Aztech\Skwal\Expression;

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

        public function acceptExpressionVisitor(\Aztech\Skwal\Visitor\Expression $visitor)
        {
            $visitor->visitParameter($this);
        }
    }
}