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
 * Tests for Simple command
 *
 * @package Fuel\Email
 * @author  Fuel Development Team
 *
 * @coversDefaultClass  Fuel\Email\Transport\Smtp\Command\Simple
 */
class SimpleTest extends AbstractCommandTest
{
	public function _before()
	{
		$mock = $this->createMock();

		$mock->shouldReceive('read')
			->andReturn(new Response('123 Test response'));

		$this->object = new DummySimpleCommand($mock);
	}

	/**
	 * @covers ::execute
	 * @covers ::getCommand
	 * @covers ::perform
	 * @group  Email
	 */
	public function testExecute()
	{
		$this->invoke($this->object);
	}

	/**
	 * @covers            ::execute
	 * @covers            ::getCommand
	 * @expectedException LogicException
	 * @group             Email
	 */
	public function testEmptyCode()
	{
		$this->object->code = null;

		$this->invoke($this->object);
	}

	/**
	 * @covers            ::execute
	 * @covers            ::getCommand
	 * @covers            ::perform
	 * @expectedException RuntimeException
	 * @group             Email
	 */
	public function testInvalidCode()
	{
		$mock = $this->createMock();

		$mock->shouldReceive('read')
			->andReturn(new Response('321 Test response'));

		$object = new DummySimpleCommand($mock);

		$this->invoke($object);
	}

	/**
	 * @covers ::execute
	 * @covers ::getCommand
	 * @covers ::perform
	 * @group  Email
	 */
	public function testPerformFalse()
	{
		$mock = $this->createMock();

		$mock->shouldReceive('write')
			->andReturn(false);

		$object = new DummySimpleCommand($mock);

		$this->invoke($object);
	}
}
