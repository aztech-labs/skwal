<?php
namespace Aztech\Skwal\Tests\Condition
{

    use Aztech\Skwal\Condition\OrPredicate;

    class OrPredicateTest extends \PHPUnit_Framework_TestCase
    {

        public function testGetFirstPredicateReturnsCorrectValue()
        {
            $first = $this->getMock('\Aztech\Skwal\Condition\Predicate');
            $second = $this->getMock('\Aztech\Skwal\Condition\Predicate');

            $predicate = new OrPredicate($first, $second);

            $this->assertSame($first, $predicate->getFirstPredicate());
        }

        public function testGetSecondPredicateReturnsCorrectValue()
        {
            $first = $this->getMock('\Aztech\Skwal\Condition\Predicate');
            $second = $this->getMock('\Aztech\Skwal\Condition\Predicate');

            $predicate = new OrPredicate($first, $second);

            $this->assertSame($second, $predicate->getSecondPredicate());
        }

        public function testAcceptCallsCorrectVisitorMethod()
        {
            $first = $this->getMock('\Aztech\Skwal\Condition\Predicate');
            $second = $this->getMock('\Aztech\Skwal\Condition\Predicate');

            $predicate = new OrPredicate($first, $second);

            $visitor = $this->getMock('\Aztech\Skwal\Visitor\Predicate');

            $visitor->expects($this->once())
                ->method('visitOrPredicate')
                ->with($this->equalTo($predicate));

            $predicate->acceptPredicateVisitor($visitor);
        }
    }
}