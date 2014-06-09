<?php
/**
 * @package   Fuel\EMail
 * @version   2.0
 * @author    Fuel Development Team
 * @license   MIT License
 * @copyright 2010 - 2014 Fuel Development Team
 * @link      http://fuelphp.com
 */

namespace Fuel\Email\Attachment;

use finfo;
use InvalidArgumentException;

/**
 * File attachment
 *
 * @package Fuel\EMail
 * @author  Fuel Development Team
 *
 * @since 2.0
 */
class File extends Attachment
{
	/**
	 * File path
	 *
	 * @var string
	 */
	protected $file;

	public function __construct($file, $name = null)
	{
		if (is_file($file) === false or ($contents = file_get_contents($file)) === false or empty($contents))
		{
			throw new InvalidArgumentException('The file does not exists, not readable or empty');
		}

		if ($name === null)
		{
			$name = pathinfo($file, PATHINFO_BASENAME);
		}

		$mime = $this->detectMime($file);

		$this->file = realpath($file);

		parent::__construct($name, $contents, $mime);
	}

	/**
	 * Returns file path
	 *
	 * @return string
	 *
	 * @since 2.0
	 */
	public function getFile()
	{
		return $this->file;
	}

	/**
	 * Detect mime type of file
	 *
	 * @param  string $file
	 *
	 * @return string
	 *
	 * @since 2.0
	 */
	protected function detectMime($file)
	{
		static $finfo;

		if ($finfo === null)
		{
			$finfo = new finfo(FILEINFO_MIME_TYPE);
		}

		if (($mime = $finfo->file($file)) === false)
		{
			$mime = 'application/octet-stream';
		}

		return $mime;
	}
}
