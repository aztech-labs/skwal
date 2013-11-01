<?php
namespace Test\Skwal\Visitor\Printer\Assembler
{

    use Skwal\Visitor\Printer\Assembler\Select;

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

        public function testAssemblingSimpleQueryAssemblesElementsInCorrectOrder()
        {
            $assembler = new Select();

            $assembler->setSelectList(array('expression'));
            $assembler->setFromClause('table');
            $assembler->setWhereClause('1 = 1');
            $assembler->setGroupByList(array('1'));
            $this->assertEquals('SELECT expression FROM table WHERE 1 = 1 GROUP BY 1', $assembler->getAssembledStatement());
        }
    }
}