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

use Fuel\Email\Message;
use Fuel\Email\Transport;

/**
 * Dummy transport class
 *
 * @package Fuel\Email
 * @author  Fuel Development Team
 *
 * @since 2.0
 */
class DummyTransport extends Transport
{
	/**
	 * {@inheritdocs}
	 */
	public function send(Message $message)
	{
		return true;
	}
}
