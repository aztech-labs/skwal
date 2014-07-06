<?php

namespace Aztech\Skwal\Tests\Condition
{

    use Aztech\Skwal\Condition\ComparisonPredicate;
    use Aztech\Skwal\CompOp;
				
    /**
     *
     * @author thibaud
     * @todo Test invalid operators
     */
    class CompositePredicateTest extends \PHPUnit_Framework_TestCase
    {

        function testGetLeftOperandReturnsCorrectValue()
        {
            $left = $this->getMock('\Aztech\Skwal\Expression');
            $right = $this->getMock('\Aztech\Skwal\Expression');
            
            $predicate = new ComparisonPredicate($left, CompOp::EQUAL, $right);

            $this->assertSame($left, $predicate->getLeftOperand());
        }

        function testGetRightOperandReturnsCorrectValue()
        {
            $left = $this->getMock('\Aztech\Skwal\Expression');
            $right = $this->getMock('\Aztech\Skwal\Expression');

            $predicate = new ComparisonPredicate($left, CompOp::EQUAL, $right);

            $this->assertSame($right, $predicate->getRightOperand());
        }

        function getOperands()
        {
            return array(array(CompOp::EQUAL), array(CompOp::GREATER_THAN), array(CompOp::GREATER_THAN_EQ),
                array(CompOp::LESS_THAN), array(CompOp::LESS_THAN_EQ), array(CompOp::NOT_EQUAL));
        }

        /**
         * @dataProvider getOperands
         */
        function testGetOperatorReturnsCorrectValue($operand)
        {
            $left = $this->getMock('\Aztech\Skwal\Expression');
            $right = $this->getMock('\Aztech\Skwal\Expression');

            $predicate = new ComparisonPredicate($left, $operand, $right);

            $this->assertEquals($operand, $predicate->getOperator());
        }

        public function testAcceptCallsCorrectVisitorMethod()
        {
            $first = $this->getMock('\Aztech\Skwal\Expression');
            $second = $this->getMock('\Aztech\Skwal\Expression');

            $predicate = new ComparisonPredicate($first, CompOp::EQUAL, $second);

            $visitor = $this->getMock('\Aztech\Skwal\Visitor\Predicate');

            $visitor->expects($this->once())
                ->method('visitComparisonPredicate')
                ->with($this->equalTo($predicate));

            $predicate->acceptPredicateVisitor($visitor);
        }
    }
}