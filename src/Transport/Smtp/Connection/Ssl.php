<?php
/**
 * @package   Fuel\Email
 * @version   2.0
 * @author    Fuel Development Team
 * @license   MIT License
 * @copyright 2010 - 2014 Fuel Development Team
 * @link      http://fuelphp.com
 */

namespace Fuel\Email\Transport\Smtp\Connection;

use Fuel\Email\Transport\Smtp\Connection;

/**
 * SSL connection
 *
 * @package Fuel\Email
 * @author  Fuel Development Team
 *
 * @since 2.0
 */
class Ssl extends Connection
{
	public function __construct($hostname, $port, $timeout = 30)
	{
		$this->open('ssl', $hostname, $port, $timeout);
	}
}
