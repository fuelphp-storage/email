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

use Fuel\FileSystem\File as FileObject;
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
	 * File object
	 *
	 * @var FileObject
	 */
	protected $file;

	public function __construct(FileObject $file, $name = null)
	{
		if (($file->exists() and $contents = $file->getContents()) === false or empty($contents))
		{
			throw new InvalidArgumentException('The file does not exists, not readable or empty');
		}

		if ($name === null)
		{
			$name = pathinfo((string) $file, PATHINFO_BASENAME);
		}

		$this->file = $file;

		parent::__construct($name, $contents, $file->getMime());
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
}
