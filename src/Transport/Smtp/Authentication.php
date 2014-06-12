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

use Fuel\Email\Transport\Smtp;

/**
 * Defines a general class for authentication
 *
 * @package Fuel\Email
 * @author  Fuel Development Team
 *
 * @since 2.0
 */
abstract class Authentication
{
	/**
	 * Response code that means a authentication was performed successfully
	 */
	const AUTHENTICATION_PERFORMED = 235;

	/**
	 * After an AUTH command has successfully completed,
	 * no more AUTH commands may be issued in the same session.
	 * After a successful AUTH command completes,
	 * a server MUST reject any further AUTH commands with a 503 reply.
	 */
	const ALREADY_AUTHENTICATED = 503;

	/**
	 * When a SMTP server cannot perform authentication with specified mechanism
	 * it would be return a message with response code 504 (Unrecognized authentication type)
	 */
	const UNRECOGNIZED_AUTHENTICATION_TYPE = 504;

	/**
	 * When authentication step was accepted or the provided authentication mechanism was accepted.
	 * The server replies with a response containing code 334, it means the acceptance.
	 */
	const ACCEPTED = 334;

	/**
	 * Username used for authentication
	 *
	 * @var string
	 */
	protected $username;

	/**
	 * Password used for authentication
	 *
	 * @var string
	 */
	protected $password;

	/**
	 * Creates a new authentication
	 *
	 * @param string $username
	 * @param string $password
	 *
	 * @since 2.0
	 */
	public function __construct($username, $password)
	{
		$this->username = $username;
		$this->password = $password;
	}

	/**
	 * Returns the username
	 *
	 * @return string
	 *
	 * @since 2.0
	 */
	public function getUsername()
	{
		return $this->username;
	}

	/**
	 * Sets the username
	 *
	 * @param string $username
	 *
	 * @return this
	 *
	 * @since 2.0
	 */
	public function setUsername($username)
	{
		$this->username = $username;

		return $this;
	}

	/**
	 * Returns the password
	 *
	 * @return string
	 *
	 * @since 2.0
	 */
	public function getPassword()
	{
		return $this->password;
	}

	/**
	 * Sets the password
	 *
	 * @param string $password
	 *
	 * @return this
	 *
	 * @since 2.0
	 */
	public function setPassword($password)
	{
		$this->password = $password;

		return $this;
	}

	/**
	 * Performs authentication on connection
	 *
	 * @param Smtp $smtp
	 *
	 * @return boolean
	 *
	 * @since 2.0
	 */
	abstract public function authenticate(Smtp $smtp);
}
