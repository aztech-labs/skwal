<?php
namespace Test\Skwal\Expression
{

    use Skwal\Expression\ParameterExpression;

    class ParameterExpressionTest extends \PHPUnit_Framework_TestCase
    {

        public function testGetNameReturnsCorrectName()
        {
            $parameter = new ParameterExpression('param');

            $this->assertEquals('param', $parameter->getName());
        }

        public function testAcceptVisitorDispatchesCallToCorrectMethod()
        {
            $parameter = new ParameterExpression('param');

            $visitor = $this->getMock('\Skwal\Visitor\Expression');

            $visitor->expects($this->once())
                ->method('visitParameter')
                ->with($this->equalTo($parameter));

            $parameter->acceptExpressionVisitor($visitor);
        }
    }
}