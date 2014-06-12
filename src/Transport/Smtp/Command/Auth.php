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
use Fuel\Email\Transport\Smtp\Authentication;
use Fuel\Email\Transport\Smtp;
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

	public function __construct(Smtp $smtp, $mechanism)
	{
		parent::__construct($smtp);

		$this->mechanism = $mechanism;
	}

	/**
	 * {@inheritdocs}
	 */
	public function execute()
	{
		if ($this->smtp->write('AUTH '.$this->mechanism))
		{
			$response = $this->smtp->read();
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
