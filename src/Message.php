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
 * Handles message data
 *
 * @package Fuel\Email
 * @author  Fuel Development Team
 *
 * @since 2.0
 */
class Message
{
	/**
	 * From address
	 *
	 * @var Address
	 */
	protected $from;

	/**
	 * Recipients
	 *
	 * @var Recipient[]
	 */
	protected $recipients = [];

	/**
	 * Reply-To address
	 *
	 * @var Address[]
	 */
	protected $replyTo = [];

	/**
	 * Mail subject
	 *
	 * @var string
	 */
	protected $subject;

	/**
	 * Gets From address
	 *
	 * @return Address
	 *
	 * @since 2.0
	 */
	public function getFrom()
	{
		return $this->from;
	}

	/**
	 * Sets From address
	 *
	 * @param Address $from
	 *
	 * @return Message
	 *
	 * @since 2.0
	 */
	public function setFrom(Address $from)
	{
		$this->from = $from;

		return $this;
	}

	/**
	 * Adds a recipient
	 *
	 * @param Recipient $recipient
	 *
	 * @return Message
	 *
	 * @since 2.0
	 */
	public function addRecipient(Recipient $recipient)
	{
		$this->recipients[] = $recipient;

		return $this;
	}

	/**
	 * Returns the list of recipients
	 *
	 * @return Recipient[]
	 *
	 * @since 2.0
	 */
	public function getRecipients()
	{
		return $this->recipients;
	}

	/**
	 * Clears the list of recipients
	 *
	 * @return Message
	 *
	 * @since 2.0
	 */
	public function clearRecipients()
	{
		$this->recipients = [];

		return $this;
	}

	/**
	 * Adds Reply-To address
	 *
	 * @param Address $replyTo
	 *
	 * @return Message
	 *
	 * @since 2.0
	 */
	public function addReplyTo(Address $replyTo)
	{
		$this->replyTo[] = $replyTo;

		return $this;
	}

	/**
	 * Gets Reply-To adresses
	 *
	 * @return Address[]
	 *
	 * @since 2.0
	 */
	public function getReplyTo()
	{
		return $this->replyTo;
	}

	/**
	 * Clears Reply-To addresses
	 *
	 * @return Message
	 *
	 * @since 2.0
	 */
	public function clearReplyTo()
	{
		$this->replyTo = [];

		return $this;
	}

	/**
	 * Gets subject
	 *
	 * @return string
	 *
	 * @since 2.0
	 */
	public function getSubject()
	{
		return $this->subject;
	}

	/**
	 * Sets subject
	 *
	 * @param string $subject
	 *
	 * @return Message
	 *
	 * @since 2.0
	 */
	public function setSubject($subject)
	{
		$this->subject = $subject;

		return $this;
	}
}
