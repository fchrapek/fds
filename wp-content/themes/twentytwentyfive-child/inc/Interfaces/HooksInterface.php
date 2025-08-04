<?php

namespace TwentyTwentyFiveChild\Interfaces;

interface HooksInterface {

	/**
	 * Register action hooks.
	 */
	public function action_hooks();

	/**
	 * Register filter hooks.
	 */
	public function filter_hooks();
}
