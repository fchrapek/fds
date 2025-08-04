<?php
/**
 * REST API endpoints for AJAX functionality.
 *
 * @package TwentyTwentyFiveChild
 */

namespace TwentyTwentyFiveChild\WP;

use TwentyTwentyFiveChild\Interfaces\InstanceInterface;
use TwentyTwentyFiveChild\Interfaces\HooksInterface;
use TwentyTwentyFiveChild\Traits\Singleton;

/**
 * REST API controller for AJAX endpoints.
 */
class AjaxEndpoints extends \WP_REST_Controller implements InstanceInterface, HooksInterface {
	use Singleton;

	const ROUTE_NAMESPACE = 'twentytwentyfive-child/v1';
	const ROUTE_BASE      = 'ajax';

	private function __construct() {
		$this->action_hooks();
		$this->filter_hooks();
	}

	/**
	 * Register action hooks.
	 */
	public function action_hooks() {
		add_action( 'rest_api_init', array( $this, 'register_routes' ) );
	}

	/**
	 * Register filter hooks.
	 */
	public function filter_hooks() {}

	/**
	 * Register REST API routes.
	 */
	public function register_routes() {
		register_rest_route(
			self::ROUTE_NAMESPACE,
			'/' . self::ROUTE_BASE . '/load-posts',
			array(
				'methods'             => 'POST',
				'callback'            => array( $this, 'load_posts' ),
				'permission_callback' => '__return_true',
				'args'                => array(
					'post_type'  => array(
						'required'          => false,
						'default'           => 'post',
						'sanitize_callback' => 'sanitize_text_field',
					),
					'exclude_id' => array(
						'required'          => false,
						'default'           => 0,
						'sanitize_callback' => 'absint',
					),
					'per_page'   => array(
						'required'          => false,
						'default'           => 20,
						'sanitize_callback' => 'absint',
					),
					'taxonomy'   => array(
						'required'          => false,
						'default'           => '',
						'sanitize_callback' => 'sanitize_text_field',
					),
				),
			)
		);
	}

	/**
	 * Load posts via REST API endpoint.
	 *
	 * @param WP_REST_Request $request REST request object.
	 * @return WP_REST_Response REST response with posts data.
	 */
	public function load_posts( $request ) {
		$post_type  = $request->get_param( 'post_type' );
		$exclude_id = $request->get_param( 'exclude_id' );
		$per_page   = $request->get_param( 'per_page' );
		$taxonomy   = $request->get_param( 'taxonomy' );

		$posts = PostAjax::get_latest_posts( $post_type, $exclude_id, $per_page, $taxonomy );

		return rest_ensure_response( $posts );
	}
}
