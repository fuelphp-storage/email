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
use Fuel\Email\Transport\Smtp\Command;
use Fuel\Email\Transport\Smtp\Command\Auth;
use Fuel\Email\Transport\Smtp\Command\Input;
use Fuel\Email\Transport\Smtp;

/**
 * PLAIN mechanism authentication
 *
 * @package Fuel\Email
 * @author  Fuel Development Team
 *
 * @since 2.0
 */
class Plain extends Authentication
{
	/**
	 * {@inheritdocs}
	 */
	public function authenticate(Smtp $smtp)
	{
		Command::invoke(new Auth($smtp, "PLAIN"));
		Command::invoke(
			new Input(
				$smtp,
				base64_encode(sprintf("\0%s\0%s", $this->username, $this->password))
			)
		);

		return $smtp->read()->getCode() === Authentication::AUTHENTICATION_PERFORMED;
	}
}
