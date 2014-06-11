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
use Fuel\Email\Transport\Smtp\Authentication;
use LogicException;
use RuntimeException;

/**
 * AUTH command
 *
 * @package Fuel\Email
 * @author  Fuel Development Team
 *
 * @since 2.0
 */
class Auth extends Command
{
	/**
	 * AUTH mechanism
	 *
	 * @var string
	 */
	protected $mechanism;

	public function __construct(Connection $connection, $mechanism)
	{
		parent::__construct($connection);

		$this->mechanism = $mechanism;
	}

	/**
	 * {@inheritdocs}
	 */
	public function execute()
	{
		if ($this->connection->write('AUTH '.$this->mechanism))
		{
			$response = $this->connection->read();
			$code = $response->getCode();

			if ($code === Authentication::ALREADY_AUTHENTICATED)
			{
				throw new LogicException('No more AUTH commands may be issued in the same session.', $code);
			}

			if ($code !== Authentication::ACCEPTED)
			{
				throw new RuntimeException('Cannot authenticate using this mechanism. ['.$this->mechanism.']', $code);
			}
		}
	}
}
