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
 * Tests for TLS Connection
 *
 * @package Fuel\Email
 * @author  Fuel Development Team
 *
 * @coversDefaultClass  Fuel\Email\Transport\Smtp\Connection\Tls
 */
class TlsTest extends Test
{
	/**
	 * @covers ::__construct
	 * @group  Email
	 */
	public function testConstruct()
	{
		try
		{
			$tls = new Tls('smtp.gmail.com', 587);

			$tls->isState(Tls::ESTABILISHED);
		}
		catch (RuntimeException $e)
		{
			$this->markTestSkipped('TLS connection not available.');
		}
	}
}
