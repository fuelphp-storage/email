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

use Fuel\Email\Transport\Smtp\Command;
use Fuel\Email\Transport\Smtp\Command\Starttls;
use Fuel\Email\Transport\Smtp\Command\Ehlo;
use Fuel\Email\Transport\Smtp\Command\Helo;

/**
 * TLS connection class
 *
 * @package Fuel\Email
 * @author  Fuel Development Team
 *
 * @since 2.0
 *
 * @codeCoverageIgnore
 */
class Tls extends Tcp
{
	public function __construct($hostname, $port, $timeout = 30)
	{
		parent::__construct($hostname, $port, $timeout);

		if ($this->isState(static::ESTABILISHED))
		{
			Command::invoke(new Starttls($this));
			Command::invoke(new Ehlo($this));
			Command::invoke(new Helo($this));
		}
	}
}
