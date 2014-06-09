<?php
/**
 * @package   Fuel\Email
 * @version   2.0
 * @author    Fuel Development Team
 * @license   MIT License
 * @copyright 2010 - 2014 Fuel Development Team
 * @link      http://fuelphp.com
 */

namespace Fuel\Email\Attachment;

use Codeception\TestCase\Test;

/**
 * Abstract Test case for Attachments
 *
 * @package Fuel\Email
 * @author  Fuel Development Team
 */
abstract class AbstractAttachmentTest extends Test
{
	/**
	 * @var Fuel\Email\AttachmentInterface
	 */
	protected $object;
}
