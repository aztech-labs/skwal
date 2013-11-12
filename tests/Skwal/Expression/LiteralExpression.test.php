<?php
namespace Test\Skwal\Expression
{

    use Skwal\Expression\LiteralExpression;

    class LiteralExpressionTest extends \PHPUnit_Framework_TestCase
    {

        public function getValues()
        {
            return array(array(0), array(1), array(10.25), array('some text'),
                array(''), array(false), array(true), array(-15), array(-15.5));
        }
        
        /**
         * @dataProvider getValues
         */
        public function testGetValueReturnsCorrectValue($value)
        {
            $constant = new LiteralExpression($value);
            
            $this->assertEquals($value, $constant->getValue());
        }
        
        public function testGetAliasReturnsCorrectAlias()
        {
            $constant = new LiteralExpression('anything', 'alias');
            
            $this->assertEquals('alias', $constant->getAlias());
        }
        
        public function testSetAliasReturnsNewInstanceWithCorrectAliasAndSameValue()
        {
            $constant = new LiteralExpression('anything', 'alias');
            
            $clone = $constant->setAlias('newAlias');
            
            $this->assertNotSame($constant, $clone);
            $this->assertEquals('newAlias', $clone->getAlias());
        }
        
        public function testAcceptExpressionVisitorCallsCorrectVisitMethod()
        {
            $constant = new LiteralExpression('anything', 'alias');
            $visitor = $this->getMock('\Skwal\Visitor\Expression');
            
            $visitor->expects($this->once())
                ->method('visitLiteral')
                ->with($this->equalTo($constant));;
            
            $constant->acceptExpressionVisitor($visitor);
        }
    }
}