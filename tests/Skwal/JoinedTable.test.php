<?php
namespace Aztech\Skwal\Tests
{

    use Aztech\Skwal\JoinedTable;

    class JoinedTableTest extends \PHPUnit_Framework_TestCase
    {

        public function testConstructPerformsExpectedAssignments()
        {
            $table = $this->getMock('\Aztech\Skwal\TableReference');
            $joinedTable = new JoinedTable($table);
            
            $this->assertEquals($table, $joinedTable->getFirstTable());
        }
        
        public function testAcceptTableReferenceVisitorCallsCorrectVisitMethod()
        {
            $mockTable = $this->getMock('\Aztech\Skwal\TableReference');
            $table = new JoinedTable($mockTable);
        
            $visitor = $this->getMock('\Aztech\Skwal\Visitor\TableReference');
        
            $visitor->expects($this->once())
                ->method('visitJoinedTable')
                ->with($this->equalTo($table));
        
            $table->acceptTableVisitor($visitor);
        }
        
        public function testAddedJoinsAreReturnedByGetJoinsMethod()
        {
            $mockTable = $this->getMock('\Aztech\Skwal\TableReference');
            $table = new JoinedTable($mockTable);
            
            $join = $this->getMock('\Aztech\Skwal\Join', array(), array(), '', false);
            
            $table->addJoin($join);
            
            $this->assertCount(1, $table->getJoins());
            $this->assertEquals($join, reset($table->getJoins()));
        }
    }
}