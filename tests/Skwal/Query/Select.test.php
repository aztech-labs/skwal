<?php
namespace Test\Skwal
{

    use Skwal\Query\Select;
    use Skwal\Expression\DerivedColumn;

    class SelectTest extends \PHPUnit_Framework_TestCase
    {

        public function testAcceptCorrelatableVisitorCallsProperVisitMethod()
        {
            $query = new Select();

            $visitor = $this->getMock('\Skwal\Visitor\Correlatable');

            $visitor->expects($this->once())
                ->method('visitQuery')
                ->with($this->equalTo($query));

            $query->acceptCorrelatableVisitor($visitor);
        }

        public function testAcceptQueryVisitorCallsProperVisitMethod()
        {
            $query = new Select();

            $visitor = $this->getMock('\Skwal\Visitor\Query');

            $visitor->expects($this->once())
                ->method('visitSelect')
                ->with($this->equalTo($query));

            $query->acceptQueryVisitor($visitor);
        }

        public function testAddColumnReturnsNewQueryInstance()
        {
            $query = new Select();

            $column = $this->getMock('\Skwal\Expression\AliasExpression');

            $this->assertNotSame($query, $query->addColumn($column));
        }

        public function getInvalidIndexes()
        {
            return array(
                array(
                    - 1
                ),
                array(
                    0
                ),
                array(
                    1
                ),
                array(
                    2
                )
            );
        }

        /**
         * @dataProvider getInvalidIndexes
         * @expectedException \OutOfRangeException
         */
        public function testGetColumnThrowsExceptionWhenIndexIsOutOfBounds($index)
        {
            $query = new Select();

            $query->getColumn($index);
        }

        public function getValidColumnsAndIndexes()
        {
            $columns = array(
                new DerivedColumn('one'),
                new DerivedColumn('two')
            );

            return array(
                array(
                    $columns,
                    0
                ),
                array(
                    $columns,
                    1
                )
            );
        }

        /**
         * @dataProvider getValidColumnsAndIndexes
         */
        public function testGetColumnReturnsCorrectColumn($columns, $index)
        {
            $query = new Select();

            foreach ($columns as $column) {
                $query = $query->addColumn($column);
            }

            $this->assertEquals($columns[$index], $query->getColumn($index));
        }

        public function getColumns()
        {
            return array(
                array(
                    new DerivedColumn('one')
                ),
                array(
                    new DerivedColumn('one'),
                    new DerivedColumn('two')
                )
            );
        }

        /**
         * @dataProvider getColumns
         */
        public function testGetColumnsReturnsAllColumns($columns)
        {
            $query = new Select();
            $expected = array();

            foreach ($columns as $column) {
                $query = $query->addColumn($column);
                $expected[] = $column;
            }

            $this->assertEquals($expected, $query->getColumns());
        }

        public function testGetCorrelationNameReturnsCorrectValue()
        {
            $query = new Select('alias');

            $this->assertEquals('alias', $query->getCorrelationName());
        }

        public function testDeriveColumnSetsAppropriateCorrelationReference()
        {
            $query = new Select();
            $query = $query->addColumn(new DerivedColumn('alias'));

            $column = $query->deriveColumn(0);

            $this->assertSame($query, $column->getTable());
        }

        public function testDeriveColumnsSetsAppropriateCorrelationReferences()
        {
            $query = new Select();
            $query = $query->addColumn(new DerivedColumn('alias'));

            $derived = $query->deriveColumns();

            $this->assertSame($query, $derived[0]->getTable());
        }

        public function testSetTableReturnsNewInstance()
        {
            $query = new Select();
            $table = $this->getMock('\Skwal\CorrelatableReference');

            $this->assertNotSame($query, $query->setTable($table));
        }

        public function testGetTableReturnsSetValue()
        {
            $query = new Select();
            $table = $this->getMock('\Skwal\CorrelatableReference');

            $query = $query->setTable($table);

            $this->assertSame($table, $query->getTable());
        }

        public function testGetConditionReturnsDefaultNullValue()
        {
            $query = new Select();

            $this->assertNull($query->getCondition());
        }

        public function testSetConditionReturnsNewQueryInstance()
        {
            $query = new Select();

            $condition = $this->getMock('\Skwal\Condition\Predicate');

            $this->assertNotSame($query->setCondition($condition), $condition);
        }

        public function testGroupByReturnsNewQueryInstance()
        {
            $query = new Select();

            $column = $this->getMock('\Skwal\Expression\AliasExpression');

            $this->assertNotSame($query, $query->groupBy($column));
        }

        public function testGetGroupingColumnsReturnsCorrectArray()
        {
            $query = new Select();

            $groupBys = array();
            for ($i = 0; $i < 10; $i++) {
                $column = $this->getMock('\Skwal\Expression\AliasExpression');

                $groupBys[] = $column;
                $query = $query->groupBy($column);
            }

            $returned = $query->getGroupingColumns();
            for ($i = 0; $i < 10; $i++) {
                $this->assertSame($groupBys[$i], $returned[$i]);
            }
        }
    }
}