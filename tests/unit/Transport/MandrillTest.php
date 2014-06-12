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
 * Tests for Mandrill transport
 *
 * @package Fuel\Email
 * @author  Fuel Development Team
 *
 * @coversDefaultClass  Fuel\Email\Transport\Mandrill
 */
class MandrillTest extends AbstractTransportTest
{
	public function _before()
	{
		$mock = \Mockery::mock('Mandrill');

		$this->object = new Mandrill($mock);
	}

	/**
	 * @covers ::getMandrill
	 * @covers ::setMandrill
	 * @group  Email
	 */
	public function testMandrill()
	{
		$mock = \Mockery::mock('Mandrill');

		$this->assertSame($this->object, $this->object->setMandrill($mock));
		$this->assertSame($mock, $this->object->getMandrill());
	}

	/**
	 * @covers ::__construct
	 * @covers ::getMandrill
	 * @group  Email
	 */
	public function testConstruct()
	{
		$mock = \Mockery::mock('Mandrill');

		$object = new Mandrill($mock);

		$this->assertSame($mock, $object->getMandrill());
	}
}
