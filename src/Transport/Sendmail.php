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

use Fuel\Config\Container as Config;
use Fuel\Email\Transport;
use Fuel\Email\Message;

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
		'path'  => '/usr/sbin/sendmail',
	];

	/**
	 * {@inheritdocs}
	 */
	protected function configDefaults(Config $config)
	{
		$current = $config->get('email.sendmail', array());
		$default = array('email' => array('sendmail' => $this->defaults));

		$config->merge($default, $current);

		parent::configDefaults($config);
	}

	/**
	 * {@inheritdocs}
	 */
	public function send(Message $message)
	{
		return true;
	}
}
