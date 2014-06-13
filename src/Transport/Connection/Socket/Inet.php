<?php
/**
 * @package   Fuel\Email
 * @version   2.0
 * @author    Fuel Development Team
 * @license   MIT License
 * @copyright 2010 - 2014 Fuel Development Team
 * @link      http://fuelphp.com
 */

namespace Fuel\Email\Transport\Connection\Socket;

use Fuel\Email\Transport\Connection\Socket;

/**
 * Inet socket client
 *
 * @package Fuel\Email
 * @author  Fuel Development Team
 *
 * @since 2.0
 */
class Inet extends Socket
{
	/**
	 * Hostname
	 *
	 * @var string
	 */
	protected $hostname;

	/**
	 * Creates a new inet socket client
	 *
	 * @param string   $protocol
	 * @param string   $hostname
	 * @param integer  $port
	 * @param integer  $timeout
	 * @param integer  $flags
	 * @param resource $context
	 *
	 * @since 2.0
	 */
	public function __construct($protocol, $hostname, $port, $timeout = 30, $flags = STREAM_CLIENT_CONNECT, $context = null)
	{
		$this->hostname = $hostname;

		$remote_socket = sprintf('%s://%s:%d', $protocol, gethostbyname($hostname), $port);

		$this->open($remote_socket, $timeout, $flags, $context);
	}

	/**
	 * Returns the hostname
	 *
	 * @return string
	 *
	 * @since 2.0
	 */
	public function getHostname()
	{
		return $this->hostname;
	}
}
