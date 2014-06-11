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
 * Tests for SSL Connection
 *
 * @package Fuel\Email
 * @author  Fuel Development Team
 *
 * @coversDefaultClass  Fuel\Email\Transport\Smtp\Connection\Ssl
 */
class SslTest extends Test
{
	/**
	 * @covers ::__construct
	 * @group  Email
	 */
	public function testConstruct()
	{
		try
		{
			$ssl = new Ssl('smtp.gmail.com', 465);

			$ssl->isState(Ssl::ESTABILISHED);
		}
		catch (RuntimeException $e)
		{
			$this->markTestSkipped('SSL connection not available.');
		}
	}
}
