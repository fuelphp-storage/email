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
	public function _before()
	{
		$this->object = new File(__DIR__.'/../../_data/dummy.txt');
	}

	/**
	 * @covers ::getFile
	 * @group  Email
	 */
	public function testFile()
	{
		$this->assertEquals(realpath(__DIR__.'/../../_data/dummy.txt'), $this->object->getFile());
		$this->assertEquals('dummy.txt', $this->object->getName());
		$this->assertEquals('This is a test file', $this->object->getContents());
		$this->assertEquals('text/plain', $this->object->getMime());
	}

	/**
	 * @covers ::__construct
	 * @covers ::detectMime
	 * @group  Email
	 */
	public function testContstruct()
	{
		$object = new File(__DIR__.'/../../_data/dummy.txt', 'name');

		$this->assertEquals('name', $object->getName());
	}

	/**
	 * @covers            ::__construct
	 * @expectedException InvalidArgumentException
	 * @group             Email
	 */
	public function testContstructFailure()
	{
		new File('FAKE_FILE');
	}
}
