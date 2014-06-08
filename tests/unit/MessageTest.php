<?php
/**
 * @package   Fuel\Email
 * @version   2.0
 * @author    Fuel Development Team
 * @license   MIT License
 * @copyright 2010 - 2014 Fuel Development Team
 * @link      http://fuelphp.com
 */

namespace Fuel\Email;

use Codeception\TestCase\Test;

/**
 * Tests for Message
 *
 * @package Fuel\Email
 * @author  Fuel Development Team
 *
 * @coversDefaultClass Fuel\Email\Message
 */
class MessageTest extends Test
{
	/**
	 * @var Fuel\Email\Message
	 */
	protected $object;

	public function _before()
	{
		$this->object = new Message;
	}

	/**
	 * @covers ::getFrom
	 * @covers ::setFrom
	 * @group  Email
	 */
	public function testFrom()
	{
		$from = \Mockery::mock('Fuel\\Email\\Address');

		$this->assertSame($this->object, $this->object->setFrom($from));

		$this->assertEquals($from, $this->object->getFrom());
	}

	/**
	 * @covers ::getSubject
	 * @covers ::setSubject
	 * @group  Email
	 */
	public function testSubject()
	{
		$subject = 'subject';

		$this->assertSame($this->object, $this->object->setSubject($subject));

		$this->assertEquals($subject, $this->object->getSubject());
	}

	/**
	 * @covers ::addReplyTo
	 * @covers ::getReplyTo
	 * @covers ::clearReplyTo
	 * @group  Email
	 */
	public function testReplyTo()
	{
		$replyTo = new Address('john@doe.com', 'John Doe');

		$this->assertSame($this->object, $this->object->addReplyTo($replyTo));

		$this->assertEquals([$replyTo], $this->object->getReplyTo());

		$this->assertSame($this->object, $this->object->clearReplyTo());

		$this->assertEquals([], $this->object->getReplyTo());
	}
}
