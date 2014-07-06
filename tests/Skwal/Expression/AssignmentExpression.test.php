<?php

namespace Aztech\Skwal\Tests\Expression
{
    use Aztech\Skwal\Expression\AssignmentExpression;
				class AssignmentExpressionTest extends \PHPUnit_Framework_TestCase
    {
        public function testGetAssigneeReturnsCorrectInstance()
        {
            $assignee = $this->getMock('\Aztech\Skwal\Expression\AssignableExpression');
            $value = $this->getMock('\Aztech\Skwal\Expression\AliasExpression');

            $assignment = new AssignmentExpression($assignee, $value);

            $this->assertSame($assignee, $assignment->getAssignee());
        }

        public function testGetValueReturnsCorrectInstance()
        {
            $assignee = $this->getMock('\Aztech\Skwal\Expression\AssignableExpression');
            $value = $this->getMock('\Aztech\Skwal\Expression\AliasExpression');

            $assignment = new AssignmentExpression($assignee, $value);

            $this->assertSame($value, $assignment->getValue());
        }

        public function testAcceptExpressionVisitorDelegatesCallToCorrectMethod()
        {
            $assignee = $this->getMock('\Aztech\Skwal\Expression\AssignableExpression');
            $value = $this->getMock('\Aztech\Skwal\Expression\AliasExpression');

            $assignment = new AssignmentExpression($assignee, $value);

            $visitor = $this->getMock('\Aztech\Skwal\Visitor\Expression');
            $visitor->expects($this->once())
                ->method('visitAssignmentExpression')
                ->with($this->equalTo($assignment));

            $assignment->acceptExpressionVisitor($visitor);
        }
    }
}