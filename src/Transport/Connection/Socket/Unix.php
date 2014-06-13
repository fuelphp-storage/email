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
	 * Path
	 *
	 * @var string
	 */
	protected $path;

	/**
	 * Creates a new unix socket client
	 *
	 * @param string   $path
	 * @param string   $protocol
	 * @param integer  $timeout
	 * @param integer  $flags
	 * @param resource $context
	 *
	 * @since 2.0
	 */
	public function __construct($path, $protocol = 'unix', $timeout = 30, $flags = STREAM_CLIENT_CONNECT, $context = null)
	{
		$this->path = $path;

		$remote_socket = sprintf('%s://%s', $protocol, $path);

		$this->open($remote_socket, $timeout, $flags, $context);
	}

	/**
	 * Returns the path
	 *
	 * @return string
	 *
	 * @since 2.0
	 */
	public function getPath()
	{
		return $this->path;
	}
}
