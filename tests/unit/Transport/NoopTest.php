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

/**
 * Tests for Noop transport
 *
 * @package Fuel\Email
 * @author  Fuel Development Team
 *
 * @coversDefaultClass  Fuel\Email\Transport\Noop
 */
class NoopTest extends AbstractTransportTest
{
	public function _before()
	{
		$mock = \Mockery::mock('Psr\\Log\\LoggerInterface');

		$this->object = new Noop($mock, $this->getConfig());
	}

	/**
	 * @covers ::__construct
	 * @group  Email
	 */
	public function testConstruct()
	{
		$mock = \Mockery::mock('Psr\\Log\\LoggerInterface');

		$this->object = new Noop($mock, $this->getConfig());
	}
}
