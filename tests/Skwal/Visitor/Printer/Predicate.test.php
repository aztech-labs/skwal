<?php
namespace Test\Skwal\Visitor\Printer
{

    use Skwal\Condition\AndPredicate;
    use Skwal\Visitor\Printer\Predicate;
    use Skwal\Condition\ComparisonPredicate;
    use Skwal\CompOp;

    class PredicateTest extends \PHPUnit_Framework_TestCase
    {

        private $expressionVisitor;

        protected function setUp()
        {
            $this->expressionVisitor = $this->getMock(('\Skwal\Visitor\Printer\Expression'));

            $this->expressionVisitor->expects($this->any())
                ->method('printExpression')
                ->will($this->returnValue('expression'));
        }

        public function testVisitDispatchesCallToVisitable()
        {
            $predicate = $this->getMock('\Skwal\Condition\Predicate');

            $visitor = new \Skwal\Visitor\Printer\Predicate();

            $predicate->expects($this->once())
                ->method('acceptPredicateVisitor')
                ->with($this->equalTo($visitor));

            $visitor->visit($predicate);
        }

        public function testPrintComparisonPredicateReturnsCorrectString()
        {
            $first = $this->getMock('\Skwal\Expression\AliasExpression');
            $second = $this->getMock('\Skwal\Expression\AliasExpression');

            $predicate = new ComparisonPredicate($first, CompOp::Equals, $second);

            $visitor = new Predicate();
            $visitor->setExpressionPrinter($this->expressionVisitor);

            $this->assertEquals('expression = expression', $visitor->printPredicateStatement($predicate));
        }
    }
}