<?php
/**
 * @package   Fuel\Email
 * @version   2.0
 * @author    Fuel Development Team
 * @license   MIT License
 * @copyright 2010 - 2014 Fuel Development Team
 * @link      http://fuelphp.com
 */

namespace Fuel\Email\Transport\Connection;

use Exception;
use LogicException;
use RuntimeException;

/**
 * Defines a general class for socket connection client
 *
 * @package Fuel\Email
 * @author  Fuel Development Team
 *
 * @since 2.0
 */
class Socket
{
	/**
	 * Connection states
	 */
	const CLOSED       = -1;
	const ESTABILISHED = 0;
	const CONNECTED    = 1;

	/**
	 * Current state of connection
	 *
	 * @var integer
	 */
	protected $state = -1;

	/**
	 * Client stream
	 *
	 * @var resource
	 */
	protected $stream;

	/**
	 * Opens a connection
	 *
	 * @param  string   $remote_socket
	 * @param  integer  $timeout
	 * @param  integer  $flags
	 * @param  resource $context
	 *
	 * @return boolean
	 *
	 * @since 2.0
	 */
	public function open($remote_socket, $timeout = 30, $flags = STREAM_CLIENT_CONNECT, $context = null)
	{
		if ($this->isState(static::CLOSED) === false)
		{
			throw new LogicException('Connection is already opened.');
		}

		$errno = 0;
		$errstr = null;

		$stream = @stream_socket_client($remote_socket, $errno, $errstr, $timeout, $flags);

		if ($stream === false)
		{
			throw new RuntimeException(
				'Cannot create connection.',
				$errno,
				new Exception($errstr, $errno)
			);
		}

		$this->stream = $stream;
		$this->changeState(static::ESTABILISHED);

		return true;
	}

	/**
	 * Closes the connection
	 *
	 * @return boolean
	 *
	 * @since 2.0
	 */
	public function close()
	{
		if ($this->isState(static::CLOSED))
		{
			throw new LogicException('A connection can only be closed once.');
		}

		if (fclose($this->stream))
		{
			$this->stream = null;
		}

		$this->changeState(static::CLOSED);

		return true;
	}

	/**
	 * Set timeout on stream
	 *
	 * @param integer  $seconds
	 * @param integer  $microseconds
	 *
	 * @return boolean
	 *
	 * @since 2.0
	 */
	public function setTimeout($seconds, $microseconds = 0)
	{
		return stream_set_timeout($this->stream, $seconds, $microseconds);
	}

	/**
	 * Check whether the stream is timed out
	 *
	 * @return boolean
	 *
	 * @since 2.0
	 */
	public function isTimedOut()
	{
		$info = stream_get_meta_data($this->stream);

		return $info['timed_out'];
	}

	/**
	 * Set stream blocking mode
	 *
	 * @param integer $mode
	 *
	 * @return boolean
	 *
	 * @since 2.0
	 */
	public function setBlocking($mode = 1)
	{
		return stream_set_blocking($this->stream, $mode);
	}

	/**
	 * Check whether stream pointer is at EOF
	 *
	 * @return boolean
	 *
	 * @since 2.0
	 */
	public function isEof()
	{
		return feof($this->stream);
	}

	/**
	 * Reads a line from the socket
	 *
	 * @return string
	 *
	 * @since 2.0
	 */
	public function read($length = 512, $eol = null)
	{
		return stream_get_line($this->stream, $length, $eol);
	}

	/**
	 * Writes data on the server stream
	 *
	 * @param string $data
	 *
	 * @return boolean
	 *
	 * @since 2.0
	 */
	public function write($data, $eol = null)
	{
		return fwrite($this->stream, $data . $eol) !== false;
	}

	/**
	 * Returns the current state
	 *
	 * @return integer
	 *
	 * @since 2.0
	 */
	public function getState()
	{
		return $this->state;
	}

	/**
	 * Check whether connection is in given state
	 *
	 * @param  integer  $state
	 *
	 * @return boolean
	 *
	 * @since 2.0
	 */
	public function isState($state)
	{
		return $this->state === $state;
	}

	/**
	 * Change connection state
	 *
	 * @param  integer $state
	 *
	 * @return this
	 *
	 * @since 2.0
	 */
	protected function changeState($state)
	{
		$this->state = $state;

		return $this;
	}

	/**
	 * Returns the connection stream
	 *
	 * @return resource
	 *
	 * @since 2.0
	 */
	public function getStream()
	{
		return $this->stream;
	}
}
