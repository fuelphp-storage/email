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

use Fuel\Email\Transport\Smtp\Connection;

/**
 * MAIL FROM command
 *
 * @package Fuel\Email
 * @author  Fuel Development Team
 *
 * @since 2.0
 */
class Mail extends Simple
{
	protected $command = 'MAIL FROM';

	protected $code = 250;

	/**
	 * From
	 *
	 * @var string
	 */
	protected $from;

	public function __construct(Connection $connection, $from)
	{
		parent::__construct($connection);

		$this->from = $from;
	}

	/**
	 * {@inheritdocs}
	 */
	protected function getCommand()
	{
		return $this->command . ': ' . $this->from;
	}
}
