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
 * Tests for SMTP Authentication
 *
 * @package Fuel\Email
 * @author  Fuel Development Team
 *
 * @coversDefaultClass  Fuel\Email\Transport\Smtp\Authentication
 */
class AuthenticationTest extends Test
{
	/**
	 * @var Fuel\Email\Transport\Smtp\Authentication
	 */
	protected $object;

	public function _before()
	{
		$this->object = new DummyAuthentication('username', 'password');
	}

	/**
	 * @covers ::getUsername
	 * @covers ::setUsername
	 * @group  Email
	 */
	public function testUsername()
	{
		$user = 'user';

		$this->assertSame($this->object, $this->object->setUsername($user));

		$this->assertEquals($user, $this->object->getUsername());
	}

	/**
	 * @covers ::getPassword
	 * @covers ::setPassword
	 * @group  Email
	 */
	public function testPassword()
	{
		$pass = 'pass';

		$this->assertSame($this->object, $this->object->setPassword($pass));

		$this->assertEquals($pass, $this->object->getPassword());
	}

	/**
	 * @covers ::authenticate
	 * @group  Email
	 */
	public function testAuthenticate()
	{
		$mock = \Mockery::mock('Fuel\\Email\\Transport\\Smtp');

		$mock->shouldReceive('invoke')
			->andReturnUsing(function($command) {
				$command->execute();
			});

		$this->assertTrue($this->object->authenticate($mock));
	}

	/**
	 * @covers ::__construct
	 * @group  Email
	 */
	public function testConstruct()
	{
		$username = 'username';
		$password = 'password';

		$object = new DummyAuthentication($username, $password);

		$this->assertEquals($username, $this->object->getUsername());
		$this->assertEquals($password, $this->object->getPassword());
	}
}
