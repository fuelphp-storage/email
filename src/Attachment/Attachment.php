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

use Fuel\Email\AttachmentInterface;

/**
 * General attachment implementation
 *
 * @package Fuel\Email
 * @author  Fuel Development Team
 *
 * @since 2.0
 */
class Attachment implements AttachmentInterface
{
	/**
	 * Attachment name
	 *
	 * @var string
	 */
	protected $name;

	/**
	 * Attachment contents
	 *
	 * @var string
	 */
	protected $contents;

	/**
	 * Attachment mime type
	 *
	 * @var string
	 */
	protected $mime;

	/**
	 * Indicates inline attachment
	 *
	 * @var boolean
	 */
	protected $inline = false;

	/**
	 * Content ID
	 *
	 * Used when attaching inline images
	 *
	 * @var string
	 */
	protected $cid;

	public function __construct($name, $contents, $mime = 'application/octet-stream')
	{
		$this->name = $name;
		$this->contents = $contents;
		$this->mime = $mime;
		$this->cid = md5($name);
	}

	/**
	 * {@inheritdocs}
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * {@inheritdocs}
	 */
	public function setName($name)
	{
		$this->name = $name;

		return $this;
	}

	/**
	 * {@inheritdocs}
	 */
	public function getContents()
	{
		return $this->contents;
	}

	/**
	 * {@inheritdocs}
	 */
	public function setContents($contents)
	{
		$this->contents = $contents;

		return $this;
	}

	/**
	 * {@inheritdocs}
	 */
	public function getMime()
	{
		return $this->mime;
	}

	/**
	 * {@inheritdocs}
	 */
	public function setMime($mime)
	{
		$this->mime = $mime;

		return $this;
	}

	/**
	 * {@inheritdocs}
	 */
	public function isInline()
	{
		return $this->inline;
	}

	/**
	 * Sets inline flag
	 *
	 * @param boolean $inline
	 *
	 * @return Attachment
	 *
	 * @since 2.0
	 */
	public function setInline($inline = true)
	{
		$this->inline = (bool) $inline;

		return $this;
	}

	/**
	 * {@inheritdocs}
	 */
	public function getCid()
	{
		return $this->cid;
	}

	/**
	 * {@inheritdocs}
	 */
	public function setCid($cid)
	{
		$this->cid = (string) $cid;

		return $this;
	}
}
