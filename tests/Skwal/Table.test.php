<?php
namespace Test\Skwal
{

    use Skwal\Table;

    class TableTest extends \PHPUnit_Framework_TestCase
    {

        /**
         * @expectedException InvalidArgumentException
         */
        public function testInitializeWithEmptyNameThrowsException()
        {
            $table = new Table('');
        }

        public function testGetNameReturnsProperValue()
        {
            $table = new Table('table');

            $this->assertEquals('table', $table->getName());
        }

        public function testSetNameReturnsCloneWithCorrectName()
        {
            $table = new Table('table', 'alias');

            $clone = $table->setName('newTable');

            $this->assertNotSame($table, $clone);
            $this->assertEquals('newTable', $clone->getName());
            $this->assertEquals($table->getCorrelationName(), $clone->getCorrelationName());
        }

        public function testGetCorrelationNameReturnsTableNameWhenNotSet()
        {
            $table = new Table('table');

            $this->assertEquals('table', $table->getCorrelationName());
        }

        public function testGetCorrelationNameReturnsAliasWhenSet()
        {
            $table = new Table('table', 'alias');

            $this->assertEquals('alias', $table->getCorrelationName());
        }

        public function testGetColumnReturnsCorrectValueObject()
        {
            $table = new Table('table');

            $column = $table->getColumn('column');

            $this->assertNotNull($column);
            $this->assertEquals('column', $column->getValue());
        }

        public function testAcceptTableReferenceVisitorCallsCorrectVisitMethod()
        {
            $table = new Table('table');

            $visitor = $this->getMock('\Skwal\Visitor\TableReference');

            $visitor->expects($this->once())
                ->method('visitTable')
                ->with($this->equalTo($table));

            $table->acceptTableVisitor($visitor);
        }
    }
}