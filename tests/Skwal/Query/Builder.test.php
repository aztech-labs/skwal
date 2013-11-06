<?php
namespace Test\Skwal\Query
{

    use Skwal\Query\Builder;

    class BuilderTest extends \PHPUnit_Framework_TestCase
    {

        public function testExprsReturnsExpressionBuilder()
        {
            $builder = new Builder();
            
            $exprs = $builder->exprs();
            
            $this->assertNotNull($exprs);
            $this->assertInstanceOf('\Skwal\Expression\Builder', $exprs);
        }
        
        public function testSelectBuildsSelectQuery()
        {
            $builder = new Builder();
            
            $select = $builder->select('table');
            $query = $builder->getQuery();
            
            $this->assertInstanceOf('\Skwal\Query', $query);
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
    }
}