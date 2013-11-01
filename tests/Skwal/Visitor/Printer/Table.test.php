<?php
namespace Test\Skwal\Visitor\Printer
{
    class TableTest extends \PHPUnit_Framework_TestCase
    {
        public function testVisitDispatchesCallToVisitable()
        {
            $visitor = new \Skwal\Visitor\Printer\Correlatable();

            $reference = $this->getMock('\Skwal\CorrelatableReference');

            $reference->expects($this->once())
                ->method('acceptCorrelatableVisitor')
                ->with($this->equalTo($visitor));

            $visitor->visit($reference);
        }
    }
}