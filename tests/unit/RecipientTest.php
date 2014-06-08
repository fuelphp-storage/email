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
 * Tests for Recipient
 *
 * @package Fuel\Email
 * @author  Fuel Development Team
 *
 * @coversDefaultClass Fuel\Email\Recipient
 */
class RecipientTest extends Test
{
	/**
	 * @var Fuel\Email\Recipient
	 */
	protected $object;

	public function _before()
	{
		$this->object = new Recipient('to', 'john@doe.com', 'John Doe');
	}

	/**
	 * @covers ::getType
	 * @covers ::isType
	 * @group  Email
	 */
	public function testType()
	{
		$this->assertEquals('to', $this->object->getType());

		$this->assertTrue($this->object->isType('to'));
	}

	/**
	 * @covers ::__construct
	 * @group  Email
	 */
	public function testConstruct()
	{
		$type = 'to';
		$email = 'john@doe.com';
		$name = 'John Doe';

		$object = new Recipient($type, $email, $name);

		$this->assertEquals($type, $object->getType());
		$this->assertEquals($email, $object->getEmail());
		$this->assertEquals($name, $object->getName());
	}

	/**
	 * @covers            ::__construct
	 * @expectedException InvalidArgumentException
	 * @group             Email
	 */
	public function testConstructBadType()
	{
		new Recipient('', 'john@doe.com', 'John Doe');
	}
}
