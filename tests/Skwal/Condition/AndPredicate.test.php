<?php
namespace Test\Skwal\Condition
{

    use Skwal\Condition\AndPredicate;

    class AndPredicateTest extends \PHPUnit_Framework_TestCase
    {

        public function testGetFirstPredicateReturnsCorrectValue()
        {
            $first = $this->getMock('\Skwal\Condition\Predicate');
            $second = $this->getMock('\Skwal\Condition\Predicate');
            
            $predicate = new AndPredicate($first, $second);
            
            $this->assertSame($first, $predicate->getFirstPredicate());
        }

        public function testGetSecondPredicateReturnsCorrectValue()
        {
            $first = $this->getMock('\Skwal\Condition\Predicate');
            $second = $this->getMock('\Skwal\Condition\Predicate');
            
            $predicate = new AndPredicate($first, $second);
            
            $this->assertSame($second, $predicate->getSecondPredicate());
        }
    }
}