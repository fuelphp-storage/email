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
use RuntimeException;

/**
 * STARTTLS command
 *
 * @package Fuel\Email
 * @author  Fuel Development Team
 *
 * @since 2.0
 */
class Starttls extends Simple
{
	/**
	 * {@inheritdocs}
	 */
	public function execute()
	{
		if ($this->perform('STARTTLS', 220))
		{
			if (@stream_socket_enable_crypto($this->connection->getStream(), true, STREAM_CRYPTO_METHOD_TLS_CLIENT) === false)
			{
				throw new RuntimeException('Cannot encrypt the connection.');
			}
		}
	}
}
