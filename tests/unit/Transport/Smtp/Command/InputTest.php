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
 * Tests for Input command
 *
 * @package Fuel\Email
 * @author  Fuel Development Team
 *
 * @coversDefaultClass  Fuel\Email\Transport\Smtp\Command\Input
 */
class InputTest extends AbstractCommandTest
{
	public function _before()
	{
		$mock = $this->createMock();

		$this->object = new Input($mock, 'HELP');
	}

	/**
	 * @covers ::__construct
	 * @group  Email
	 */
	public function testConstruct()
	{
		$mock = $this->createMock();

		$object = new Input($mock, 'HELP');
	}
}
