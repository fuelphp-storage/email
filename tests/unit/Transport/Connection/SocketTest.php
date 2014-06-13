<?php
/**
 * @package   Fuel\Email
 * @version   2.0
 * @author    Fuel Development Team
 * @license   MIT License
 * @copyright 2010 - 2014 Fuel Development Team
 * @link      http://fuelphp.com
 */

namespace Fuel\Email\Transport\Connection;

use Codeception\TestCase\Test;
use RuntimeException;

/**
 * Tests for Socket Client
 *
 * @package Fuel\Email
 * @author  Fuel Development Team
 *
 * @coversDefaultClass  Fuel\Email\Transport\Connection\Socket
 */
class SocketTest extends Test
{
	/**
	 * @var Fuel\Email\Transport\Connection\Socket
	 */
	protected $object;

	public function _before()
	{
		$this->object = new Socket;

		try
		{
			$this->object->open('tcp://127.0.0.1:1025');
		}
		catch (RuntimeException $e)
		{
			$this->markTestSkipped('Connection not available.');
		}
	}

	public function _after()
	{
		$this->object->close();
	}

	/**
	 * @covers ::open
	 * @covers ::changeState
	 * @group  Email
	 */
	public function testOpen()
	{
		$object = new Socket;
		$this->assertTrue($object->open('tcp://127.0.0.1:1025'));
		$this->assertTrue($object->isState(Socket::ESTABILISHED));
	}

	/**
	 * @covers            ::open
	 * @expectedException RuntimeException
	 * @group             Email
	 */
	public function testOpenInvalidTimeout()
	{
		$object = new Socket;
		$object->open('tcp://127.0.0.1:1025', 'INVALID');
	}

	/**
	 * @covers            ::open
	 * @expectedException LogicException
	 * @group             Email
	 */
	public function testOpenAlreadyOpened()
	{
		$this->object->open('tcp://127.0.0.1:1025');
	}

	/**
	 * @covers            ::open
	 * @expectedException RuntimeException
	 * @group             Email
	 */
	public function testOpenInvalidStream()
	{
		$object = new Socket;
		$object->open('tcp', 'localhosta', 1025);
	}

	/**
	 * @covers ::close
	 * @group  Email
	 */
	public function testClose()
	{
		$this->assertTrue($this->object->close());
		$this->assertTrue($this->object->isState(Socket::CLOSED));
		$this->object->open('tcp://127.0.0.1:1025');
	}

	/**
	 * @covers            ::close
	 * @expectedException LogicException
	 * @group             Email
	 */
	public function testAlreadyClosed()
	{
		$object = new Socket;
		$object->close();
	}

	/**
	 * @covers ::getState
	 * @covers ::isState
	 * @group  Email
	 */
	public function testState()
	{
		$this->assertEquals(Socket::ESTABILISHED, $state = $this->object->getState());
		$this->assertTrue($this->object->isState($state));
	}

	/**
	 * @covers ::setTimeout
	 * @covers ::isTimedOut
	 * @group  Email
	 */
	public function testTimeout()
	{
		$this->assertTrue($this->object->setTimeout(1));
		$this->assertFalse($this->object->isTimedOut());
	}

	/**
	 * @covers ::getStream
	 * @covers ::isEof
	 * @covers ::setBlocking
	 * @group  Email
	 */
	public function testStream()
	{
		$this->assertTrue(is_resource($this->object->getStream()));
		$this->assertFalse($this->object->isEof());
		$this->assertTrue($this->object->setBlocking(0));
	}
}
