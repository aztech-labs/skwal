<?php
namespace Test\Skwal\Condition
{

    use Skwal\Condition\AbstractPredicate;

    class AbstractPredicateTest extends \PHPUnit_Framework_TestCase
    {

        protected $predicate;

        protected function setUp()
        {
            $this->predicate = new AbstractPredicate();
        }
        
        public function testBAndReturnsAndPredicate()
        {
            $other = $this->getMock('\Skwal\Condition\Predicate');
            
            $andPredicate = $this->predicate->BAnd($other);
            
            $this->assertInstanceOf('\Skwal\Condition\AndPredicate', $andPredicate);
            $this->assertSame($andPredicate->getFirstPredicate(), $this->predicate);
            $this->assertSame($andPredicate->getSecondPredicate(), $other);
        }
        
        public function testBOrReturnsAndPredicate()
        {
            $other = $this->getMock('\Skwal\Condition\Predicate');
        
            $andPredicate = $this->predicate->BOr($other);
        
            $this->assertInstanceOf('\Skwal\Condition\OrPredicate', $andPredicate);
            $this->assertSame($andPredicate->getFirstPredicate(), $this->predicate);
            $this->assertSame($andPredicate->getSecondPredicate(), $other);
        }
    }
}