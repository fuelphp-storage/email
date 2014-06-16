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

use Fuel\FileSystem\Finder;
use Fuel\Config\Container as Config;
use InvalidArgumentException;
use UnexpectedValueException;

/**
 * Defines an abstract class for Transport
 *
 * @package Fuel\Email
 * @author  Fuel Development Team
 *
 * @since 2.0
 */
abstract class Transport
{
	/**
	 * Passed Config object
	 *
	 * @var Config
	 */
	protected $config;

	/**
	 * Global email configuration defaults
	 *
	 * @var []
	 */
	protected $globalDefaults = [
		'attach'          => [
			'auto'  => false,
			'class' => 'Fuel\\Email\\Attachment\\File',
			'paths' => [],
			'root'  => '',
		],
		'charset'         => 'utf-8',
		'encoding'        => '8bit',
		'encode_headers'  => true,
		'force_mixed'     => false,
		'headers'         => [
			'MIME-Version' => '1.0'
		],
		'html'            => [
			'generate_alt'    => false,
			'remove_comments' => false,
		],
		'newline'         => "\n",
		'useragent'       => 'FuelPHP, PHP 5.4+ Framework',
		'wordwrap'        => 76,
	];

	/**
	 * Creates new Transport
	 *
	 * @param array $config
	 *
	 * @since 2.0
	 */
	public function __construct(Config $config)
	{
		$this->configDefaults($config);

		$this->config = $config;
	}

	/**
	 * Populates Config container with default values
	 *
	 * @param Config $config
	 *
	 * @since 2.0
	 */
	protected function configDefaults(Config $config)
	{
		$current = $config->get('email', array());
		$default = array('email' => $this->globalDefaults);

		$config->merge($default, $current);
	}

	/**
	 * Returns the Config container
	 *
	 * @return mixed
	 *
	 * @since 2.0
	 */
	public function getConfig()
	{
		return $this->config;
	}

	/**
	 * The main sending function
	 *
	 * @param Message $message
	 *
	 * @return boolean Success or failure
	 *
	 * @since 2.0
	 */
	abstract public function send(Message $message);

	/**
	 * Builds the message itself
	 *
	 * @param Message $message
	 *
	 * @return array
	 */
	public function buildMessage(Message $message, $formatHeaders = false)
	{
		$this->checkMessage($message);

		if ($message->isType(Message::HTML))
		{
			$this->processHtml($message);
		}

		$headers = $this->buildHeaders($message);

		if ($formatHeaders)
		{
			$headers = $this->formatHeaders($headers);
		}

		$body = $message->getBody();

		return compact('headers', 'body');
	}

	/**
	 * Checks whether the Message can be sent
	 *
	 * @param Message $message
	 *
	 * @return boolean
	 *
	 * @throws InvalidArgumentException If Message has missing parts
	 *
	 * @since 2.0
	 */
	protected function checkMessage(Message $message)
	{
		if ($message->hasRecipients() === false)
		{
			throw new InvalidArgumentException('Message without recipients cannot be sent.');
		}

		if ($message->getFrom() === null)
		{
			throw new InvalidArgumentException('Message without sender cannot be sent.');
		}

		return true;
	}

	/**
	 * Processes HTML body
	 *
	 * @param Message $message
	 *
	 * @since 2.0
	 */
	public function processHtml(Message $message)
	{
		$html = $message->getBody();

		// Remove html comments
		if ($this->config['email']['html']['remove_comments'])
		{
			$html = preg_replace('/<!--(.*)-->/', '', $html);
		}

		// Auto attach all images
		// TODO single or double quote
		if ($this->config['email']['attach']['auto'])
		{
			preg_match_all("/(src|background)=\"(.*)\"/Ui", $html, $images);

			if (empty($images[2]) === false)
			{
				// TODO Remove dependency
				$finder = new Finder(
					$this->config['email']['attach']['paths'],
					null,
					$this->config['email']['attach']['root']
				);
				$finder->returnHandlers();

				foreach ($images[2] as $i => $imageUrl)
				{
					// Don't attach absolute urls and already inline content
					if (preg_match('/(^http\:\/\/|^https\:\/\/|^cid\:|^data\:|^#)/Ui', $imageUrl) === false)
					{
						$file = $finder->findFile($imageUrl);

						if ($file)
						{
							$attachment = new $this->config['email']['attach']['class']($file);
							$attachment->setInline();
							$message->attach($attachment);

							$cid = $attachment->getCid();
							$html = preg_replace("/".$images[1][$i]."=\"".preg_quote($imageUrl, '/')."\"/Ui", $images[1][$i]."=\"".$cid."\"", $html);
						}
					}
				}
			}
		}

		$message->setBody($html);

		if ($message->hasAltBody() === false and $this->config['email']['html']['generate_alt'])
		{
			$this->generateAlt($message);
		}
	}

	/**
	 * Generates an alt body
	 *
	 * @param Message $message
	 *
	 * @since 2.0
	 */
	protected function generateAlt(Message $message)
	{
		$html = preg_replace('/[ |	]{2,}/m', ' ', $message->getBody());
		$html = trim(strip_tags(preg_replace('/<(head|title|style|script)[^>]*>.*?<\/\\1>/s', '', $html)));
		$lines = explode($this->config['email']['newline'], $html);
		$result = array();
		$firstNewline = true;

		foreach ($lines as $line)
		{
			$line = trim($line);

			if (empty($line) === false or $firstNewline)
			{
				$firstNewline = false;
				$result[] = $line;
			}
			else
			{
				$firstNewline = true;
			}
		}

		$html = join($this->config['email']['newline'], $result);

		if ($this->config['email']['wordwrap'] > 0)
		{
			$html = wordwrap($html, $this->config['email']['wordwrap'], $this->config['email']['newline'], true);
		}

		$message->setAltBody($html);
	}

	/**
	 * Builds headers
	 *
	 * @param Message $message
	 *
	 * @return []
	 *
	 * @since 2.0
	 */
	protected function buildHeaders(Message $message)
	{
		$headers = array_merge(
			$this->config['email']['headers'],
			$message->getHeaders(),
			$this->buildAddresses($message)
		);

		$headers['Date'] = date('r');

		$headers['Message-ID'] = $this->getMessageId($message);

		$headers['X-Priority'] = $this->formatPriority($message);

		$headers['X-Mailer'] = $this->config['email']['useragent'];

		$subject = $message->getSubject();

		if ($this->config['email']['encode_headers'])
		{
			$subject = $this->encodeMimeHeader($subject);
		}

		$headers['Subject'] = $subject;

		// TODO Add boundary
		$headers['Content-Type'] = $this->getContentType($message, '');

		$headers['Content-Transfer-Encoding'] = $this->config['email']['encoding'];

		return $headers;
	}

	/**
	 * Formats headers into string
	 *
	 * @param []  $headers
	 *
	 * @return string
	 *
	 * @since 2.0
	 */
	protected function formatHeaders(array $headers)
	{
		$formatted = '';

		foreach ($headers as $key => $value)
		{
			$formatted .= $key . ': ' . $value . $config['email']['newline'];
		}

		return $formatted;
	}

	/**
	 * Builds address type headers
	 *
	 * @param Message $message
	 *
	 * @return []
	 *
	 * @since 2.0
	 */
	protected function buildAddresses(Message $message)
	{
		$headers = [];

		$headers['From'] = $this->formatAddress($message->getFrom());

		$replyTo = $this->buildAddressList($message->getReplyTo());

		if (empty($replyTo) === false)
		{
			$headers['Reply-To'] = $replyTo;
		}

		return array_merge($headers, $this->buildRecipients($message));
	}

	/**
	 * Builds recipient header array
	 *
	 * @param Message $message
	 *
	 * @return []
	 *
	 * @since 2.0
	 */
	protected function buildRecipients(Message $message)
	{
		$headers = [];

		foreach (array('to', 'cc', 'bcc') as $type)
		{
			$list = $this->buildAddressList($message->getRecipientsOfType($type));
			$header = ucfirst($type);

			// Default recipient headers
			// There should be a general way instead of this
			if ($default = $this->config->get('email.header.'.$header, false))
			{
				$list .= ', ' . $default;
			}

			if (empty($list) === false)
			{
				$headers[$header] = $list;
			}
		}

		return $headers;
	}

	/**
	 * Builds an address list into string
	 *
	 * @param Address[]  $addresses
	 *
	 * @return string
	 *
	 * @since 2.0
	 */
	protected function buildAddressList(array $addresses)
	{
		foreach ($addresses as $key => $address)
		{
			$addresses[$key] = $this->formatAddress($address);
		}

		return join(', ', $addresses);
	}

	/**
	 * Format an address
	 *
	 * @param Address $address
	 *
	 * @return string
	 *
	 * @since 2.0
	 */
	public function formatAddress(Address $address)
	{
		$string = $address->getEmail();

		if ($address->hasName())
		{
			$name = $address->getName();

			if ($this->config['email']['encode_headers'])
			{
				$name = $this->encodeMimeHeader($name);
			}

			$string = '"'.$name.'" <'.$string.'>';
		}

		return $string;
	}

	/**
	 * Encodes MIME header according to the config
	 *
	 * @param string $header
	 *
	 * @return string
	 *
	 * @since 2.0
	 */
	public function encodeMimeHeader($header)
	{
		$transfer_encoding = 'B';

		if ($this->config['email']['encoding'] === 'quoted-printable')
		{
			$transfer_encoding = 'Q';
		}

		return mb_encode_mimeheader($header, $this->config['email']['charset'], $transfer_encoding, $this->config['email']['newline']);
	}

	/**
	 * Returns unique id for the message
	 *
	 * @param Message $message
	 *
	 * @return string
	 *
	 * @since 2.0
	 */
	public function getMessageId(Message $message)
	{
		$from = $message->getFrom()->getEmail();

		return "<".uniqid('').strstr($from, '@').">";
	}

	/**
	 * Formats priority to string
	 *
	 * @param Message $message
	 *
	 * @return string
	 *
	 * @since 2.0
	 */
	protected function formatPriority(Message $message)
	{
		$priority = $message->getPriority();

		return '(' . $priority . ' ' . ucfirst(strtolower($message->getPriorityName($priority))) . ')';
	}

	/**
	 * Returns Content-Type
	 *
	 * @param Message $message
	 * @param string  $boundary
	 *
	 * @return string
	 *
	 * @since 2.0
	 */
	protected function getContentType(Message $message, $boundary)
	{
		$hasAttachments = $hasAttachment = $message->hasAttachments();
		$hasAlt = $message->hasAltBody();
		$isPlain = $message->isType(Message::PLAIN);

		if ($hasInline = $message->hasInlineAttachments())
		{
			$hasAttachment = $message->getAttachments() === $message->getInlineAttachments();
		}

		$related = 'multipart/related; ';

		if ($this->config['email']['force_mixed'])
		{
			$related = 'multipart/mixed; ';
		}

		if ($isPlain)
		{
			if ($hasAttachments)
			{
				return $related . $boundary;
			}

			return 'text/plain; charset="'.$this->config['email']['charset'].'"';
		}
		elseif (($hasAlt or $hasInline) and $hasAttachment === false)
		{
			return 'multipart/alternative; ' . $boundary;
		}
		elseif ($hasAlt and $hasAttachments)
		{
			return 'multipart/mixed; ' . $boundary;
		}

		return 'text/html; charset="'.$this->config['email']['charset'].'"';
	}

	/**
	 * Encodes a string in the given encoding
	 *
	 * @param string $string
	 * @param string $encoding
	 * @param string $newline
	 *
	 * @throws InvalidArgumentException If encoding is not a supported
	 *
	 * @return string
	 *
	 * @since 2.0
	 */
	public function encodeString($string, $encoding, $newline = null)
	{
		if ($newline === null)
		{
			$newline = $this->config['email']['newline'];
		}

		switch ($encoding)
		{
			case 'quoted-printable':
				return quoted_printable_encode($string);
			case '7bit':
			case '8bit':
				return $this->prepNewlines(rtrim($string, $newline), $newline);
			case 'base64':
				return chunk_split(base64_encode($string), $this->config['email']['wordwrap'], $newline);
			default:
				throw new InvalidArgumentException('This is not a supported encoding method. ['.$encoding.']');
		}
	}

	/**
	 * Standardize newlines
	 *
	 * @param string $string  String to prep
	 * @param string $newline Newline delimiter
	 *
	 * @return string
	 *
	 * @since 2.0
	 */
	protected static function prepNewlines($string, $newline = null)
	{
		if ($newline === null)
		{
			$newline = $this->config['email']['newline'];
		}

		$replace = array(
			"\r\n" => "\n",
			"\n\r" => "\n",
			"\r"   => "\n",
			"\n"   => $newline,
		);

		return str_replace(array_keys($replace), $replace, $string);
	}
}
