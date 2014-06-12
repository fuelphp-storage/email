<?php
/**
 * @package   Fuel\Email
 * @version   2.0
 * @author    Fuel Development Team
 * @license   MIT License
 * @copyright 2010 - 2014 Fuel Development Team
 * @link      http://fuelphp.com
 */

namespace Fuel\Email\Transport;

/**
 * Tests for Mailgun transport
 *
 * @package Fuel\Email
 * @author  Fuel Development Team
 *
 * @coversDefaultClass  Fuel\Email\Transport\Mailgun
 */
class MailgunTest extends AbstractTransportTest
{
	public function _before()
	{
		$mock = \Mockery::mock('Mailgun\\Mailgun');

		$this->object = new Mailgun($mock);
	}

	/**
	 * @covers ::getMailgun
	 * @covers ::setMailgun
	 * @group  Email
	 */
	public function testMailgun()
	{
		$mock = \Mockery::mock('Mailgun\\Mailgun');

		$this->assertSame($this->object, $this->object->setMailgun($mock));
		$this->assertSame($mock, $this->object->getMailgun());
	}

	/**
	 * @covers ::__construct
	 * @covers ::getMailgun
	 * @group  Email
	 */
	public function testConstruct()
	{
		$mock = \Mockery::mock('Mailgun\\Mailgun');

		$object = new Mailgun($mock);

		$this->assertSame($mock, $object->getMailgun());
	}
}
