<?php
/**
 * @package   Fuel\Email
 * @version   2.0
 * @author    Fuel Development Team
 * @license   MIT License
 * @copyright 2010 - 2014 Fuel Development Team
 * @link      http://fuelphp.com
 */

namespace Fuel\Email\Transport\Smtp;

use Fuel\Email\Transport\Smtp\Command\Ehlo;
use Fuel\Email\Transport\Smtp\Command\Helo;
use Fuel\Email\Transport\Smtp\Command\Quit;
use Exception;
use LogicException;
use RuntimeException;

/**
 * Defines the general methods for all connection types
 *
 * @package Fuel\Email
 * @author  Fuel Development Team
 *
 * @since 2.0
 */
abstract class Connection
{
	/**
	 * Connection states
	 */
	const CLOSED       = -1;
	const ESTABILISHED = 0;
	const CONNECTED    = 1;

	/**
	 * The end of line of any response
	 */
	const EOL = "\r\n";

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
	 * Current server hostname
	 *
	 * @var string
	 */
	protected $hostname;

	/**
	 * Last recieved response from server
	 *
	 * @var Response
	 */
	protected $lastResponse;

	/**
	 * All response from server
	 *
	 * @var Response[]
	 */
	protected $responses = [];

	/**
	 * Opens connection to a server
	 *
	 * @param  string  $protocol
	 * @param  string  $hostname
	 * @param  integer $port
	 * @param  integer $timeout
	 *
	 * @return boolean
	 *
	 * @since 2.0
	 */
	public function open($protocol, $hostname, $port, $timeout = 30)
	{
		if ($this->isState(static::CLOSED) === false)
		{
			throw new LogicException('There is already an opened connection.');
		}

		if ($timeout <= 0)
		{
			throw new LogicException('Timeout must be greater than zero.');
		}

		$errno = 0;
		$errstr = null;

		$remote = sprintf("%s://%s:%d", $protocol, gethostbyname($hostname), $port);
		$stream = @stream_socket_client($remote, $errno, $errstr, $timeout);

		if ($stream === false)
		{
			throw new RuntimeException('Cannot connect to SMTP server.', $errno, new Exception($errstr, $errno));
		}

		$this->stream = $stream;
		$this->changeState(static::ESTABILISHED);

		$greeting = $this->read();

		if (($code = $greeting->getCode()) !== 220)
		{
			throw new RuntimeException('Invalid greeting recieved.', $code);
		}

		$this->hostname = $hostname;

		Command::invoke(new Ehlo($this));
		Command::invoke(new Helo($this));

		return true;
	}

	/**
	 * Closes the connection with the server
	 *
	 * @return boolean
	 *
	 * @since 2.0
	 */
	public function close()
	{
		if ($this->isState(static::CLOSED) === false)
		{
			Command::invoke(new Quit($this));

			if (fclose($this->stream))
			{
				$this->stream = null;
				$this->changeState(static::CLOSED);
			}
		}
	}

	/**
	 * Authenticates connection
	 *
	 * @param  Authentication $authentication
	 *
	 * @return boolean
	 *
	 * @since 2.0
	 */
	public function authenticate(Authentication $authentication)
	{
		if ($this->isState(static::ESTABILISHED) === false)
		{
			throw new LogicException('Connection must be in ESTABILISHED state in order to authenticate.');
		}

		if ($authentication->authenticate($this) === false)
		{
			throw new RuntimeException('Cannot authenticate.');
		}

		$this->changeState(static::CONNECTED);

		return true;
	}

	/**
	 * Reads a server response
	 *
	 * @return Response
	 *
	 * @since 2.0
	 */
	public function read()
	{
		while (feof($this->stream) === false)
		{
			$info = stream_get_meta_data($this->stream);

			if($info['timed_out'])
			{
				throw new RuntimeException('Connection timed out.');
			}

			$response = new Response(stream_get_line($this->stream, 512, static::EOL));
			$this->responses[] = $response;

			if (substr($response->getResponse(), 3, 1) === chr(0x20))
			{
				$this->lastResponse = $response;

				return $response;
			}
		}
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
	public function write($data)
	{
		return fwrite($this->stream, $data . static::EOL) !== false;
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

	/**
	 * Returns last response from the server
	 *
	 * @return Response
	 *
	 * @since 2.0
	 */
	public function getLastResponse()
	{
		return $this->lastResponse;
	}

	/**
	 * Get all responses
	 *
	 * @return Response[]
	 *
	 * @since 2.0
	 */
	public function getResponses()
	{
		return $this->responses;
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
}
