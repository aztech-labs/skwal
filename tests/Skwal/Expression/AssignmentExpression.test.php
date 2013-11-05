<?php

namespace Test\Skwal\Expression
{
    use Skwal\Expression\AssignmentExpression;
				class AssignmentExpressionTest extends \PHPUnit_Framework_TestCase
    {
        public function testGetAssigneeReturnsCorrectInstance()
        {
            $assignee = $this->getMock('\Skwal\Expression\AssignableExpression');
            $value = $this->getMock('\Skwal\Expression\AliasExpression');

            $assignment = new AssignmentExpression($assignee, $value);

            $this->assertSame($assignee, $assignment->getAssignee());
        }

        public function testGetValueReturnsCorrectInstance()
        {
            $assignee = $this->getMock('\Skwal\Expression\AssignableExpression');
            $value = $this->getMock('\Skwal\Expression\AliasExpression');

            $assignment = new AssignmentExpression($assignee, $value);

            $this->assertSame($value, $assignment->getValue());
        }

        public function testAcceptExpressionVisitorDelegatesCallToCorrectMethod()
        {
            $assignee = $this->getMock('\Skwal\Expression\AssignableExpression');
            $value = $this->getMock('\Skwal\Expression\AliasExpression');

            $assignment = new AssignmentExpression($assignee, $value);

            $visitor = $this->getMock('\Skwal\Visitor\Expression');
            $visitor->expects($this->once())
                ->method('visitAssignmentExpression')
                ->with($this->equalTo($assignment));

            $assignment->acceptExpressionVisitor($visitor);
        }
    }
}