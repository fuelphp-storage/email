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
 * @coversDefaultClass Fuel\Email\Attachment\Attachment
 */
class AttachmentTest extends AbstractAttachmentTest
{
	public function _before()
	{
		$this->object = new Attachment('attachment', 'Test contents');
	}

	/**
	 * @covers ::getName
	 * @covers ::setName
	 * @group  Email
	 */
	public function testName()
	{
		$name = 'new_name';

		$this->assertSame($this->object, $this->object->setName($name));
		$this->assertSame($name, $this->object->getName());
	}

	/**
	 * @covers ::getContents
	 * @covers ::setContents
	 * @group  Email
	 */
	public function testContents()
	{
		$contents = 'Test';

		$this->assertSame($this->object, $this->object->setContents($contents));
		$this->assertSame($contents, $this->object->getContents());
	}

	/**
	 * @covers ::getMime
	 * @covers ::setMime
	 * @group  Email
	 */
	public function testMime()
	{
		$mime = 'text/html';

		$this->assertSame($this->object, $this->object->setMime($mime));
		$this->assertSame($mime, $this->object->getMime());
	}

	/**
	 * @covers ::getCid
	 * @covers ::setCid
	 * @group  Email
	 */
	public function testCid()
	{
		$cid = md5('cid');

		$this->assertSame(md5($this->object->getName()), $this->object->getCid());
		$this->assertSame($this->object, $this->object->setCid($cid));
		$this->assertSame($cid, $this->object->getCid());
	}

	/**
	 * @covers ::isInline
	 * @covers ::setInline
	 * @group  Email
	 */
	public function testInline()
	{
		$this->assertSame($this->object, $this->object->setInline());
		$this->assertTrue($this->object->isInline());
	}

	/**
	 * @covers ::__construct
	 * @group  Email
	 */
	public function testContstruct()
	{
		$name = 'name';
		$contents = 'Test content';
		$mime = 'text/plain';

		$object = new Attachment($name, $contents, $mime);

		$this->assertEquals($name, $object->getName());
		$this->assertEquals($contents, $object->getContents());
		$this->assertEquals($mime, $object->getMime());
		$this->assertEquals(md5($name), $object->getCid());
		$this->assertFalse($object->isInline());
	}
}
