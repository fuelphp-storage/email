<?php
/**
 * @package   Fuel\Email
 * @version   2.0
 * @author    Fuel Development Team
 * @license   MIT License
 * @copyright 2010 - 2014 Fuel Development Team
 * @link      http://fuelphp.com
 */

namespace Fuel\Email\Transport;

use Psr\Log\LoggerInterface;
use Fuel\Config\Container as Config;
use Fuel\Email\Transport;
use Fuel\Email\Message;

/**
 * Only log the message
 *
 * @package Fuel\Email
 * @author  Fuel Development Team
 *
 * @since 2.0
 */
class Noop extends Transport
{
	use \Psr\Log\LoggerAwareTrait;

	/**
	 * Creates NoOp Transport
	 *
	 * @param LoggerInterface $logger
	 *
	 * @since 2.0
	 */
	public function __construct(LoggerInterface $logger, Config $config)
	{
		$this->setLogger($logger);

		parent::__construct($config);
	}

	/**
	 * {@inheritdocs}
	 */
	public function send(Message $message)
	{
		return true;
	}
}
