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
 * Defines a general class for commands
 *
 * @package Fuel\Email
 * @author  Fuel Development Team
 *
 * @since 2.0
 */
abstract class Command
{
	/**
	 * SMTP Transport protocol
	 *
	 * @var Smtp
	 */
	protected $smtp;

	public function __construct(Smtp $smtp)
	{
		$this->smtp = $smtp;
	}

	/**
	 * Execute command
	 *
	 * @since 2.0
	 */
	abstract public function execute();
}
