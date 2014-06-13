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

use Fuel\Email\Transport\DummyTransport;

/**
 * Tests for abstract transport
 *
 * @package Fuel\Email
 * @author  Fuel Development Team
 *
 * @coversDefaultClass  Fuel\Email\Transport
 */
class TransportTest extends Transport\AbstractTransportTest
{
	protected $config;

	public function _before()
	{
		$this->config = $this->getConfig();

		$this->object = new DummyTransport($this->config);
	}

	/**
	 * @covers ::getConfig
	 * @group  Email
	 */
	public function testConfig()
	{
		$this->assertSame($this->config, $this->object->getConfig());
	}

	/**
	 * @covers ::getMessageId
	 * @group  Email
	 */
	public function testId()
	{
		$email = 'john@doe.com';
		$message = \Mockery::mock('Fuel\\Email\\Message');
		$message->shouldReceive('getFrom->getEmail')
			->andReturn($email);

		$this->assertRegExp('/<(?:.*)(?:@doe.com)>/', $this->object->getMessageId($message));
	}

	/**
	 * @covers ::__construct
	 * @group  Email
	 */
	public function testConstruct()
	{
		$this->object = new DummyTransport($this->getConfig());
	}
}
