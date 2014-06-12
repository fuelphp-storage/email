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

/**
 * Defines a common interface for email transport agents
 *
 * @package Fuel\Email
 * @author  Fuel Development Team
 *
 * @since 2.0
 */
interface TransportInterface
{
	/**
	 * The main sending function
	 *
	 * @param  Message $message
	 *
	 * @return boolean Success or failure
	 *
	 * @since 2.0
	 */
	public function send(Message $message);
}
