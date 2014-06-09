<?php
/**
 * @package   Fuel\Email
 * @version   2.0
 * @author    Fuel Development Team
 * @license   MIT License
 * @copyright 2010 - 2013 Fuel Development Team
 * @link      http://fuelphp.com
 */

namespace Fuel\Email;

/**
 * Defines a common interface for message attachments
 *
 * @package Fuel\Email
 * @author  Fuel Development Team
 *
 * @since 2.0
 */
interface AttachmentInterface
{
	/**
	 * Gets attachment name
	 *
	 * @return string
	 *
	 * @since 2.0
	 */
	public function getName();

	/**
	 * Sets attachment name
	 *
	 * @return AttachmentInterface
	 *
	 * @since 2.0
	 */
	public function setName($name);

	/**
	 * Gets content
	 *
	 * @return string
	 *
	 * @since 2.0
	 */
	public function getContents();

	/**
	 * Sets content
	 *
	 * @param string $contents
	 *
	 * @return AttachmentInterface
	 *
	 * @since 2.0
	 */
	public function setContents($contents);

	/**
	 * Gets mime type
	 *
	 * @return string
	 *
	 * @since 2.0
	 */
	public function getMime();

	/**
	 * Sets mime type
	 *
	 * @return AttachmentInterface
	 *
	 * @since 2.0
	 */
	public function setMime($mime);

	/**
	 * Checks whether attachment is inline or not
	 *
	 * @return boolean
	 *
	 * @since 2.0
	 */
	public function isInline();

	/**
	 * Returns Content ID
	 *
	 * @return string
	 *
	 * @since 2.0
	 */
	public function getCid();

	/**
	 * Sets Content ID
	 *
	 * @param string $cid
	 *
	 * @return AttachmentInterface
	 *
	 * @since 2.0
	 */
	public function setCid($cid);
}
