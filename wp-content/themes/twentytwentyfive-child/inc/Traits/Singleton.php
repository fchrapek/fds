<?php

namespace TwentyTwentyFiveChild\Traits;

trait Singleton {

	/**
	 * Instance of the class.
	 *
	 * @var static
	 */
	private static $instance = null;

	/**
	 * Get the instance of the class.
	 *
	 * @return static
	 */
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Prevent cloning of the instance.
	 */
	private function __clone() {}

	/**
	 * Prevent unserialization of the instance.
	 */
	public function __wakeup() {}
}