<?php
namespace Aztech\Skwal\Tests\Expression
{

    use Aztech\Skwal\Expression\Builder;
use Aztech\Skwal\CompOp;

    class BuilderTest extends \PHPUnit_Framework_TestCase
    {

        protected $builder;

        protected function setUp()
        {
            $this->builder = new Builder();
        }

        private function assertComparisonPredicateProperties($predicate, $left, $operator, $right)
        {
            $this->assertInstanceOf('\Aztech\Skwal\Condition\ComparisonPredicate', $predicate);
            $this->assertSame($left, $predicate->getLeftOperand());
            $this->assertSame($operator, $predicate->getOperator());
            $this->assertSame($right, $predicate->getRightOperand());
        }

        public function testEqualsReturnsCorrectPredicate()
        {
            $left = $this->getMock('\Aztech\Skwal\Expression');
            $right = $this->getMock('\Aztech\Skwal\Expression');

            $predicate = $this->builder->equals($left, $right);

            $this->assertComparisonPredicateProperties($predicate, $left, CompOp::Equals, $right);
        }

        public function testNotEqualsReturnsCorrectPredicate()
        {
            $left = $this->getMock('\Aztech\Skwal\Expression');
            $right = $this->getMock('\Aztech\Skwal\Expression');

            $predicate = $this->builder->notEquals($left, $right);

            $this->assertComparisonPredicateProperties($predicate, $left, CompOp::NotEquals, $right);
        }

        public function testGreaterThanReturnsCorrectPredicate()
        {
            $left = $this->getMock('\Aztech\Skwal\Expression');
            $right = $this->getMock('\Aztech\Skwal\Expression');

            $predicate = $this->builder->greaterThan($left, $right);

            $this->assertComparisonPredicateProperties($predicate, $left, CompOp::GreaterThan, $right);
        }

        public function testGreaterThanEqReturnsCorrectPredicate()
        {
            $left = $this->getMock('\Aztech\Skwal\Expression');
            $right = $this->getMock('\Aztech\Skwal\Expression');

            $predicate = $this->builder->greaterThanEq($left, $right);

            $this->assertComparisonPredicateProperties($predicate, $left, CompOp::GreaterThanEq, $right);
        }

        public function testLessThanReturnsCorrectPredicate()
        {
            $left = $this->getMock('\Aztech\Skwal\Expression');
            $right = $this->getMock('\Aztech\Skwal\Expression');

            $predicate = $this->builder->lessThan($left, $right);

            $this->assertComparisonPredicateProperties($predicate, $left, CompOp::LessThan, $right);
        }

        public function testLessThanEqReturnsCorrectPredicate()
        {
            $left = $this->getMock('\Aztech\Skwal\Expression');
            $right = $this->getMock('\Aztech\Skwal\Expression');

            $predicate = $this->builder->lessThanEq($left, $right);

            $this->assertComparisonPredicateProperties($predicate, $left, CompOp::LessThanEq, $right);
        }

        public function testAssignReturnsCorrectExpression()
        {
            $assignee = $this->getMock('\Aztech\Skwal\Expression\AssignableExpression');
            $value = $this->getMock('\Aztech\Skwal\Expression\AliasExpression');

            $assignment = $this->builder->assign($assignee, $value);

            $this->assertInstanceOf('\Aztech\Skwal\Expression\AssignmentExpression', $assignment);
            $this->assertSame($assignee, $assignment->getAssignee());
            $this->assertSame($value, $assignment->getValue());
        }
        
        public function getIntValues()
        {
            return array(array(0), array(1), array(2), array(10),
                        array(-10), array(-1));
        }
        
        /**
         * @dataProvider getIntValues
         */
        public function testIntReturnsExpressionWithCorrectValue($value)
        {
            $expression = $this->builder->int($value);
            
            $this->assertEquals($value, $expression->getValue());
        }
        
        public function testIntReturnsExpressionWithCorrectAlias()
        {
            $expression = $this->builder->int(0, 'alias');
            
            $this->assertEquals('alias', $expression->getAlias());
        }
        
        public function getStringValues()
        {
            return array(array(''), array('string'));
        }
        
        /**
         * @dataProvider getStringValues
         */
        public function testStringReturnsExpressionWithCorrectValue($value)
        {
            $expression = $this->builder->string($value);
            
            $this->assertEquals($value, $expression->getValue());
        }
        
        public function testStringReturnsExpressionWithCorrectAlias()
        {
            $expression = $this->builder->string('string', 'alias');
            
            $this->assertEquals('alias', $expression->getAlias());
        }
        
        public function getDoubleValues()
        {
            return array(array(1.00), array(1.15));
        }
        
        /**
         * @dataProvider getDoubleValues
         */
        public function testDoubleReturnsExpressionWithCorrectValue($value)
        {
            $expression = $this->builder->double($value);
        
            $this->assertEquals($value, $expression->getValue());
        }
        
        public function testDoubleReturnsExpressionWithCorrectAlias()
        {
            $expression = $this->builder->double(0.00, 'alias');
        
            $this->assertEquals('alias', $expression->getAlias());
        }
        
        public function getFloatValues()
        {
            return array(array(1.00), array(1.15));
        }
        
        /**
         * @dataProvider getFloatValues
         */
        public function testFloatReturnsExpressionWithCorrectValue($value)
        {
            $expression = $this->builder->Float($value);
        
            $this->assertEquals($value, $expression->getValue());
        }
        
        public function testFloatReturnsExpressionWithCorrectAlias()
        {
            $expression = $this->builder->Float(0.00, 'alias');
        
            $this->assertEquals('alias', $expression->getAlias());
        }
        
        public function testParamReturnsExpressionWithCorrectName()
        {
            $param = $this->builder->param('param');
            
            $this->assertEquals('param', $param->getName());
        }
    }
}