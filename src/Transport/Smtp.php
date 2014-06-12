<?php
/**
 * @package   Fuel\Email
 * @version   2.0
 * @author    Fuel Development Team
 * @license   MIT License
 * @copyright 2010 - 2014 Fuel Development Team
 * @link      http://fuelphp.com
 */

namespace Fuel\Email\Transport;

use Fuel\Email\Transport\Smtp\Authentication;
use Fuel\Email\Transport\Smtp\Response;
use Fuel\Email\Transport\Smtp\Command;
use Fuel\Email\Transport;
use Fuel\Email\Message;
use Fuel\Email\Socket\Client;
use Fuel\Common\Arr;
use LogicException;

/**
 * Uses an SMTP server to send mail
 *
 * @package Fuel\Email
 * @author  Fuel Development Team
 *
 * @since 2.0
 */
class Smtp extends Transport
{
	/**
	 * {@inheritdocs}
	 */
	// protected $globalDefaults = [
	// 	'newline' => "\r\n",
	// ];

	/**
	 * SMTP email configuration defaults
	 *
	 * @var []
	 */
	protected $defaults = [
		'host'       => '',
		'port'       => 25,
		'username'   => '',
		'password'   => '',
		'timeout'    => 5,
		'starttls'   => false,
		'pipelining' => false,
	];

	/**
	 * Socket client
	 *
	 * @var Client
	 */
	protected $client;

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

	public function __construct(Client $client, array $config = array())
	{
		$this->client = $client;

		$config['smtp'] = Arr::merge($this->defaults, Arr::get($config, 'smtp', array()));

		// $this->globalDefaults = Arr::merge(parent::$globalDefaults, $this->globalDefaults);

		parent::__construct($config);

		$greeting = $this->read();
		$code = $greeting->getCode();

		if ($code !== 220)
		{
			throw new RuntimeException('Invalid greeting recieved.', $code);
		}

		$this->config['newline'] = "\r\n";

		$this->sayHello();

		if ($this->config['smtp']['starttls'] === true)
		{
			$this->invoke(new Command\Starttls($this));

			$this->sayHello();
		}
	}

	/**
	 * {@inheritdocs}
	 */
	public function send(Message $message)
	{
		return true;
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
		if ($authentication->authenticate($this) === false)
		{
			throw new RuntimeException('Authentication failed.');
		}

		return true;
	}

	/**
	 * Performs EHLO/HELO commands
	 *
	 * @since 2.0
	 */
	public function sayHello()
	{
		$this->invoke(new Command\Ehlo($this));
		$this->invoke(new Command\Helo($this));
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
		while ($this->client->isEof() === false)
		{
			$response = new Response($this->client->read(512, $this->config['newline']));
			$this->responses[] = $response;

			if (substr($response->getResponse(), 3, 1) === chr(0x20))
			{
				$this->lastResponse = $response;

				return $response;
			}
		}
	}

	/**
	 * Write data to Client stream
	 *
	 * @param  string $data
	 *
	 * @return boolean
	 *
	 * @since 2.0
	 */
	public function write($data)
	{
		return $this->client->write($data, $this->config['newline']);
	}

	/**
	 * Returns Client stream
	 *
	 * @return resource
	 */
	public function getStream()
	{
		return $this->client->getStream();
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
	 * Easily invoke a command
	 *
	 * @param Command $command
	 *
	 * @since 2.0
	 */
	public function invoke(Command $command)
	{
		$command->execute();
	}
}
