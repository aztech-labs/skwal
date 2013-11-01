<?php

namespace Test\Skwal\Visitor\Printer
{
    class Predicate extends \PHPUnit_Framework_TestCase
    {

        public function testVisitDispatchesCallToVisitable()
        {
            $predicate = $this->getMock('\Skwal\Condition\Predicate');

            $visitor = new \Skwal\Visitor\Printer\Predicate();

            $predicate->expects($this->once())
                ->method('acceptPredicateVisitor')
                ->with($this->equalTo($visitor));

            $visitor->visit($predicate);
        }

    }
}