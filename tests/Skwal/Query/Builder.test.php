<?php
namespace Aztech\Skwal\Tests\Query
{

    use Aztech\Skwal\Query\Builder;

    class BuilderTest extends \PHPUnit_Framework_TestCase
    {

        public function testExprsReturnsExpressionBuilder()
        {
            $builder = new Builder();
            
            $exprs = $builder->exprs();
            
            $this->assertNotNull($exprs);
            $this->assertInstanceOf('\Aztech\Skwal\Expression\Builder', $exprs);
        }
        
        public function testSelectBuildsSelectQuery()
        {
            $builder = new Builder();
            
            $select = $builder->select('table');
            $query = $builder->getQuery();
            
            $this->assertInstanceOf('\Aztech\Skwal\Query', $query);
            $this->assertEquals($query->getTable()->getCorrelationName(), 'table');
        }
        
        public function testGetTableReturnsInstanceWhenMatchIsFound()
        {
            $builder = new Builder();
            
            $select = $builder->select('table');
            $table = $select->getTable('table');
            
            $this->assertNotNull($table);
            $this->assertEquals('table', $table->getCorrelationName());
        }
        
        public function testGetTableReturnsNullWhenNoMatchIsFound()
        {
            $builder = new Builder();
        
            $select = $builder->select('table');
            $table = $select->getTable('unknown');
        
            $this->assertNull($table);
        }
        
        public function testAddColumnAddsColumnToBuiltQuery()
        {
            $builder = new Builder();
            
            $builder->select('table')
                ->addColumn('column');
            $query = $builder->getQuery();
            
            $this->assertNotNull($query->getColumn(0));
            $this->assertEquals('column', $query->getColumn(0)->getAlias());
        }
        
        public function testGetColumnReturnsMatchingColumn()
        {
            $builder = new Builder();
            
            $builder->select('table')
                ->addColumn('column');
            
            $column = $builder->getColumn('column');
            
            $this->assertNotNull($column);
            $this->assertEquals('column', $column->getAlias());
        }
        
        /**
         * @expectedException RuntimeException
         */
        public function testGetColumnThrowsExceptionWhenNoMatchIsFound()
        {
            $builder = new Builder();
            
            $builder->select('table')
                ->addColumn('column');
            
            $column = $builder->getColumn('unknown');
        }
    }
}