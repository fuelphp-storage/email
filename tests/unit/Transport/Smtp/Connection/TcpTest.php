<?php
/**
 * @package   Fuel\Email
 * @version   2.0
 * @author    Fuel Development Team
 * @license   MIT License
 * @copyright 2010 - 2014 Fuel Development Team
 * @link      http://fuelphp.com
 */

namespace Fuel\Email\Transport\Smtp\Connection;

use Codeception\TestCase\Test;
use RuntimeException;

/**
 * Tests for TCP Connection
 *
 * @package Fuel\Email
 * @author  Fuel Development Team
 *
 * @coversDefaultClass  Fuel\Email\Transport\Smtp\Connection\Tcp
 */
class TcpTest extends Test
{
	/**
	 * @covers ::__construct
	 * @group  Email
	 */
	public function testConstruct()
	{
		try
		{
			$tcp = new Tcp('smtp.gmail.com', 587);

			$tcp->isState(Tcp::ESTABILISHED);
		}
		catch (RuntimeException $e)
		{
			$this->markTestSkipped('TCP connection not available.');
		}
	}
}
