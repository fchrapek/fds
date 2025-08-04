<?php

namespace TwentyTwentyFiveChild\Factory;

class RegisterCustomTaxonomy {

	/**
	 * The taxonomy slug.
	 *
	 * @var string
	 */
	private $taxonomy;

	/**
	 * Arguments for taxonomy registration.
	 *
	 * @var array
	 */
	private $args;

	/**
	 * Constructor.
	 *
	 * @param string $taxonomy The taxonomy slug.
	 * @param array  $args     Arguments for taxonomy registration.
	 */
	public function __construct( $taxonomy, $args ) {
		$this->taxonomy = $taxonomy;
		$this->args     = $args;
	}

	/**
	 * Register the custom taxonomy.
	 */
	public function register_taxonomy() {
		$labels = array(
			'name'          => $this->args['plural'],
			'singular_name' => $this->args['singular'],
			'search_items'  => sprintf( __( 'Search %s', 'twentytwentyfive-child' ), $this->args['plural'] ),
			'all_items'     => sprintf( __( 'All %s', 'twentytwentyfive-child' ), $this->args['plural'] ),
			'edit_item'     => sprintf( __( 'Edit %s', 'twentytwentyfive-child' ), $this->args['singular'] ),
			'update_item'   => sprintf( __( 'Update %s', 'twentytwentyfive-child' ), $this->args['singular'] ),
			'add_new_item'  => sprintf( __( 'Add New %s', 'twentytwentyfive-child' ), $this->args['singular'] ),
			'new_item_name' => sprintf( __( 'New %s Name', 'twentytwentyfive-child' ), $this->args['singular'] ),
		);

		$defaults = array(
			'labels'            => $labels,
			'hierarchical'      => true,
			'public'            => true,
			'show_in_rest'      => true,
			'show_admin_column' => true,
		);

		$args       = wp_parse_args( $this->args, $defaults );
		$post_types = isset( $args['post_types'] ) ? $args['post_types'] : array();
		unset( $args['post_types'], $args['singular'], $args['plural'] );

		register_taxonomy( $this->taxonomy, $post_types, $args );
	}
}
