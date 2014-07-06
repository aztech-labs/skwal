<?php
namespace Aztech\Skwal\Query
{

    use Aztech\Skwal\Expression\AliasExpression;
    use Aztech\Skwal\Visitor\Expression;

    /**
     * Class for selects returning a scalar value.
     * @author thibaud
     *
     */
    class ScalarSelect extends Select implements AliasExpression
    {

        /**
         * Initialize a new instance using an alias to identify the value returned by the query.
         * @param string $alias
         */
        public function __construct($alias)
        {
            parent::__construct($alias);
        }

        /**
         * (non-PHPdoc)
         * @see \Aztech\Skwal\Expression\AliasExpression::getAlias()
         */
        public function getAlias()
        {
            return $this->getCorrelationName();
        }

        /**
         * (non-PHPdoc)
         * @see \Aztech\Skwal\Expression::acceptExpressionVisitor()
         */
        public function acceptExpressionVisitor(Expression $visitor)
        {
        	$visitor->visitScalarSelect($this);
        }

        /**
         * (non-PHPdoc)
         * @see \Aztech\Skwal\Query\Select::canAddColumn()
         */
        public function canAddColumn()
        {
            return (count($this->getColumns()) == 0);
        }
    }
}