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

use Fuel\Email\Transport;
use Fuel\Email\Message;
use Psr\Log\LoggerInterface;

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
	public function __construct(LoggerInterface $logger)
	{
		$this->setLogger($logger);
	}

	/**
	 * {@inheritdocs}
	 */
	public function send(Message $message)
	{
		return true;
	}
}
