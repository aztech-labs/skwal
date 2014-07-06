<?php
namespace Aztech\Skwal\Tests\Visitor\Printer\Assembler
{

    use Aztech\Skwal\Visitor\Printer\Assembler\Select;

    class SelectTest extends \PHPUnit_Framework_TestCase
    {

        /**
         * @expectedException RuntimeException
         */
        public function testAssemblingWithEmptySelectListThrowsException()
        {
            $assembler = new Select();

            $assembler->getAssembledStatement();
        }

        /**
         * @expectedException RuntimeException
         */
        public function testAssemblingWithEmptyFromClauseThrowsException()
        {
            $assembler = new Select();

            $assembler->setSelectList(array(
                'expression'
            ));

            $assembler->getAssembledStatement();
        }

        public function testAssemblingSimpleQueryReturnsProperString()
        {
            $assembler = new Select();

            $assembler->setSelectList(array('expression'));
            $assembler->setFromClause('table');

            $this->assertEquals('SELECT expression FROM table', $assembler->getAssembledStatement());
        }

        public function testAssemblingSimpleQueryWithWhereReturnsProperString()
        {
            $assembler = new Select();

            $assembler->setSelectList(array('expression'));
            $assembler->setFromClause('table');
            $assembler->setWhereClause('1 = 1');

            $this->assertEquals('SELECT expression FROM table WHERE 1 = 1', $assembler->getAssembledStatement());
        }

        public function testAssemblingSimpleQueryWithGroupByReturnsProperString()
        {
            $assembler = new Select();

            $assembler->setSelectList(array('expression'));
            $assembler->setFromClause('table');
            $assembler->setGroupByList(array('1'));

            $this->assertEquals('SELECT expression FROM table GROUP BY 1', $assembler->getAssembledStatement());
        }

        public function testAssemblingSimpleQueryWithOrderByReturnsProperString()
        {
            $assembler = new Select();

            $assembler->setSelectList(array('expression'));
            $assembler->setFromClause('table');
            $assembler->setOrderByList(array('expression'));

            $this->assertEquals('SELECT expression FROM table ORDER BY expression', $assembler->getAssembledStatement());
        }

        public function testAssemblingSimpleQueryAssemblesElementsInCorrectOrder()
        {
            $assembler = new Select();

            $assembler->setSelectList(array('expression'));
            $assembler->setFromClause('table');
            $assembler->setWhereClause('1 = 1');
            $assembler->setGroupByList(array('1'));
            $assembler->setLimitClause('1', '1');
            $assembler->setOrderByList(array('1 ASC', '2 DESC'));
            $this->assertEquals('SELECT expression FROM table WHERE 1 = 1 GROUP BY 1 ORDER BY 1 ASC, 2 DESC', $assembler->getAssembledStatement());
        }
    }
}