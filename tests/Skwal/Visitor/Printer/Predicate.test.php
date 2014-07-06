<?php
namespace Aztech\Skwal\Tests\Visitor\Printer
{

    use Aztech\Skwal\Condition\AndPredicate;
    use Aztech\Skwal\Visitor\Printer\Predicate;
    use Aztech\Skwal\Condition\ComparisonPredicate;
    use Aztech\Skwal\CompOp;

    class PredicateTest extends \PHPUnit_Framework_TestCase
    {

        private $expressionVisitor;

        protected function setUp()
        {
            $this->expressionVisitor = $this->getMock(('\Aztech\Skwal\Visitor\Printer\Expression'));

            $this->expressionVisitor->expects($this->any())
                ->method('printExpression')
                ->will($this->returnValue('expression'));
        }

        public function testVisitDispatchesCallToVisitable()
        {
            $predicate = $this->getMock('\Aztech\Skwal\Condition\Predicate');

            $visitor = new \Aztech\Skwal\Visitor\Printer\Predicate();

            $predicate->expects($this->once())
                ->method('acceptPredicateVisitor')
                ->with($this->equalTo($visitor));

            $visitor->visit($predicate);
        }

        public function testPrintComparisonPredicateReturnsCorrectString()
        {
            $first = $this->getMock('\Aztech\Skwal\Expression\AliasExpression');
            $second = $this->getMock('\Aztech\Skwal\Expression\AliasExpression');
            $predicate = new ComparisonPredicate($first, CompOp::EQUAL, $second);

            $visitor = new Predicate();
            $visitor->setExpressionPrinter($this->expressionVisitor);

            $this->assertEquals('expression = expression', $visitor->printPredicateStatement($predicate));
        }

        public function testPrintAndPredicateReturnsCorrectString()
        {
            $first = $this->getMock('\Aztech\Skwal\Expression\AliasExpression');
            $second = $this->getMock('\Aztech\Skwal\Expression\AliasExpression');
            $boundPredicate = new ComparisonPredicate($first, CompOp::EQUAL, $second);
            $predicate = $boundPredicate->bAnd($boundPredicate);

            $visitor = new Predicate();
            $visitor->setExpressionPrinter($this->expressionVisitor);

            $this->assertEquals('(expression = expression AND expression = expression)',
                $visitor->printPredicateStatement($predicate));
        }

        public function testPrintOrPredicateReturnsCorrectString()
        {
            $first = $this->getMock('\Aztech\Skwal\Expression\AliasExpression');
            $second = $this->getMock('\Aztech\Skwal\Expression\AliasExpression');
            $boundPredicate = new ComparisonPredicate($first, CompOp::EQUAL, $second);
            $predicate = $boundPredicate->bOr($boundPredicate);

            $visitor = new Predicate();
            $visitor->setExpressionPrinter($this->expressionVisitor);

            $this->assertEquals('(expression = expression OR expression = expression)',
                $visitor->printPredicateStatement($predicate));
        }
    }
}