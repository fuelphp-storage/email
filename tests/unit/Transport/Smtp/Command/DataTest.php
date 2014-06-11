<?php
/**
 * @package   Fuel\Email
 * @version   2.0
 * @author    Fuel Development Team
 * @license   MIT License
 * @copyright 2010 - 2014 Fuel Development Team
 * @link      http://fuelphp.com
 */

namespace Fuel\Email\Transport\Smtp\Command;

use Fuel\Email\Transport\Smtp\Response;

/**
 * Tests for DATA command
 *
 * @package Fuel\Email
 * @author  Fuel Development Team
 *
 * @coversDefaultClass  Fuel\Email\Transport\Smtp\Command\Data
 */
class DataTest extends AbstractCommandTest
{
	public function _before()
	{
		$mock = $this->createMock();

		$mock->shouldReceive('read')
			->andReturn(
				new Response('354'),
				new Response('250')
			);

		$this->object = new Data($mock, "Data\r\n.Another data");
	}

	/**
	 * @covers            ::execute
	 * @expectedException RuntimeException
	 * @group             Email
	 */
	public function testCannotPerform()
	{
		$mock = $this->createMock();

		$mock->shouldReceive('read')
			->andReturn(
				new Response('123'),
				new Response('250')
			);

		$object = new Data($mock, 'Data');

		$this->invoke($object);
	}

	/**
	 * @covers            ::execute
	 * @expectedException RuntimeException
	 * @group             Email
	 */
	public function testCannotSend()
	{
		$mock = $this->createMock();

		$mock->shouldReceive('read')
			->andReturn(
				new Response('354'),
				new Response('123')
			);

		$object = new Data($mock, 'Data');

		$this->invoke($object);
	}

	/**
	 * @covers ::__construct
	 * @group  Email
	 */
	public function testConstruct()
	{
		$mock = $this->createMock();

		$object = new Data($mock, 'Data');
	}
}
