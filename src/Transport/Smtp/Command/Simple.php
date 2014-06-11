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
use LogicException;
use RuntimeException;

/**
 * Simple abstract command
 *
 * @package Fuel\Email
 * @author  Fuel Development Team
 *
 * @since 2.0
 */
abstract class Simple extends Command
{
	/**
	 * Command
	 *
	 * @var string
	 */
	protected $command;

	/**
	 * Code
	 *
	 * @var integer
	 */
	protected $code;

	/**
	 * {@inheritdocs}
	 */
	public function execute()
	{
		$command = $this->getCommand();

		if (empty($command) or empty($this->code))
		{
			throw new LogicException('Command or code is empty.');
		}

		$this->perform($command, $this->code);
	}

	/**
	 * Perform a command and check the response code
	 *
	 * @param  string  $command
	 * @param  integer $code
	 *
	 * @return boolean
	 *
	 * @since 2.0
	 */
	protected function perform($command, $code)
	{
		if ($this->connection->write($command))
		{
			$response = $this->connection->read();
			$respCode = $response->getCode();

			if ($respCode !== $code)
			{
				throw new RuntimeException('Cannot perform command. ['.$command.']', $respCode);
			}

			return true;
		}

		return false;
	}

	/**
	 * Returns the actual command to be performed
	 *
	 * @return string
	 *
	 * @since 2.0
	 */
	protected function getCommand()
	{
		return $this->command;
	}
}
