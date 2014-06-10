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

use InvalidArgumentException;

/**
 * Defines a common class for addresses
 *
 * @package Fuel\Email
 * @author  Fuel Development Team
 *
 * @since 2.0
 */
class Address
{
	/**
	 * Email address
	 *
	 * @var string
	 */
	protected $email;

	/**
	 * Name
	 *
	 * @var string
	 */
	protected $name;

	public function __construct($email, $name = null)
	{
		$this->setEmail($email);
		$this->name = $name;
	}

	/**
	 * Gets the email address
	 *
	 * @return string
	 *
	 * @since 2.0
	 */
	public function getEmail()
	{
		return $this->email;
	}

	/**
	 * Sets the email address
	 *
	 * @param string $email
	 *
	 * @return Address
	 *
	 * @throws InvalidArgumentException If $email is not a valid email address.
	 *
	 * @since 2.0
	 */
	public function setEmail($email)
	{
		if (filter_var($email, FILTER_VALIDATE_EMAIL) === false)
		{
			throw new InvalidArgumentException('EMA-001: This is not a valid email address. ['.$email.']');
		}

		$this->email = $email;

		return $this;
	}

	/**
	 * Gets the name
	 *
	 * @return string
	 *
	 * @since 2.0
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * Sets the name
	 *
	 * @return string
	 *
	 * @since 2.0
	 */
	public function setName($name)
	{
		$this->name = $name;

		return $this;
	}

	/**
	 * Check whether a name is set
	 *
	 * @return boolean
	 *
	 * @since 2.0
	 */
	public function hasName()
	{
		return isset($this->name);
	}

	/**
	 * Returns email
	 *
	 * @return string
	 *
	 * @since 2.0
	 */
	public function __tostring()
	{
		return $this->getEmail();
	}
}
