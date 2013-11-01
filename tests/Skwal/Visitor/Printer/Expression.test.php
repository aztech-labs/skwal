<?php
namespace Test\Skwal\Visitor\Printer
{

    class ExpressionTest extends \PHPUnit_Framework_TestCase
    {
        public function testVisitMethodDispatchesCallToVisitable()
        {
            $expression = $this->getMock('\Skwal\Expression\AliasExpression');

            $visitor = new \Skwal\Visitor\Printer\Expression();

            $expression->expects($this->once())
                ->method('acceptExpressionVisitor')
                ->with($this->equalTo($visitor));

            $visitor->visit($expression);
        }

        public function getLiteralExpressions()
        {
            return array(array(true, 'TRUE'), array(false, 'FALSE'), array(0, '0'), array(1, '1'),
                array(null, 'NULL'), array('string', "'string'"));
        }

        /**
         * @dataProvider getLiteralExpressions
         */
        public function testPrintLiteralExpression($value, $expected)
        {
            $visitor = new \Skwal\Visitor\Printer\Expression();

            $expression = $this->getLiteralMock($visitor, $value);

            $this->assertEquals($expected, $visitor->printExpression($expression));

            $expression = $this->getLiteralMock($visitor, $value, 'alias');

            $this->assertEquals($expected . ' AS alias', $visitor->printExpression($expression));
        }

        private function getLiteralMock($visitor, $value, $alias = null)
        {
            $expression = $this->getMock('\Skwal\Expression\LiteralExpression', array(), array(), '', false);

            $expression->expects($this->any())
                ->method('getValue')
                ->will($this->returnValue($value));

            if ($alias != null) {
                $expression->expects($this->any())
                    ->method('getAlias')
                    ->will($this->returnValue($alias));
            }

            $expression->expects($this->atLeastOnce())
                ->method('acceptExpressionVisitor')
                ->with($this->equalTo($visitor))
                ->will($this->returnCallback(function() use ($visitor, $expression) {
                    $visitor->visitLiteral($expression);
                }));

            return $expression;
        }

        public function testPrintColumnExpressionWithoutAliasReturnsCorrectString()
        {
            $visitor = new \Skwal\Visitor\Printer\Expression();
            $visitor->useAliases(false);

            $expression = $this->getColumnMock($visitor, 'table', 'column');

            $this->assertEquals('table.column', $visitor->printExpression($expression));
        }

        public function testPrintColumnExpressionWithAliasReturnsCorrectString()
        {
            $visitor = new \Skwal\Visitor\Printer\Expression();
            $visitor->useAliases(true);

            $expression = $this->getColumnMock($visitor, 'table', 'column', 'alias');

            $this->assertEquals('table.column AS alias', $visitor->printExpression($expression));
        }

        private function getColumnMock($visitor, $tableName, $value, $alias = null)
        {
            $expression = $this->getMock('\Skwal\Expression\DerivedColumn', array(), array(), '', false);

            $expression->expects($this->any())
                ->method('getValue')
                ->will($this->returnValue($value));

            $table = $this->getMock('\Skwal\CorrelatableReference');

            $table->expects($this->any())
                ->method('getCorrelationName')
                ->will($this->returnValue($tableName));

            $expression->expects($this->any())
                ->method('getTable')
                ->will($this->returnValue($table));

            if ($alias != null) {
                $expression->expects($this->any())
                    ->method('getAlias')
                    ->will($this->returnValue($alias));
            }

            $expression->expects($this->atLeastOnce())
                ->method('acceptExpressionVisitor')
                ->with($this->equalTo($visitor))
                ->will($this->returnCallback(function() use ($visitor, $expression) {
                    $visitor->visitColumn($expression);
                }));

                return $expression;
        }
    }
}