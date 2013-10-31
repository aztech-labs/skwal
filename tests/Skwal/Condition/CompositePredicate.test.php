<?php
namespace Test\Skwal\Condition
{

    use Skwal\Condition\ComparisonPredicate;
    use Skwal\CompOp;

    /**
     * 
     * @author thibaud
     * @todo Test invalid operators
     */
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
        
        function getOperands()
        {
            return array(array(CompOp::Equals), array(CompOp::GreaterThan), array(CompOp::GreaterThanEq),
                array(CompOp::LessThan), array(CompOp::LessThanEq), array(CompOp::NotEquals));
        }
        
        /**
         * @dataProvider getOperands
         */
        function testGetOperatorReturnsCorrectValue($operand)
        {
            $left = $this->getMock('\Skwal\Expression\ValueExpression');
            $right = $this->getMock('\Skwal\Expression\ValueExpression');
            
            $predicate = new ComparisonPredicate($left, $operand, $right);
            
            $this->assertEquals($operand, $predicate->getOperator());
        }
    }
}