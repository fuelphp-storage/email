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
 * RCPT TO command
 *
 * @package Fuel\Email
 * @author  Fuel Development Team
 *
 * @since 2.0
 */
class Rcpt extends Simple
{
	protected $command = 'RCPT TO';

	protected $code = 250;

	/**
	 * Recipient
	 *
	 * @var string
	 */
	protected $recipient;

	public function __construct(Smtp $smtp, $recipient)
	{
		parent::__construct($smtp);

		$this->recipient = $recipient;
	}

	/**
	 * {@inheritdocs}
	 */
	protected function getCommand()
	{
		return $this->command . ': ' . $this->recipient;
	}
}
