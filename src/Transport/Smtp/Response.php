<?php
/**
 * @package   Fuel\Email
 * @version   2.0
 * @author    Fuel Development Team
 * @license   MIT License
 * @copyright 2010 - 2014 Fuel Development Team
 * @link      http://fuelphp.com
 */

namespace Fuel\Email\Transport\Smtp;

/**
 * Handles response from SMTP server
 *
 * @package Fuel\Email
 * @author  Fuel Development Team
 *
 * @since 2.0
 */
class Response
{
	/**
	 * Recieved response
	 *
	 * @var string
	 */
	protected $response;

	public function __construct($response)
	{
		$this->response = $response;
	}

	/**
	 * Returns the full response
	 *
	 * @return string
	 *
	 * @since 2.0
	 */
	public function getResponse()
	{
		return $this->response;
	}

	/**
	 * Returns the response code
	 *
	 * @return integer
	 *
	 * @since 2.0
	 */
	public function getCode()
	{
		$code = 0;
		$codeStr = substr($this->getResponse(), 0, 3);

		if (is_numeric($codeStr))
		{
			$code = (int) $codeStr;
		}

		return $code;
	}

	/**
	 * Returns the response message
	 *
	 * @return string
	 *
	 * @since 2.0
	 */
	public function getMessage()
	{
		$code = $this->getCode();
		$response = $this->getResponse();

		if ($code === 0)
		{
			return $response;
		}

		return substr($this->getResponse(), 4);
	}

	/**
	 * Returns the response
	 *
	 * @return string
	 *
	 * @since 2.0
	 */
	public function __tostring()
	{
		return $this->getResponse();
	}
}
