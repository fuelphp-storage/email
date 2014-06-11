<?php
/**
 * @package   Fuel\Email
 * @version   2.0
 * @author    Fuel Development Team
 * @license   MIT License
 * @copyright 2010 - 2014 Fuel Development Team
 * @link      http://fuelphp.com
 */

namespace Fuel\Email\Transport\Smtp\Authentication;

use Fuel\Email\Transport\Smtp\Authentication;
use Fuel\Email\Transport\Smtp\Response;
use Codeception\TestCase\Test;

/**
 * Tests for LOGIN mechanism
 *
 * @package Fuel\Email
 * @author  Fuel Development Team
 *
 * @coversDefaultClass  Fuel\Email\Transport\Smtp\Authentication\Login
 */
class LoginTest extends Test
{
	/**
	 * @var Fuel\Email\Transport\Smtp\Authentication\Login
	 */
	protected $object;

	public function _before()
	{
		$this->object = new Login('username', 'password');
	}

	/**
	 * @covers ::authenticate
	 * @group  Email
	 */
	public function testAuthenticate()
	{
		$mock = \Mockery::mock('Fuel\\Email\\Transport\\Smtp\\Connection');

		$mock->shouldReceive('write')
			->andReturn(true);

		$mock->shouldReceive('read')
			->andReturn(
				new Response(Authentication::ACCEPTED),
				new Response(Authentication::ACCEPTED),
				new Response(Authentication::AUTHENTICATION_PERFORMED)
			)->byDefault();

		$this->assertTrue($this->object->authenticate($mock));

		$mock->shouldReceive('read')
			->andReturn(
				new Response(Authentication::ACCEPTED),
				new Response(Authentication::AUTHENTICATION_PERFORMED)
			);

		$this->assertFalse($this->object->authenticate($mock));
	}
}
