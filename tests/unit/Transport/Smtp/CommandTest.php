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

use Codeception\TestCase\Test;

/**
 * Tests for SMTP Command
 *
 * @package Fuel\Email
 * @author  Fuel Development Team
 *
 * @coversDefaultClass  Fuel\Email\Transport\Smtp\Command
 */
class CommandTest extends Test
{
	/**
	 * @var Fuel\Email\Transport\Smtp\Command
	 */
	protected $object;

	public function _before()
	{
		$smtp = \Mockery::mock('Fuel\\Email\\Transport\\Smtp');

		$this->object = new DummyCommand($smtp);
	}

	/**
	 * @covers ::execute
	 * @group  Email
	 */
	public function testExecute()
	{
		$this->assertNull($this->object->execute());
	}

	/**
	 * @covers ::__construct
	 * @group  Email
	 */
	public function testConstruct()
	{
		$command = \Mockery::mock('Fuel\\Email\\Transport\\Smtp\\Command');
		$command->shouldReceive('execute');
	}
}
