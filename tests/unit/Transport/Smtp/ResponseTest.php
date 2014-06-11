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
 * Tests for SMTP Response
 *
 * @package Fuel\Email
 * @author  Fuel Development Team
 *
 * @coversDefaultClass  Fuel\Email\Transport\Smtp\Response
 */
class ResponseTest extends Test
{
	/**
	 * @var Fuel\Email\Transport\Smtp\Response
	 */
	protected $object;

	public function _before()
	{
		$this->object = new Response('123 Test response');
	}

	/**
	 * @covers ::getResponse
	 * @covers ::getCode
	 * @covers ::getMessage
	 * @covers ::__tostring
	 * @group  Email
	 */
	public function testResponse()
	{
		$this->assertEquals('123 Test response', $this->object->getResponse());

		$this->assertEquals('123 Test response', (string) $this->object);

		$this->assertEquals(123, $this->object->getCode());

		$this->assertEquals('Test response', $this->object->getMessage());
	}

	/**
	 * @covers ::__construct
	 * @covers ::getMessage
	 * @group  Email
	 */
	public function testConstruct()
	{
		$response = new Response('123 Test response');

		$this->assertEquals('123 Test response', $response->getResponse());

		$response = new Response('XYZ Test response');

		$this->assertEquals('XYZ Test response', $response->getMessage());
	}
}
