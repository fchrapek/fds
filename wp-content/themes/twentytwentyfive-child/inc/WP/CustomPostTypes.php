<?php

namespace TwentyTwentyFiveChild\WP;

use TwentyTwentyFiveChild\Interfaces\InstanceInterface;
use TwentyTwentyFiveChild\Interfaces\HooksInterface;
use TwentyTwentyFiveChild\Traits\Singleton;
use TwentyTwentyFiveChild\Factory\RegisterCustomPostType;

class CustomPostTypes implements InstanceInterface, HooksInterface {

	use Singleton;

	/**
	 * Array of post types to register.
	 *
	 * @var array
	 */
	private $post_types = array();

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
		add_action( 'init', array( $this, 'register_post_types' ) );
	}

	/**
	 * Register filter hooks.
	 */
	public function filter_hooks() {}

	/**
	 * Register all custom post types.
	 */
	public function register_post_types() {
		$this->set_post_types();
		foreach ( $this->post_types as $post_type => $args ) {
			$factory = new RegisterCustomPostType( $post_type, $args );
			$factory->register_post_type();
		}
	}

	/**
	 * Set the post types configuration.
	 */
	private function set_post_types() {
		$this->post_types = array(
			'library' => array(
				'singular'     => __( 'Book', 'twentytwentyfive-child' ),
				'plural'       => __( 'Books', 'twentytwentyfive-child' ),
				'supports'     => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
				'menu_icon'    => 'dashicons-book',
				'has_archive'  => true,
				'public'       => true,
				'show_in_rest' => true,
				'rewrite'      => array( 'slug' => 'library' ),
			),
		);
	}
}
