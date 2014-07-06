<?php
namespace Aztech\Skwal\Tests
{

    use Aztech\Skwal\OrderBy;

    class OrderByTest extends \PHPUnit_Framework_TestCase
    {

        public function testGetExpressionReturnsCorrectInstance()
        {
            $expression = $this->getMock('\Aztech\Skwal\Expression');

            $orderBy = new OrderBy($expression);

            $this->assertSame($expression, $orderBy->getExpression());
        }

        public function testIsDescendingReturnsCorrectValues()
        {
            $expression = $this->getMock('\Aztech\Skwal\Expression');

            $orderBy = new OrderBy($expression, false);
            $this->assertFalse($orderBy->isDescending());

            $orderBy = new OrderBy($expression, true);
            $this->assertTrue($orderBy->isDescending());
        }

    }
}