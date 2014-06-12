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

use Mandrill as MandrillObject;
use Fuel\Email\Transport;
use Fuel\Email\Message;
use Fuel\Common\Arr;

/**
 * Uses MailChimp's Mandrill to send mail
 *
 * @package Fuel\Email
 * @author  Fuel Development Team
 *
 * @since 2.0
 */
class Mandrill extends Transport
{
	/**
	 * Mandrill email configuration defaults
	 *
	 * @var []
	 */
	protected $defaults = [
		'message_options' => array(),
		'send_options' => array(
			'async'   => false,
			'ip_pool' => null,
			'send_at' => null,
		),
	];

	/**
	 * Mandrill object
	 *
	 * @var MandrillObject
	 */
	protected $mandrill;

	/**
	 * Creates Mandrill Transport
	 *
	 * @param MandrillObject $mandrill
	 * @param array          $config
	 *
	 * @since 2.0
	 */
	public function __construct(MandrillObject $mandrill, array $config = array())
	{
		$this->mandrill = $mandrill;

		$config['mandrill'] = Arr::merge($this->defaults, Arr::get($config, 'mandrill', array()));

		parent::__construct($config);
	}

	/**
	 * {@inheritdocs}
	 */
	public function send(Message $message)
	{
		return true;
	}

	/**
	 * Returns the Mandrill object
	 *
	 * @return MandrillObject
	 *
	 * @since 2.0
	 */
	public function getMandrill()
	{
		return $this->mandrill;
	}

	/**
	 * Sets the Mandrill object
	 *
	 * @param MandrillObject $mandrill
	 *
	 * @return this
	 *
	 * @since 2.0
	 */
	public function setMandrill(MandrillObject $mandrill)
	{
		$this->mandrill = $mandrill;

		return $this;
	}
}
