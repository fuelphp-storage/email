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
use Fuel\Email\Transport\Smtp\Connection\Tls;
use RuntimeException;

/**
 * Tests for Starttls command
 *
 * @package Fuel\Email
 * @author  Fuel Development Team
 *
 * @coversDefaultClass  Fuel\Email\Transport\Smtp\Command\Starttls
 */
class StarttlsTest extends AbstractCommandTest
{
	public function _before()
	{
		$mock = $this->createMock();

		$mock->shouldReceive('read')
			->andReturn(new Response('220'));

		$mock->shouldReceive('getStream')
			->andReturn(tmpfile());

		$this->object = new Starttls($mock);
	}

	/**
	 * @covers            ::execute
	 * @expectedException RuntimeException
	 * @group             Email
	 */
	public function testExecute()
	{
		$this->invoke($this->object);
	}

	/**
	 * @covers ::execute
	 * @covers ::perform
	 * @group  Email
	 */
	public function testPerformFalse()
	{
		$mock = $this->createMock();

		$mock->shouldReceive('write')
			->andReturn(false);

		$object = new Starttls($mock);

		$this->invoke($object);
	}
}
