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
	 * Connection with the server
	 *
	 * @var Connection
	 */
	protected $connection;

	public function __construct(Connection $connection)
	{
		$this->connection = $connection;
	}

	/**
	 * Execute command
	 *
	 * @since 2.0
	 */
	abstract public function execute();

	/**
	 * Easily invoke a command
	 *
	 * @param Command $command
	 *
	 * @since 2.0
	 */
	public static function invoke(Command $command)
	{
		$command->execute();
	}
}
