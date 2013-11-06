<?php
namespace Test\Skwal\Query
{

    use Skwal\Query\ScalarSelect;
    require_once __DIR__ . '/Select.test.php';

    class ScalarSelectTest extends SelectTest
    {

        public function testGetAliasReturnsCorrectValue()
        {
            $query = new ScalarSelect('test');
            
            $this->assertEquals('test', $query->getAlias());
        }
        
        public function testCanAddColumnAlwaysReturnsTrue()
        {}

        public function testCanAddColumnReturnsTrueWhenQueryHasNoFields()
        {
            $query = new ScalarSelect('test');
            
            $this->assertTrue($query->canAddColumn());
        }
        
        public function testCanAddColumnReturnsFalseWhenQueryHasOneField()
        {
            $expression = $this->getMock('\Skwal\Expression\AliasExpression');
            $query = new ScalarSelect('test');
            
            $query = $query->addColumn($expression);
            
            $this->assertFalse($query->canAddColumn());
        }
        
    }
}