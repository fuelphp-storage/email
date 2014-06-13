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
	 * Mail types
	 */
	const PLAIN = 'plain';
	const HTML  = 'html';

	/**
	 * Email priorities
	 */
	const HIGHEST = 1;
	const HIGH    = 2;
	const NORMAL  = 3;
	const LOW     = 4;
	const LOWEST  = 5;

	/**
	 * Email priorities
	 *
	 * @var []
	 */
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
	 * Mail body
	 *
	 * @var string
	 */
	protected $body;

	/**
	 * Mail alternative body
	 *
	 * @var string
	 */
	protected $altBody;

	/**
	 * Attachments
	 *
	 * @var Attachment[]
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
	 * Type of mail
	 *
	 * Can be one of type constants
	 *
	 * @var string
	 */
	protected $type = 'plain';

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
	 * @return this
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
	 * @return this
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
	 * Returns the list of recipients of one type
	 *
	 * @param string $type
	 *
	 * @return Recipient[]
	 *
	 * @since 2.0
	 */
	public function getRecipientsOfType($type)
	{
		return array_filter($this->recipients, function($recipient) use($type) {
			return $recipient->isType($type);
		});
	}

	/**
	 * Clears the list of recipients
	 *
	 * @return this
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
	 * @return this
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
	 * @return this
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
	 * @return this
	 *
	 * @since 2.0
	 */
	public function setSubject($subject)
	{
		$this->subject = (string) $subject;

		return $this;
	}

	/**
	 * Returns body
	 *
	 * @return string
	 *
	 * @since 2.0
	 */
	public function getBody()
	{
		return $this->body;
	}

	/**
	 * Sets body
	 *
	 * @param string $body
	 *
	 * @return this
	 *
	 * @since 2.0
	 */
	public function setBody($body)
	{
		$this->body = (string) $body;

		return $this;
	}

	/**
	 * Sets HTML body
	 *
	 * @param  string $body
	 *
	 * @return this
	 *
	 * @since 2.0
	 */
	public function htmlBody($body)
	{
		$this->setType(static::HTML);

		return $this->setBody($body);
	}

	/**
	 * Get alternative body
	 *
	 * @return string
	 *
	 * @since 2.0
	 */
	public function getAltBody()
	{
		return $this->altBody;
	}

	/**
	 * Checks whether message has an alternative body
	 *
	 * @return boolean
	 *
	 * @since 2.0
	 */
	public function hasAltBody()
	{
		return empty($this->altBody) === false;
	}

	/**
	 * Sets alternative body
	 *
	 * @param strint $altBody
	 *
	 * @return this
	 *
	 * @since 2.0
	 */
	public function setAltBody($altBody)
	{
		$this->altBody = (string) $altBody;

		return $this;
	}

	/**
	 * Adds an attachment
	 *
	 * @param  Attachment $attachment
	 *
	 * @return this
	 *
	 * @since 2.0
	 */
	public function attach(Attachment $attachment)
	{
		$this->attachments[] = $attachment;

		return $this;
	}

	/**
	 * Returns the list of attachments
	 *
	 * @return Attachment[]
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
	 * @return this
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
	 * @return this
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
	 * @return this
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
	 * @return this
	 *
	 * @since 2.0
	 */
	public function clearHeaders()
	{
		$this->headers = [];

		return $this;
	}

	/**
	 * Returns message type
	 *
	 * @return string
	 *
	 * @since 2.0
	 */
	public function getType()
	{
		return $this->type;
	}

	/**
	 * Checks type
	 *
	 * @return boolean
	 *
	 * @since 2.0
	 */
	public function isType($type)
	{
		return $this->type === $type;
	}

	/**
	 * Sets message type
	 *
	 * @param string $type
	 *
	 * @return this
	 *
	 * @since 2.0
	 */
	public function setType($type)
	{
		if (in_array($type, array('plain', 'html')) === false)
		{
			throw new InvalidArgumentException('EMA-005: This is not a valid message type.');
		}

		$this->type = $type;

		return $this;
	}
}
