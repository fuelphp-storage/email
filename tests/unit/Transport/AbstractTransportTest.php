<?php
/**
 * @package   Fuel\Email
 * @version   2.0
 * @author    Fuel Development Team
 * @license   MIT License
 * @copyright 2010 - 2014 Fuel Development Team
 * @link      http://fuelphp.com
 */

namespace Fuel\Email\Transport;

use Codeception\TestCase\Test;

/**
 * Abstract test class for Transport
 *
 * @package Fuel\Email
 * @author  Fuel Development Team
 */
abstract class AbstractTransportTest extends Test
{
	/**
	 * @var Fuel\Email\TransportInterface
	 */
	protected $object;

	/**
	 * Returns a Message mock
	 *
	 * @return Message
	 */
	protected function getMessage()
	{
		return \Mockery::mock('Fuel\\Email\\Message');
	}

	/**
	 * Returns a Config container mock
	 *
	 * @return Fuel\Config\Container
	 */
	protected function getConfig()
	{
		$mock = \Mockery::mock('Fuel\\Config\\Container');

		$mock->shouldReceive('merge')
			->andReturn($mock)
			->byDefault();

		$mock->shouldReceive('get')
			->andReturn(array())
			->byDefault();

		$mock->shouldReceive('set')
			->andReturn($mock)
			->byDefault();

		return $mock;
	}

	/**
	 * @covers ::send
	 * @group  Email
	 */
	public function testSend()
	{
		$mock = $this->getMessage();

		$this->assertTrue($this->object->send($mock));
	}
}
