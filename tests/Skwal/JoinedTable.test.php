<?php
namespace Test\Skwal
{

    use Skwal\JoinedTable;

    class JoinedTableTest extends \PHPUnit_Framework_TestCase
    {

        public function testConstructPerformsExpectedAssignments()
        {
            $table = $this->getMock('\Skwal\TableReference');
            $joinedTable = new JoinedTable($table);
            
            $this->assertEquals($table, $joinedTable->getFirstTable());
        }
        
        public function testAcceptTableReferenceVisitorCallsCorrectVisitMethod()
        {
            $mockTable = $this->getMock('\Skwal\TableReference');
            $table = new JoinedTable($mockTable);
        
            $visitor = $this->getMock('\Skwal\Visitor\TableReference');
        
            $visitor->expects($this->once())
                ->method('visitJoinedTable')
                ->with($this->equalTo($table));
        
            $table->acceptTableVisitor($visitor);
        }
        
        public function testAddedJoinsAreReturnedByGetJoinsMethod()
        {
            $mockTable = $this->getMock('\Skwal\TableReference');
            $table = new JoinedTable($mockTable);
            
            $join = $this->getMock('\Skwal\Join', array(), array(), '', false);
            
            $table->addJoin($join);
            
            $this->assertCount(1, $table->getJoins());
            $this->assertEquals($join, reset($table->getJoins()));
        }
    }
}