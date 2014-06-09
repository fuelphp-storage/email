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

use InvalidArgumentException;

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
	 * Attachments
	 *
	 * @var AttachmentInterface[]
	 */
	protected $attachments = [];

	/**
	 * Custom headers
	 *
	 * @var []
	 */
	protected $headers = [];

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
	 * Gets the list of recipients
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

	/**
	 * Adds an attachment
	 *
	 * @param  AttachmentInterface $attachment
	 *
	 * @return Message
	 *
	 * @since 2.0
	 */
	public function attach(AttachmentInterface $attachment)
	{
		$this->attachments[] = $attachment;

		return $this;
	}

	/**
	 * Gets the list of attachments
	 *
	 * @return AttachmentInterface[]
	 *
	 * @since 2.0
	 */
	public function getAttachments()
	{
		return $this->attachments;
	}

	/**
	 * Clears the list of attachments
	 *
	 * @return Message
	 *
	 * @since 2.0
	 */
	public function clearAttachments()
	{
		$this->attachments = [];

		return $this;
	}

	/**
	 * Adds a custom header
	 *
	 * @param string|[] $header
	 * @param string    $value
	 *
	 * @return Message
	 *
	 * @since 2.0
	 */
	public function addHeader($header, $value = null)
	{
		if(is_array($header))
		{
			foreach($header as $_header => $_value)
			{
				$this->addHeader($_header, $_value);
			}
		}
		else
		{
			if (empty($value))
			{
				throw new InvalidArgumentException('EMA-003: Header value cannot be empty.');
			}

			$this->headers[$header] = $value;
		}

		return $this;
	}

	/**
	 * Gets the list of custom headers
	 *
	 * @return []
	 *
	 * @since 2.0
	 */
	public function getHeaders()
	{
		return $this->headers;
	}

	/**
	 * Clears the list of custom headers
	 *
	 * @return Message
	 *
	 * @since 2.0
	 */
	public function clearHeaders()
	{
		$this->headers = [];

		return $this;
	}
}
