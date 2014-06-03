<?php

namespace Fuel\Email;

use \Codeception\TestCase\Test as TestBase;

/**
 * @coversDefaultClass Fuel\Email\Test
 */
class TestTest extends TestBase
{
		protected $instance;

		public function _before()
		{
				$this->instance = new Test;
		}

		/**
		 * @covers ::returnTrue
		 */
		public function testReturnTrue()
		{
				$this->assertTrue($this->instance->returnTrue());
		}
}
