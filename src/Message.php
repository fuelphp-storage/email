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

use Fuel\Common\Arr;
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
	 * Email priorities
	 */
	const HIGHEST = 1;
	const HIGH    = 2;
	const NORMAL  = 3;
	const LOW     = 4;
	const LOWEST  = 5;

	protected static $priorities = [
		1 => 'HIGHEST',
		2 => 'HIGH',
		3 => 'NORMAL',
		4 => 'LOW',
		5 => 'LOWEST',
	];

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
	 * Mail priority
	 *
	 * @var string
	 */
	protected $priority;

	/**
	 * Custom headers
	 *
	 * @var []
	 */
	protected $headers = [];

	/**
	 * Used to contain any meta information to associate with this message
	 *
	 * @var []
	 */
	protected $metaContainer = [];

	/**
	 * Returns From address
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
	 * Returns Reply-To adresses
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
	 * Returns subject
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
	 * Returns the list of attachments
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
	 * Checks if there are attachments
	 *
	 * @return boolean
	 *
	 * @since 2.0
	 */
	public function hasAttachments()
	{
		return ! empty($this->attachments);
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
	 * Gets the priority
	 *
	 * @return string
	 *
	 * @since 2.0
	 */
	public function getPriority()
	{
		return $this->priority;
	}

	/**
	 * Sets the priority
	 *
	 * @param string $priority One of the priority constants of this class
	 *
	 * @return Message
	 *
	 * @since 2.0
	 */
	public function setPriority($priority = Message::NORMAL)
	{
		$this->priority = $this->getPriorityName($priority);

		return $this;
	}

	/**
	 * Returns a list of priorities
	 *
	 * @return []
	 *
	 * @since 2.0
	 */
	public static function getPriorities()
	{
		return array_flip(static::$priorities);
	}

	/**
	 * Returns priority name
	 *
	 * @param  integer $priority
	 *
	 * @return string
	 *
	 * @since 2.0
	 */
	public static function getPriorityName($priority)
	{
		if (Arr::has(static::$priorities, $priority) === false)
		{
			throw new InvalidArgumentException('EMA-004: This priority is not defined, use one of the following. ['.$priority.', ['.implode(', ', array_keys(static::$priorities)) . ']]');
		}

		return static::$priorities[$priority];
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
	 * Returns the list of custom headers
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

	/**
	 * Returns meta data
	 *
	 * @param  string $key
	 * @param  mixed $default
	 *
	 * @return mixed
	 *
	 * @since 2.0
	 */
	public function getMeta($key, $default = null)
	{
		return Arr::get($this->metaContainer, $key, $default);
	}

	/**
	 * Sets meta data
	 *
	 * @param string $key
	 * @param mixed $value
	 *
	 * @return Message
	 *
	 * @since 2.0
	 */
	public function setMeta($key, $value = null)
	{
		Arr::set($this->metaContainer, $key, $value);

		return $this;
	}

	/**
	 * Returns unique id for the message
	 *
	 * @return string
	 *
	 * @since 2.0
	 */
	public function getId()
	{
		$from = $this->from->getEmail();

		return "<".uniqid('').strstr($from, '@').">";
	}
}
