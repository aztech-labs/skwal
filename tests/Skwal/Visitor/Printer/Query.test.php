<?php
namespace Test\Skwal\Visitor\Printer
{

    use Skwal\Expression\LiteralExpression;
    use Skwal\CompOp;
use Skwal\OrderBy;

    class QueryTest extends \PHPUnit_Framework_TestCase
    {

        public function testVisitDispatchesCallToVisitable()
        {
            $visitor = new \Skwal\Visitor\Printer\Query();

            $query = $this->getMock('\Skwal\Query');

            $query->expects($this->once())
                ->method('acceptQueryVisitor')
                ->with($this->equalTo($visitor));

            $visitor->visit($query);
        }

        public function testVisitSimpleSelect()
        {
            $visitor = new \Skwal\Visitor\Printer\Query();

            $table = new \Skwal\Table('table');
            $query = new \Skwal\Query\Select();

            $query = $query->setTable($table)->addColumn($table->getColumn('column'));

            $this->assertEquals('SELECT table.column AS column FROM table AS table', $visitor->printQuery($query));
        }

        public function testVisitSimpleSelectWithWhere()
        {
            $visitor = new \Skwal\Visitor\Printer\Query();

            $table = new \Skwal\Table('table');
            $query = new \Skwal\Query\Select();
            $predicate = new \Skwal\Condition\ComparisonPredicate(new LiteralExpression(1), CompOp::Equals,
                new LiteralExpression(1));

            $query = $query->setTable($table)
                ->addColumn($table->getColumn('column'))
                ->setCondition($predicate);

            $this->assertEquals('SELECT table.column AS column FROM table AS table WHERE 1 = 1',
                $visitor->printQuery($query));
        }

        public function testVisitSimpleSelectWithGroupBy()
        {
            $visitor = new \Skwal\Visitor\Printer\Query();

            $table = new \Skwal\Table('table');
            $query = new \Skwal\Query\Select();
            $predicate = new \Skwal\Condition\ComparisonPredicate(new LiteralExpression(1), CompOp::Equals,
                new LiteralExpression(1));

            $query = $query->setTable($table)
                ->addColumn($table->getColumn('column'))
                ->groupBy($table->getColumn('column'));

            $this->assertEquals('SELECT table.column AS column FROM table AS table GROUP BY table.column',
                $visitor->printQuery($query));
        }

        public function testVisitSimpleSelectWithOrderBy()
        {
            $visitor = new \Skwal\Visitor\Printer\Query();

            $table = new \Skwal\Table('table');
            $query = new \Skwal\Query\Select();
            $predicate = new \Skwal\Condition\ComparisonPredicate(new LiteralExpression(1), CompOp::Equals,
                new LiteralExpression(1));

            $query = $query->setTable($table)
            ->addColumn($table->getColumn('column'))
            ->orderBy(new OrderBy($table->getColumn('column')));

            $this->assertEquals('SELECT table.column AS column FROM table AS table ORDER BY table.column ASC',
                $visitor->printQuery($query));
        }

        /**
         * @expectedException RuntimeException
         */
        public function testVisitUpdateThrowsException()
        {
            $visitor = new \Skwal\Visitor\Printer\Query();

            $visitor->visitUpdate();
        }

        /**
         * @expectedException RuntimeException
         */
        public function testVisitDeleteThrowsException()
        {
            $visitor = new \Skwal\Visitor\Printer\Query();

            $visitor->visitDelete();
        }

        /**
         * @expectedException RuntimeException
         */
        public function testVisitInsertThrowsException()
        {
            $visitor = new \Skwal\Visitor\Printer\Query();

            $visitor->visitInsert();
        }
    }
}