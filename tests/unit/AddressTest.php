<?php
/**
 * @package   Fuel\Email
 * @version   2.0
 * @author    Fuel Development Team
 * @license   MIT License
 * @copyright 2010 - 2014 Fuel Development Team
 * @link      http://fuelphp.com
 */

namespace Fuel\Email;

use Codeception\TestCase\Test;

/**
 * Tests for Address
 *
 * @package Fuel\Email
 * @author  Fuel Development Team
 *
 * @coversDefaultClass Fuel\Email\Address
 */
class AddressTest extends Test
{
	/**
	 * @var Fuel\Email\Address
	 */
	protected $object;

	public function _before()
	{
		$this->object = new Address('john@doe.com', 'John Doe');
	}

	/**
	 * @covers ::getEmail
	 * @covers ::setEmail
	 * @group  Email
	 */
	public function testEmail()
	{
		$email = 'jane@doe.com';

		$this->assertSame($this->object, $this->object->setEmail($email));

		$this->assertEquals($email, $this->object->getEmail());
	}

	/**
	 * @covers            ::setEmail
	 * @expectedException InvalidArgumentException
	 * @group             Email
	 */
	public function testBadEmail()
	{
		$this->object->setEmail('SOMETHING BAD');
	}

	/**
	 * @covers ::getName
	 * @covers ::setName
	 * @group  Email
	 */
	public function testName()
	{
		$name = 'Jane Doe';

		$this->assertSame($this->object, $this->object->setName($name));

		$this->assertEquals($name, $this->object->getName());
	}

	/**
	 * @covers ::__tostring
	 * @group  Email
	 */
	public function testString()
	{
		$this->assertEquals('"John Doe" <john@doe.com>', (string) $this->object);

		$this->object->setName(null);

		$this->assertEquals('john@doe.com', (string) $this->object);
	}
}
