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
use Fuel\Common\Arr;

/**
 * Uses Sendmail to send mail
 *
 * @package Fuel\Email
 * @author  Fuel Development Team
 *
 * @since 2.0
 */
class Sendmail extends Transport
{
	/**
	 * Sendmail email configuration defaults
	 *
	 * @var []
	 */
	protected $defaults = [
		'path'        => '/usr/sbin/sendmail',
		'return_path' => '',
	];

	/**
	 * Creates Sendmail Transport
	 *
	 * @param array $config
	 *
	 * @since 2.0
	 */
	public function __construct(array $config = array())
	{
		$config['sendmail'] = Arr::merge($this->defaults, Arr::get($config, 'sendmail', array()));

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
