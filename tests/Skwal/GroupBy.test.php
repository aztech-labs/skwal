<?php
namespace Test\Skwal
{

    use Skwal\GroupBy;

    class GroupByTest extends \PHPUnit_Framework_TestCase
    {

        public function testAddExpressionReturnsNewInstance()
        {
            $expression = $this->getMock('\Skwal\Expression\ValueExpression');

            $groupBy = new GroupBy();

            $this->assertNotSame($groupBy->addExpression($expression), $groupBy);
        }

        public function testAddExpressionReturnsInstanceWithNewExpression()
        {
            $expression = $this->getMock('\Skwal\Expression\ValueExpression');

            $groupBy = new GroupBy();
            $groupBy = $groupBy->addExpression($expression);

            $this->assertContains($expression, $groupBy->getExpressions());
        }
    }
}