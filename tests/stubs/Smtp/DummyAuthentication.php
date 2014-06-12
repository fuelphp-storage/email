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
 * Dummy authentication class
 *
 * @package Fuel\Email
 * @author  Fuel Development Team
 *
 * @since 2.0
 */
class DummyAuthentication extends Authentication
{
	public $return = true;

	/**
	 * {@inheritdocs}
	 */
	public function authenticate(Smtp $smtp)
	{
		return $this->return;
	}
}
