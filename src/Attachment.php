<?php
/**
 * @package   Fuel\Email
 * @version   2.0
 * @author    Fuel Development Team
 * @license   MIT License
 * @copyright 2010 - 2014 Fuel Development Team
 * @link      http://fuelphp.com
 */

namespace Fuel\Email;

/**
 * General attachment implementation
 *
 * @package Fuel\Email
 * @author  Fuel Development Team
 *
 * @since 2.0
 */
class Attachment
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
	 * Returns attachment name
	 *
	 * @return string
	 *
	 * @since 2.0
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * Sets attachment name
	 *
	 * @return this
	 *
	 * @since 2.0
	 */
	public function setName($name)
	{
		$this->name = $name;

		return $this;
	}

	/**
	 * Returns content
	 *
	 * @return string
	 *
	 * @since 2.0
	 */
	public function getContents()
	{
		return $this->contents;
	}

	/**
	 * Sets content
	 *
	 * @param string $contents
	 *
	 * @return this
	 *
	 * @since 2.0
	 */
	public function setContents($contents)
	{
		$this->contents = $contents;

		return $this;
	}

	/**
	 * Returns mime type
	 *
	 * @return string
	 *
	 * @since 2.0
	 */
	public function getMime()
	{
		return $this->mime;
	}

	/**
	 * Sets mime type
	 *
	 * @return this
	 *
	 * @since 2.0
	 */
	public function setMime($mime)
	{
		$this->mime = $mime;

		return $this;
	}

	/**
	 * Checks whether attachment is inline or not
	 *
	 * @return boolean
	 *
	 * @since 2.0
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
	 * @return this
	 *
	 * @since 2.0
	 */
	public function setInline($inline = true)
	{
		$this->inline = (bool) $inline;

		return $this;
	}

	/**
	 * Returns Content ID
	 *
	 * @return string
	 *
	 * @since 2.0
	 */
	public function getCid()
	{
		return $this->cid;
	}

	/**
	 * Sets Content ID
	 *
	 * @param string $cid
	 *
	 * @return this
	 *
	 * @since 2.0
	 */
	public function setCid($cid)
	{
		$this->cid = (string) $cid;

		return $this;
	}
}
