<?php
namespace Test\Skwal\Condition
{

    use Skwal\Condition\ComparisonPredicate;
    use Skwal\CompOp;

    class CompositePredicateTest extends \PHPUnit_Framework_TestCase
    {

        function testGetLeftOperandReturnsCorrectValue()
        {
            $left = $this->getMock('\Skwal\Expression\ValueExpression');
            $right = $this->getMock('\Skwal\Expression\ValueExpression');
            
            $predicate = new ComparisonPredicate($left, CompOp::Equals, $right);
            
            $this->assertSame($left, $predicate->getLeftOperand());
        }
        
        function testGetRightOperandReturnsCorrectValue()
        {
            $left = $this->getMock('\Skwal\Expression\ValueExpression');
            $right = $this->getMock('\Skwal\Expression\ValueExpression');
            
            $predicate = new ComparisonPredicate($left, CompOp::Equals, $right);
            
            $this->assertSame($right, $predicate->getRightOperand());
        }
        
        function testGetOperatorReturnsCorrectValue()
        {
            $left = $this->getMock('\Skwal\Expression\ValueExpression');
            $right = $this->getMock('\Skwal\Expression\ValueExpression');
            
            $predicate = new ComparisonPredicate($left, CompOp::Equals, $right);
            
            $this->assertEquals(CompOp::Equals, $predicate->getOperator());
        }
    }
}