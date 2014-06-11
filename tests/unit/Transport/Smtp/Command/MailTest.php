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
 * Tests for MAIL FROM command
 *
 * @package Fuel\Email
 * @author  Fuel Development Team
 *
 * @coversDefaultClass  Fuel\Email\Transport\Smtp\Command\Mail
 */
class MailTest extends AbstractCommandTest
{
	public function _before()
	{
		$mock = $this->createMock();

		$mock->shouldReceive('read')
			->andReturn(new Response('250'));

		$this->object = new Mail($mock, 'john@doe.com');
	}

	/**
	 * @covers ::getCommand
	 * @group  Email
	 */
	public function testExecute()
	{
		$this->invoke($this->object);
	}

	/**
	 * @covers ::__construct
	 * @group  Email
	 */
	public function testConstruct()
	{
		$mock = $this->createMock();

		$object = new Mail($mock, 'john@doe.com');
	}
}
