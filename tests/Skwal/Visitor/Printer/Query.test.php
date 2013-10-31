<?php
namespace Test\Skwal\Visitor\Printer
{
    class QueryTest extends \PHPUnit_Framework_TestCase
    {

        public function testVisitDispatchesCallToVisitable()
        {
            $visitor = new \Skwal\Visitor\Printer\Query();

            $query = $this->getMock('\Skwal\Query');

            $query->expects($this->once())
                  ->method('acceptQueryVisitor')
                  ->with($this->equalTo($visitor));

            $visitor->visit($query);
        }
    }
}