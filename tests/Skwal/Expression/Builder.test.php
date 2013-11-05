<?php
namespace Test\Skwal\Expression
{

    use Skwal\Expression\Builder;
use Skwal\CompOp;

    class BuilderTest extends \PHPUnit_Framework_TestCase
    {

        protected $builder;

        protected function setUp()
        {
            $this->builder = new Builder();
        }

        private function assertComparisonPredicateProperties($predicate, $left, $operator, $right)
        {
            $this->assertInstanceOf('\Skwal\Condition\ComparisonPredicate', $predicate);
            $this->assertSame($left, $predicate->getLeftOperand());
            $this->assertSame($operator, $predicate->getOperator());
            $this->assertSame($right, $predicate->getRightOperand());
        }

        public function testEqualsReturnsCorrectPredicate()
        {
            $left = $this->getMock('\Skwal\Expression');
            $right = $this->getMock('\Skwal\Expression');

            $predicate = $this->builder->equals($left, $right);

            $this->assertComparisonPredicateProperties($predicate, $left, CompOp::Equals, $right);
        }

        public function testNotEqualsReturnsCorrectPredicate()
        {
            $left = $this->getMock('\Skwal\Expression');
            $right = $this->getMock('\Skwal\Expression');

            $predicate = $this->builder->notEquals($left, $right);

            $this->assertComparisonPredicateProperties($predicate, $left, CompOp::NotEquals, $right);
        }

        public function testGreaterThanReturnsCorrectPredicate()
        {
            $left = $this->getMock('\Skwal\Expression');
            $right = $this->getMock('\Skwal\Expression');

            $predicate = $this->builder->greaterThan($left, $right);

            $this->assertComparisonPredicateProperties($predicate, $left, CompOp::GreaterThan, $right);
        }

        public function testGreaterThanEqReturnsCorrectPredicate()
        {
            $left = $this->getMock('\Skwal\Expression');
            $right = $this->getMock('\Skwal\Expression');

            $predicate = $this->builder->greaterThanEq($left, $right);

            $this->assertComparisonPredicateProperties($predicate, $left, CompOp::GreaterThanEq, $right);
        }

        public function testLessThanReturnsCorrectPredicate()
        {
            $left = $this->getMock('\Skwal\Expression');
            $right = $this->getMock('\Skwal\Expression');

            $predicate = $this->builder->lessThan($left, $right);

            $this->assertComparisonPredicateProperties($predicate, $left, CompOp::LessThan, $right);
        }

        public function testLessThanEqReturnsCorrectPredicate()
        {
            $left = $this->getMock('\Skwal\Expression');
            $right = $this->getMock('\Skwal\Expression');

            $predicate = $this->builder->lessThanEq($left, $right);

            $this->assertComparisonPredicateProperties($predicate, $left, CompOp::LessThanEq, $right);
        }

        public function testAssignReturnsCorrectExpression()
        {
            $assignee = $this->getMock('\Skwal\Expression\AssignableExpression');
            $value = $this->getMock('\Skwal\Expression\AliasExpression');

            $assignment = $this->builder->assign($assignee, $value);

            $this->assertInstanceOf('\Skwal\Expression\AssignmentExpression', $assignment);
            $this->assertSame($assignee, $assignment->getAssignee());
            $this->assertSame($value, $assignment->getValue());
        }
    }
}