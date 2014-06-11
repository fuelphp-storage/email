<?php
/**
 * @package   Fuel\Email
 * @version   2.0
 * @author    Fuel Development Team
 * @license   MIT License
 * @copyright 2010 - 2014 Fuel Development Team
 * @link      http://fuelphp.com
 */

namespace Fuel\Email\Transport\Smtp\Authentication;

use Fuel\Email\Transport\Smtp\Authentication;
use Fuel\Email\Transport\Smtp\Connection;
use Fuel\Email\Transport\Smtp\Command;
use Fuel\Email\Transport\Smtp\Command\Auth;
use Fuel\Email\Transport\Smtp\Command\Input;

/**
 * LOGIN mechanism authentication
 *
 * @package Fuel\Email
 * @author  Fuel Development Team
 *
 * @since 2.0
 */
class Login extends Authentication
{
	/**
	 * {@inheritdocs}
	 */
	public function authenticate(Connection $connection)
	{
		Command::invoke(new Auth($connection, "LOGIN"));
		Command::invoke(new Input($connection, base64_encode($this->username)));

		if ($connection->read()->getCode() === Authentication::ACCEPTED)
		{
			Command::invoke(new Input($connection, base64_encode($this->password)));

			return $connection->read()->getCode() === Authentication::AUTHENTICATION_PERFORMED;
		}

		return false;
	}
}
