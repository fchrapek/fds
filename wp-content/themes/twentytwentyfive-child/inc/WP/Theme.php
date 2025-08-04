<?php

namespace TwentyTwentyFiveChild\WP;

use TwentyTwentyFiveChild\Interfaces\InstanceInterface;
use TwentyTwentyFiveChild\Interfaces\HooksInterface;
use TwentyTwentyFiveChild\Traits\Singleton;

class Theme implements InstanceInterface, HooksInterface {

	use Singleton;

	/**
	 * Constructor.
	 */
	private function __construct() {
		$this->action_hooks();
		$this->filter_hooks();
	}

	/**
	 * Register action hooks.
	 */
	public function action_hooks() {
		add_action( 'after_setup_theme', array( $this, 'theme_setup' ) );
	}

	/**
	 * Register filter hooks.
	 */
	public function filter_hooks() {}

	/**
	 * Setup theme features and supports.
	 */
	public function theme_setup() {
		load_child_theme_textdomain( 'twentytwentyfive-child', get_stylesheet_directory() . '/languages' );

		add_theme_support( 'post-thumbnails' );
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			)
		);
		add_theme_support( 'responsive-embeds' );
	}
}
