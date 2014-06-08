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
 * Class for recipient addresses
 *
 * @package Fuel\Email
 * @author  Fuel Development Team
 *
 * @since 2.0
 */
class Recipient extends Address
{
	/**
	 * Type of recipient
	 *
	 * Can be to, cc, bcc
	 *
	 * @var string
	 */
	protected $type;

	public function __construct($type, $email, $name = null)
	{
		if (in_array($type, array('to', 'cc', 'bcc')) === false)
		{
			throw new InvalidArgumentException('EMA-002: This is not a valid Recipient type. ['.$type.']');
		}

		$this->type = $type;

		parent::__construct($email, $name);
	}

	/**
	 * Gets type
	 *
	 * @return string
	 *
	 * @since 2.0
	 */
	public function getType()
	{
		return $this->type;
	}

	/**
	 * Check whether the recipient is one of $type
	 *
	 * @param  string  $type
	 *
	 * @return boolean
	 *
	 * @since 2.0
	 */
	public function isType($type)
	{
		return $this->type === $type;
	}
}
