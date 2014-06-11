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

use Fuel\Email\Transport\Smtp\Command;
use Fuel\Email\Transport\Smtp\Connection;

/**
 * Input command
 *
 * @package Fuel\Email
 * @author  Fuel Development Team
 *
 * @since 2.0
 */
class Input extends Command
{
	/**
	 * Command to be performed
	 *
	 * @var string
	 */
	protected $command;

	public function __construct(Connection $connection, $command)
	{
		parent::__construct($connection);

		$this->command = $command;
	}

	/**
	 * {@inheritdocs}
	 */
	public function execute()
	{
		$this->connection->write($this->command);
	}
}
