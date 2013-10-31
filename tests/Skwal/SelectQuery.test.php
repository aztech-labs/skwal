<?php
namespace Test\Skwal
{

    use Skwal\SelectQuery;
use Skwal\Expression\DerivedColumn;
				
    class SelectQueryTest extends \PHPUnit_Framework_TestCase
    {

        public function testAcceptCorrelatableVisitorCallsProperVisitMethod()
        {
            $query = new SelectQuery();
            
            $visitor = $this->getMock('\Skwal\Visitor\Correlatable');
            
            $visitor->expects($this->once())
                ->method('visitQuery')
                ->with($this->equalTo($query));
            
            $query->acceptCorrelatableVisitor($visitor);
        }

        public function testAcceptQueryVisitorCallsProperVisitMethod()
        {
            $query = new SelectQuery();
            
            $visitor = $this->getMock('\Skwal\Visitor\Query');
            
            $visitor->expects($this->once())
                ->method('visitSelect')
                ->with($this->equalTo($query));
            
            $query->acceptQueryVisitor($visitor);
        }
        
        public function getInvalidIndexes()
        {
            return array(array(-1), array(0), array(1), array(2));
        }
        
        /**
         * @dataProvider getInvalidIndexes
         * @expectedException \OutOfRangeException
         */
        public function testGetColumnThrowsExceptionWhenIndexIsOutOfBounds($index)
        {
            $query = new SelectQuery();
            
            $query->getColumn($index);
        }
        
        public function getValidColumnsAndIndexes()
        {
            $columns = array(new DerivedColumn('one'), new DerivedColumn('two'));
            
            return array(array($columns, 0), array($columns, 1));
        }
        
        /**
         * @dataProvider getValidColumnsAndIndexes
         */
        public function testGetColumnReturnsCorrectColumn($columns, $index)
        {
            $query = new SelectQuery();
            
            foreach($columns as $column) {
                $query = $query->addColumn($column);
            }
            
            $this->assertEquals($columns[$index], $query->getColumn($index));
        }
        
        public function getColumns()
        {
            return array(
            	array(new DerivedColumn('one'),
                array(new DerivedColumn('one'), new DerivedColumn('two')))
            );
        }
        
        /**
         * @dataProvider getColumns
         */
        public function testGetColumnsReturnsAllColumns($columns)
        {
            $query = new SelectQuery();
            $expected = array();
            
            foreach($columns as $column) {
                $query = $query->addColumn($column);
                $expected[] = $column;
            }
            
            $this->assertEquals($expected, $query->getColumns());
        }
        
        public function testGetCorrelationNameReturnsCorrectValue()
        {
            $query = new SelectQuery('alias');
            
            $this->assertEquals('alias', $query->getCorrelationName());
        }
        
        public function testDeriveColumnSetsAppropriateCorrelationReference()
        {
            $query = new SelectQuery();
            $query = $query->addColumn(new DerivedColumn('alias'));
            
            $column = $query->deriveColumn(0);
            
            $this->assertSame($query, $column->getTable());
        }
    }
}