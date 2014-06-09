<?php
/**
 * @package   Fuel\Email
 * @version   2.0
 * @author    Fuel Development Team
 * @license   MIT License
 * @copyright 2010 - 2014 Fuel Development Team
 * @link      http://fuelphp.com
 */

namespace Fuel\Email\Attachment;

/**
 * Tests for File attachment
 *
 * @package Fuel\Email
 * @author  Fuel Development Team
 *
 * @coversDefaultClass Fuel\Email\Attachment\File
 */
class FileTest extends AbstractAttachmentTest
{
	protected $mock;

	public function _before()
	{
		$this->mock = \Mockery::mock('Fuel\\FileSystem\\File', function($mock) {
			$mock->shouldReceive('exists')
				->andReturn(true)
				->byDefault();

			$mock->shouldReceive('getContents')
				->andReturn('This is a test file');

			$mock->shouldReceive('getMime')
				->andReturn('text/plain');
		});

		$this->object = new File($this->mock);
	}

	/**
	 * @covers ::getFile
	 * @group  Email
	 */
	public function testFile()
	{
		$this->assertEquals($this->mock, $this->object->getFile());
		$this->assertEquals((string) $this->mock, $this->object->getName());
		$this->assertEquals('This is a test file', $this->object->getContents());
		$this->assertEquals('text/plain', $this->object->getMime());
	}

	/**
	 * @covers ::__construct
	 * @group  Email
	 */
	public function testContstruct()
	{
		$object = new File($this->mock, 'name');

		$this->assertEquals('name', $object->getName());
	}

	/**
	 * @covers            ::__construct
	 * @expectedException InvalidArgumentException
	 * @group             Email
	 */
	public function testContstructFailure()
	{
		$this->mock->shouldReceive('exists')
			->andReturn(false);

		new File($this->mock);
	}
}
