<?php
/**
 * @package   Fuel\Email
 * @version   2.0
 * @author    Fuel Development Team
 * @license   MIT License
 * @copyright 2010 - 2014 Fuel Development Team
 * @link      http://fuelphp.com
 */

namespace Fuel\Email\Transport\Smtp;

use Fuel\Email\Transport\Smtp\Command;
use Codeception\TestCase\Test;

/**
 * Tests for SMTP Connection
 *
 * @package Fuel\Email
 * @author  Fuel Development Team
 *
 * @coversDefaultClass  Fuel\Email\Transport\Smtp\Connection
 */
class ConnectionTest extends Test
{
	/**
	 * @var Fuel\Email\Transport\Smtp\Connection
	 */
	protected $object;

	public function _before()
	{
		$this->object = new DummyConnection();
		$this->object->open('tcp', 'smtp.gmail.com', 587);
	}

	public function _after()
	{
		// $this->object->close();
	}

	/**
	 * @covers ::open
	 * @covers ::changeState
	 * @group  Email
	 */
	public function testOpen()
	{
		$object = new DummyConnection();
		$this->assertTrue($object->open('tcp', 'smtp.gmail.com', 587));
		$this->assertTrue($object->isState(Connection::ESTABILISHED));
	}

	/**
	 * @covers            ::open
	 * @expectedException LogicException
	 * @group             Email
	 */
	public function testOpenInvalidTimeout()
	{
		$object = new DummyConnection();
		$object->open('tcp', 'smtp.gmail.com', 587, 'INVALID');
	}

	/**
	 * @covers            ::open
	 * @expectedException LogicException
	 * @group             Email
	 */
	public function testOpenAlreadyOpened()
	{
		$this->object->open('tcp', 'smtp.gmail.com', 587);
	}

	/**
	 * @covers            ::open
	 * @expectedException RuntimeException
	 * @group             Email
	 */
	public function testOpenInvalidStream()
	{
		$object = new DummyConnection();
		$object->open('tcp', 'smtpa.gmail.com', 587);
	}

	/**
	 * @covers ::close
	 * @group  Email
	 */
	public function testClose()
	{
		$this->assertNull($this->object->close());
		$this->assertTrue($this->object->isState(Connection::CLOSED));
	}

	/**
	 * @covers ::authenticate
	 * @group  Email
	 */
	public function testAuthenticate()
	{
		$auth = new DummyAuthentication('user', 'pass');

		$this->assertTrue($this->object->authenticate($auth));
		$this->assertTrue($this->object->isState(Connection::CONNECTED));
	}

	/**
	 * @covers            ::authenticate
	 * @expectedException LogicException
	 * @group             Email
	 */
	public function testAuthenticateNonEstabilished()
	{
		$object = new DummyConnection();
		$auth = new DummyAuthentication('user', 'pass');

		$this->assertTrue($object->authenticate($auth));
	}

	/**
	 * @covers            ::authenticate
	 * @expectedException RuntimeException
	 * @group             Email
	 */
	public function testAuthenticateFailure()
	{
		$auth = new DummyAuthentication('user', 'pass');
		$auth->return = false;

		$this->assertTrue($this->object->authenticate($auth));
	}

	/**
	 * @covers ::getState
	 * @covers ::isState
	 * @group  Email
	 */
	public function testState()
	{
		$this->assertEquals(Connection::ESTABILISHED, $state = $this->object->getState());
		$this->assertTrue($this->object->isState($state));
	}

	/**
	 * @covers ::getStream
	 * @group  Email
	 */
	public function testStream()
	{
		$this->assertTrue(is_resource($this->object->getStream()));
	}

	/**
	 * @covers ::getHostname
	 * @group  Email
	 */
	public function testHostname()
	{
		$this->assertEquals('smtp.gmail.com', $this->object->getHostname());
	}

	/**
	 * @covers ::getLastResponse
	 * @covers ::getResponses
	 * @group  Email
	 */
	public function testResponse()
	{
		Command::invoke(new Command\Ehlo($this->object));

		$this->assertInstanceOf('Fuel\\Email\\Transport\\Smtp\\Response', $this->object->getLastResponse());

		$this->assertNotEmpty($this->object->getResponses());
	}
}
