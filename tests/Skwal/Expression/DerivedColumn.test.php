<?php

namespace Aztech\Skwal\Tests\Expression
{

    use Aztech\Skwal\Expression\DerivedColumn;

    class DerivedColumnTest extends \PHPUnit_Framework_TestCase
    {

        public function testAcceptExpressionVisitorCallsCorrectVisitMethod()
        {
            $visitor = $this->getMock('\Aztech\Skwal\Visitor\Expression');

            $column = new DerivedColumn('column');
            
            $visitor->expects($this->once())
                    ->method('visitColumn')
                    ->with($this->equalTo($column));
            
            $column->acceptExpressionVisitor($visitor);
        }
        
        public function testGetValueReturnsColumnName()
        {
            $column = new DerivedColumn('column');
            
            $this->assertEquals('column', $column->getValue());
        }
        
        public function testGetAliasReturnsColumnNameWhenAliasIsNotSet()
        {
            $column = new DerivedColumn('column');
            
            $this->assertEquals('column', $column->getAlias());
        }
        
        public function testGetAliasReturnsAliasWhenSet()
        {
            $column = new DerivedColumn('column', 'alias');
            
            $this->assertEquals('alias', $column->getAlias());
        }
        
        public function testGetTableReturnsNullByDefault()
        {
            $column = new DerivedColumn('column');
            
            $this->assertNull($column->getTable());
        }
        
        public function testSetTableDoesNotAffectOriginalObject()
        {
            $table = $this->getMock('\Aztech\Skwal\CorrelatableReference');
            
            $column = new DerivedColumn('column');
            
            $column->setTable($table);
            
            $this->assertNull($column->getTable());
        }
        
        public function testSetTableReturnsNewObjectWithCorrectlyClonedProperties()
        {
            $table = $this->getMock('\Aztech\Skwal\CorrelatableReference');
            
            $column = new DerivedColumn('column', 'alias');
            
            $clone = $column->setTable($table);
            
            $this->assertNotSame($column, $clone, 'Object is cloned.');
            $this->assertSame($table, $clone->getTable());
            
            $this->assertEquals('column', $column->getValue());
            $this->assertEquals('alias', $column->getAlias());
        }
        
        public function testCloningInstanceClonesSubObjects()
        {
            $table = $this->getMock('\Aztech\Skwal\CorrelatableReference');
            
            $column = new DerivedColumn('column');
            $column = $column->setTable($table);
            
            $clone = clone $column;
            
            $this->assertNotSame($table, $clone->getTable());
        }
    }
    
}