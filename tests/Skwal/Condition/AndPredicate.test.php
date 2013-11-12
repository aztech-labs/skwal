<?php
namespace Test\Skwal\Condition
{

    use Skwal\Condition\AndPredicate;

    class AndPredicateTest extends \PHPUnit_Framework_TestCase
    {

        /**
         * @testdox Calling getFirstPredicate() returns first predicate that was injected in constructor.
         */
        public function testGetFirstPredicateReturnsConstructorInjectedPredicate()
        {
            $first = $this->getMock('\Skwal\Condition\Predicate');
            $second = $this->getMock('\Skwal\Condition\Predicate');

            $predicate = new AndPredicate($first, $second);

            $this->assertSame($first, $predicate->getFirstPredicate());
        }

        /**
         * @testdox Calling getSecondPredicate() returns second predicate that was injected in constructor.
         */
        public function testGetSecondPredicateReturnsConstructorInjectedPredicate()
        {
            $first = $this->getMock('\Skwal\Condition\Predicate');
            $second = $this->getMock('\Skwal\Condition\Predicate');

            $predicate = new AndPredicate($first, $second);

            $this->assertSame($second, $predicate->getSecondPredicate());
        }

        /**
         * @testdox Calling acceptPredicateVisitor(...) dispatches the call to the appropriate visitor method.
         */
        public function testAcceptCallsCorrectVisitorMethod()
        {
            $first = $this->getMock('\Skwal\Condition\Predicate');
            $second = $this->getMock('\Skwal\Condition\Predicate');

            $predicate = new AndPredicate($first, $second);

            $visitor = $this->getMock('\Skwal\Visitor\Predicate');

            $visitor->expects($this->once())
                ->method('visitAndPredicate')
                ->with($this->equalTo($predicate));

            $predicate->acceptPredicateVisitor($visitor);
        }
    }
}