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

use Fuel\Email\Transport\Smtp\Command;
use Codeception\TestCase\Test;

/**
 * Tests for Commands
 *
 * @package Fuel\Email
 * @author  Fuel Development Team
 */
abstract class AbstractCommandTest extends Test
{
	/**
	 * @var Fuel\Email\Transport\Smtp\Command
	 */
	protected $object;

	protected function createMock()
	{
		$mock = \Mockery::mock('Fuel\\Email\\Transport\\Smtp');

		$mock->shouldReceive('write')
			->andReturn(true)
			->byDefault();

		$config = \Mockery::mock('Fuel\\Config\\Container');

		$config->shouldReceive('get')
			->with('newline')
			->andReturn("\r\n")
			->byDefault();

		$mock->shouldReceive('getConfig')
			->andReturn($config)
			->byDefault();

		return $mock;
	}

	protected function invoke(Command $command)
	{
		$this->assertNull($command->execute());
	}

	/**
	 * @covers ::execute
	 * @group  Email
	 */
	public function testExecute()
	{
		$this->invoke($this->object);
	}
}
