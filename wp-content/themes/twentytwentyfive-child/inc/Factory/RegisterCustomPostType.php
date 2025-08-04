<?php

namespace TwentyTwentyFiveChild\Factory;

class RegisterCustomPostType {

	/**
	 * The post type slug.
	 *
	 * @var string
	 */
	private $post_type;

	/**
	 * Arguments for post type registration.
	 *
	 * @var array
	 */
	private $args;

	/**
	 * Constructor.
	 *
	 * @param string $post_type The post type slug.
	 * @param array  $args      Arguments for post type registration.
	 */
	public function __construct( $post_type, $args ) {
		$this->post_type = $post_type;
		$this->args      = $args;
	}

	/**
	 * Register the custom post type.
	 */
	public function register_post_type() {
		$labels = array(
			'name'               => $this->args['plural'],
			'singular_name'      => $this->args['singular'],
			'add_new'            => sprintf( __( 'Add New %s', 'twentytwentyfive-child' ), $this->args['singular'] ),
			'add_new_item'       => sprintf( __( 'Add New %s', 'twentytwentyfive-child' ), $this->args['singular'] ),
			'edit_item'          => sprintf( __( 'Edit %s', 'twentytwentyfive-child' ), $this->args['singular'] ),
			'new_item'           => sprintf( __( 'New %s', 'twentytwentyfive-child' ), $this->args['singular'] ),
			'view_item'          => sprintf( __( 'View %s', 'twentytwentyfive-child' ), $this->args['singular'] ),
			'search_items'       => sprintf( __( 'Search %s', 'twentytwentyfive-child' ), $this->args['plural'] ),
			'not_found'          => sprintf( __( 'No %s found', 'twentytwentyfive-child' ), strtolower( $this->args['plural'] ) ),
			'not_found_in_trash' => sprintf( __( 'No %s found in Trash', 'twentytwentyfive-child' ), strtolower( $this->args['plural'] ) ),
		);

		$defaults = array(
			'labels'       => $labels,
			'public'       => true,
			'has_archive'  => true,
			'show_in_rest' => true,
			'supports'     => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
			'menu_icon'    => 'dashicons-admin-post',
		);

		$args = wp_parse_args( $this->args, $defaults );
		register_post_type( $this->post_type, $args );
	}
}
