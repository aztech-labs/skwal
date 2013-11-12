<?php
namespace Test\Skwal\Visitor\Printer
{

    use Skwal\TableReference;
    use Skwal\Visitor\Printer\Correlatable;

    class CorrelatableTest extends \PHPUnit_Framework_TestCase
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

        public function testVisitTableGeneratesCorrectString()
        {
            $table = new TableReference('dummy', 'alias');
            $visitor = new Correlatable();

            $this->assertEquals('dummy AS alias', $visitor->printCorrelatableStatement($table));
        }

        public function testVisitQueryGeneratesCorrectString()
        {
            $query = $this->getMock('\Skwal\Query\Select');
            $query->expects($this->any())
                ->method('getCorrelationName')
                ->will($this->returnValue('correlation'));

            $queryVisitor = $this->getMock('\Skwal\Visitor\Printer\Query');
            $queryVisitor->expects($this->any())
                ->method($this->anything())
                ->will($this->returnValue('nested query'));

            $visitor = new Correlatable();
            $visitor->setQueryVisitor($queryVisitor);

            $visitor->visitQuery($query);

            $this->assertEquals('(nested query) AS correlation', $visitor->getLastStatement());
        }
    }
}