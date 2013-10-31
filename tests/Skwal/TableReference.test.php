<?php
namespace Test\Skwal
{

    use Skwal\TableReference;

    class TableReferenceTest extends \PHPUnit_Framework_TestCase
    {

        /**
         * @expectedException InvalidArgumentException
         */
        public function testInitializeWithEmptyNameThrowsException()
        {
            $table = new TableReference('');
        }

        public function testGetNameReturnsProperValue()
        {
            $table = new TableReference('table');

            $this->assertEquals('table', $table->getName());
        }

        public function testSetNameReturnsCloneWithCorrectName()
        {
            $table = new TableReference('table', 'alias');

            $clone = $table->setName('newTable');

            $this->assertNotSame($table, $clone);
            $this->assertEquals('newTable', $clone->getName());
            $this->assertEquals($table->getCorrelationName(), $clone->getCorrelationName());
        }

        public function testGetCorrelationNameReturnsTableNameWhenNotSet()
        {
            $table = new TableReference('table');

            $this->assertEquals('table', $table->getCorrelationName());
        }

        public function testGetCorrelationNameReturnsAliasWhenSet()
        {
            $table = new TableReference('table', 'alias');

            $this->assertEquals('alias', $table->getCorrelationName());
        }

        public function testGetColumnReturnsCorrectValueObject()
        {
            $table = new TableReference('table');

            $column = $table->getColumn('column');

            $this->assertNotNull($column);
            $this->assertEquals('column', $column->getValue());
        }

        public function testAcceptCorrelatableVisitorCallsCorrectVisitMethod()
        {
            $table = new TableReference('table');

            $visitor = $this->getMock('\Skwal\Visitor\Correlatable');

            $visitor->expects($this->once())
                ->method('visitTable')
                ->with($this->equalTo($table));

            $table->acceptCorrelatableVisitor($visitor);
        }
    }
}