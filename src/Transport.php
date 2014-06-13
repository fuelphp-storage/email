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

/**
 * Defines an abstract class for Transport
 *
 * @package Fuel\Email
 * @author  Fuel Development Team
 *
 * @since 2.0
 */
abstract class Transport implements TransportInterface
{
	/**
	 * Passed configuration array
	 *
	 * @var []
	 */
	protected $config = [];

	/**
	 * Global email configuration defaults
	 *
	 * @var []
	 */
	protected $globalDefaults = [
		'charset'         => 'utf-8',
		'encoding'        => '8bit',
		'encode_headers'  => true,
		'headers'         => array(
			'MIME-Version' => '1.0'
		),
		'html'            => array(
			'attach_paths'    => array(
				'',
			),
			'attach_class'    => 'Fuel\\Email\\Attachment\\File',
			'auto_attach'     => false,
			'generate_alt'    => false,
			'remove_comments' => false,
		),
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
	 * Builds the message itself
	 *
	 * @param  Message $message
	 *
	 * @return array
	 */
	public function buildMessage(Message $message)
	{
		if ($message->isType(Message::HTML))
		{
			$this->processHtml($message);
		}
	}

	/**
	 * Format an address
	 *
	 * @param  Address $address
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

			if ($this->config['encode_headers'])
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
	 * @param  string $header
	 *
	 * @return string
	 *
	 * @since 2.0
	 */
	public function encodeMimeHeader($header)
	{
		$transfer_encoding = 'B';

		if ($this->config['encoding'] === 'quoted-printable')
		{
			$transfer_encoding = 'Q';
		}

		return mb_encode_mimeheader($header, $this->config['charset'], $transfer_encoding, $this->config['newline']);
	}

	/**
	 * Encodes a string in the given encoding
	 *
	 * @param string $string   String to encode
	 * @param string $encoding The charset
	 * @param string $newline  Newline delimeter
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
			$newline = $this->config['newline'];
		}

		switch ($encoding)
		{
			case 'quoted-printable':
				return quoted_printable_encode($string);
			case '7bit':
			case '8bit':
				return $this->prepNewlines(rtrim($string, $newline), $newline);
			case 'base64':
				return chunk_split(base64_encode($string), $this->config['wordwrap'], $newline);
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
			$newline = $this->config['newline'];
		}

		$replace = array(
			"\r\n" => "\n",
			"\n\r" => "\n",
			"\r"   => "\n",
			"\n"   => $newline,
		);

		return str_replace(array_keys($replace), $replace, $string);
	}

	/**
	 * Processes HTML body
	 *
	 * @param  Message $message
	 *
	 * @since 2.0
	 */
	public function processHtml(Message $message)
	{
		$html = $message->getBody();

		// Remove html comments
		if ($this->config['html']['remove_comments'])
		{
			$html = preg_replace('/<!--(.*)-->/', '', $html);
		}

		// Auto attach all images
		// TODO single or double quote
		if ($this->config['html']['auto_attach'])
		{
			preg_match_all("/(src|background)=\"(.*)\"/Ui", $html, $images);

			if (empty($images[2]) === false)
			{
				// TODO Remove dependency
				$finder = new Finder($this->config['html']['attach_paths']);
				$finder->returnHandlers();

				foreach ($images[2] as $i => $imageUrl)
				{
					// Don't attach absolute urls and already inline content
					if (preg_match('/(^http\:\/\/|^https\:\/\/|^cid\:|^data\:|^#)/Ui', $imageUrl) === false)
					{
						$file = $finder->findFile($imageUrl);

						if ($file)
						{
							$attachment = new $this->config['html']['attach_class']($file);
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

		if ($message->hasAltBody() === false and $this->config['html']['generate_alt'])
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
	protected static function generateAlt(Message $message)
	{
		$html = preg_replace('/[ |	]{2,}/m', ' ', $message->getBody());
		$html = trim(strip_tags(preg_replace('/<(head|title|style|script)[^>]*>.*?<\/\\1>/s', '', $html)));
		$lines = explode($newline, $html);
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

		$html = join($this->config['newline'], $result);

		if ($this->config['wordwrap'] > 0)
		{
			$html = wordwrap($html, $this->config['wordwrap'], $this->config['newline'], true);
		}
	}
}
