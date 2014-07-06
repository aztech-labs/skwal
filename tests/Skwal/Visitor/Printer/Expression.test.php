<?php
namespace Aztech\Skwal\Tests\Visitor\Printer
{

    class ExpressionTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * @testdox Visiting an expression dispatches the call to the accept method of the expression.
         */
        public function testVisitMethodDispatchesCallToVisitable()
        {
            $expression = $this->getMock('\Aztech\Skwal\Expression\AliasExpression');

            $visitor = new \Aztech\Skwal\Visitor\Printer\Expression();

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
         * @testdox Printing a literal expression returns the expected representation of the literal with an alias clause with quote escaping when necessary.
         */
        public function testPrintLiteralExpression($value, $expected)
        {
            $visitor = new \Aztech\Skwal\Visitor\Printer\Expression();

            $expression = $this->getLiteralMock($visitor, $value);

            $this->assertEquals($expected, $visitor->printExpression($expression));

            $expression = $this->getLiteralMock($visitor, $value, 'alias');

            $this->assertEquals($expected . ' AS alias', $visitor->printExpression($expression));
        }

        private function getLiteralMock($visitor, $value, $alias = null)
        {
            $expression = $this->getMock('\Aztech\Skwal\Expression\LiteralExpression', array(), array(), '', false);

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

        /**
         * @testdox Printing a column expression with no alias returns a <i>tableName.columnName</i> type expression without an alias clause.
         */
        public function testPrintColumnExpressionWithoutAliasReturnsCorrectString()
        {
            $visitor = new \Aztech\Skwal\Visitor\Printer\Expression();
            $visitor->useAliases(false);

            $expression = $this->getColumnMock($visitor, 'table', 'column');

            $this->assertEquals('table.column', $visitor->printExpression($expression));
        }

        /**
         * @testdox Printing a column expression with an alias returns a <i>tableName.columnName</i> type expression with the correct alias clause.
         */
        public function testPrintColumnExpressionWithAliasReturnsCorrectString()
        {
            $visitor = new \Aztech\Skwal\Visitor\Printer\Expression();
            $visitor->useAliases(true);

            $expression = $this->getColumnMock($visitor, 'table', 'column', 'alias');

            $this->assertEquals('table.column AS alias', $visitor->printExpression($expression));
        }

        private function getColumnMock($visitor, $tableName, $value, $alias = null)
        {
            $expression = $this->getMock('\Aztech\Skwal\Expression\DerivedColumn', array(), array(), '', false);

            $expression->expects($this->any())
                ->method('getValue')
                ->will($this->returnValue($value));

            $table = $this->getMock('\Aztech\Skwal\CorrelatableReference');

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

        public function testPrintParameterStringReturnsCorrectString()
        {
            $visitor = new \Aztech\Skwal\Visitor\Printer\Expression();

            $parameter = $this->getMock('\Aztech\Skwal\Expression\ParameterExpression', array(), array(), '', false);
            $parameter->expects($this->any())
                ->method('getName')
                ->will($this->returnValue('param'));

            $parameter->expects($this->atLeastOnce())
                ->method('acceptExpressionVisitor')
                ->with($this->equalTo($visitor))
                ->will($this->returnCallback(function() use ($visitor, $parameter) {
                    $visitor->visitParameter($parameter);
                }));

            $this->assertEquals(':param', $visitor->printExpression($parameter));
        }

        public function testPrintScalarQueryReturnsCorrectString()
        {
            $queryPrinter = $this->getMock('\Aztech\Skwal\Visitor\Printer\Query', array('printQuery'), array(), '', false);
            $query = $this->getMock('\Aztech\Skwal\Query\ScalarSelect', array('getAlias'), array(), '', false);

            $query->expects($this->any())
                ->method('getAlias')
                ->will($this->returnValue('query'));

            $queryPrinter->expects($this->any())
                ->method('printQuery')
                ->with($this->equalTo($query))
                ->will($this->returnValue('scalar-query'));

            $visitor = new \Aztech\Skwal\Visitor\Printer\Expression();
            $visitor->useAliases(true);
            $visitor->setQueryPrinter($queryPrinter);

            $this->assertEquals('(scalar-query) AS query', $visitor->printExpression($query));
        }
    }
}