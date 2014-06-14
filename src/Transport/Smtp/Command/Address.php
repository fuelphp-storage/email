<?php
/**
 * @package   Fuel\Email
 * @version   2.0
 * @author    Fuel Development Team
 * @license   MIT License
 * @copyright 2010 - 2014 Fuel Development Team
 * @link      http://fuelphp.com
 */

namespace Fuel\Email\Transport\Smtp\Command;

use Fuel\Email\Transport\Smtp;

/**
 * MAIL FROM and RCPT TO command
 *
 * @package Fuel\Email
 * @author  Fuel Development Team
 *
 * @since 2.0
 */
abstract class Address extends Simple
{
	protected $code = 250;

	/**
	 * Address
	 *
	 * @var string
	 */
	protected $address;

	public function __construct(Smtp $smtp, $address)
	{
		parent::__construct($smtp);

		$this->address = $address;
	}

	/**
	 * {@inheritdocs}
	 */
	public function getCommand()
	{
		return $this->command . ': ' . $this->address;
	}
}
