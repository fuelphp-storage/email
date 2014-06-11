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
 * Dummy command class
 *
 * @package Fuel\Email
 * @author  Fuel Development Team
 *
 * @since 2.0
 */
class DummyCommand extends Command
{
	/**
	 * {@inheritdocs}
	 */
	public function execute() {}
}
