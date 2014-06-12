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
use Fuel\Email\Transport\Smtp;
use RuntimeException;

/**
 * DATA command
 *
 * @package Fuel\Email
 * @author  Fuel Development Team
 *
 * @since 2.0
 */
class Data extends Command
{
	protected $data;

	public function __construct(Smtp $smtp, $data)
	{
		parent::__construct($smtp);

		if (is_string($data))
		{
			$data = explode($smtp->getConfig('newline'), $data);
		}

		$this->data = $data;
	}

	/**
	 * {@inheritdocs}
	 */
	public function execute()
	{
		if ($this->smtp->write('DATA'))
		{
			$response = $this->smtp->read();
			$code = $response->getCode();

			if ($code !== 354)
			{
				throw new RuntimeException('Cannot perform command. [DATA]', $code);
			}

			foreach ($this->data as $line)
			{
				$line = $this->escapePeriod($line);

				$this->smtp->write($line);
			}

			$this->smtp->write('.');

			$response = $this->smtp->read();
			$code = $response->getCode();

			if ($code !== 250)
			{
				throw new RuntimeException('Cannot send message.', $code);
			}
		}
	}

	/**
	 * Escape line starting period
	 *
	 * @param  string $line
	 *
	 * @return string
	 *
	 * @since 2.0
	 *
	 * @link http://tools.ietf.org/html/rfc5321#section-4.5.2
	 */
	protected function escapePeriod($line)
	{
		if(substr($line, 0, 1) === '.')
		{
			$line = '.'.$line;
		}

		return $line;
	}
}
