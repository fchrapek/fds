<?php

namespace TwentyTwentyFiveChild\WP;

use TwentyTwentyFiveChild\Interfaces\InstanceInterface;
use TwentyTwentyFiveChild\Interfaces\HooksInterface;
use TwentyTwentyFiveChild\Traits\Singleton;
use TwentyTwentyFiveChild\Factory\RegisterCustomTaxonomy;

class CustomTaxonomies implements InstanceInterface, HooksInterface {

	use Singleton;

	/**
	 * Array of taxonomies to register.
	 *
	 * @var array
	 */
	private $taxonomies = array();

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
		add_action( 'init', array( $this, 'register_taxonomies' ) );
	}

	/**
	 * Register filter hooks.
	 */
	public function filter_hooks() {}

	/**
	 * Register all custom taxonomies.
	 */
	public function register_taxonomies() {
		$this->set_taxonomies();

		foreach ( $this->taxonomies as $taxonomy => $args ) {
			$factory = new RegisterCustomTaxonomy( $taxonomy, $args );
			$factory->register_taxonomy();
		}
	}

	/**
	 * Set the taxonomies configuration.
	 */
	private function set_taxonomies() {
		$this->taxonomies = array(
			'book-genre' => array(
				'singular'          => __( 'Genre', 'twentytwentyfive-child' ),
				'plural'            => __( 'Genres', 'twentytwentyfive-child' ),
				'post_types'        => array( 'library' ),
				'hierarchical'      => true,
				'public'            => true,
				'show_in_rest'      => true,
				'show_admin_column' => true,
				'rewrite'           => array( 'slug' => 'book-genre' ),
			),
		);
	}
}
