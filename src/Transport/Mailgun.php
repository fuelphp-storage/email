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

use Mailgun\Mailgun as MailgunObject;
use Fuel\Config\Container as Config;
use Fuel\Email\Transport;
use Fuel\Email\Message;

/**
 * Uses Rackspace's Mailgun to send mail
 *
 * @package Fuel\Email
 * @author  Fuel Development Team
 *
 * @since 2.0
 */
class Mailgun extends Transport
{
	/**
	 * Mailgun email configuration defaults
	 *
	 * @var []
	 */
	protected $defaults = [
		'domain' => '',
	];

	/**
	 * Mailgun object
	 *
	 * @var MailgunObject
	 */
	protected $mailgun;

	/**
	 * Creates Mailgun Transport
	 *
	 * @param MailgunObject $mailgun
	 * @param Config        $config
	 *
	 * @since 2.0
	 */
	public function __construct(MailgunObject $mailgun, Config $config)
	{
		$this->mailgun = $mailgun;

		parent::__construct($config);
	}

	/**
	 * {@inheritdocs}
	 */
	protected function configDefaults(Config $config)
	{
		$this->globalDefaults['mailgun'] = $this->defaults;

		parent::configDefaults($config);
	}

	/**
	 * {@inheritdocs}
	 */
	public function send(Message $message)
	{
		return true;
	}

	/**
	 * Returns the Mailgun object
	 *
	 * @return MailgunObject
	 *
	 * @since 2.0
	 */
	public function getMailgun()
	{
		return $this->mailgun;
	}

	/**
	 * Sets the Mailgun object
	 *
	 * @param MailgunObject $mailgun
	 *
	 * @return this
	 *
	 * @since 2.0
	 */
	public function setMailgun(MailgunObject $mailgun)
	{
		$this->mailgun = $mailgun;

		return $this;
	}
}
