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

use Fuel\Email\Transport\Smtp\Authentication;
use Fuel\Email\Transport\Smtp\Response;

/**
 * Tests for AUTH command
 *
 * @package Fuel\Email
 * @author  Fuel Development Team
 *
 * @coversDefaultClass  Fuel\Email\Transport\Smtp\Command\Auth
 */
class AuthTest extends AbstractCommandTest
{
	public function _before()
	{
		$mock = $this->createMock();

		$mock->shouldReceive('read')
			->andReturn(new Response(Authentication::ACCEPTED));

		$this->object = new Auth($mock, 'PLAIN');
	}

	/**
	 * @covers            ::execute
	 * @covers            ::__construct
	 * @expectedException LogicException
	 * @group             Email
	 */
	public function testAlreadyAuthenticated()
	{
		$mock = $this->createMock();

		$mock->shouldReceive('read')
			->andReturn(new Response(Authentication::ALREADY_AUTHENTICATED));

		$object = new Auth($mock, 'PLAIN');

		$this->invoke($object);
	}

	/**
	 * @covers            ::execute
	 * @covers            ::__construct
	 * @expectedException RuntimeException
	 * @group             Email
	 */
	public function testInvalidMechanism()
	{
		$mock = $this->createMock();

		$mock->shouldReceive('read')
			->andReturn(new Response(Authentication::UNRECOGNIZED_AUTHENTICATION_TYPE));

		$object = new Auth($mock, 'INVALID');

		$this->invoke($object);
	}
}
