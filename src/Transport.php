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
		'charset'        => 'utf-8',
		'encoding'       => '8bit',
		'encode_headers' => true,
		'headers'        => array(
			'MIME-Version' => '1.0'
		),
		'newline'        => "\n",
		'useragent'      => 'FuelPHP, PHP 5.4+ Framework',
		'wordwrap'       => 76,
	];

	/**
	 * Creates new Transport
	 *
	 * @param array $config
	 *
	 * @since 2.0
	 */
	public function __construct(array $config = array())
	{
		$config = Arr::merge($this->globalDefaults, $config);
		$this->config = $config;
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
}
