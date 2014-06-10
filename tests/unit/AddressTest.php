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
		$this->object = new Address('john@doe.com');
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
	 * @covers ::hasName
	 * @group  Email
	 */
	public function testName()
	{
		$name = 'Jane Doe';

		$this->assertSame($this->object, $this->object->setName($name));
		$this->assertEquals($name, $this->object->getName());
		$this->assertTrue($this->object->hasName());
	}

	/**
	 * @covers ::__construct
	 * @group  Email
	 */
	public function testConstruct()
	{
		$email = 'john@doe.com';
		$name = 'John Doe';

		$object = new Address($email, $name);

		$this->assertEquals($email, $object->getEmail());
		$this->assertEquals($name, $object->getName());
	}
}
