<?php
/**
 * Post AJAX functionality for loading latest posts via REST API.
 *
 * @package TwentyTwentyFiveChild
 */

namespace TwentyTwentyFiveChild\WP;

use TwentyTwentyFiveChild\Interfaces\InstanceInterface;
use TwentyTwentyFiveChild\Interfaces\HooksInterface;
use TwentyTwentyFiveChild\Traits\Singleton;

/**
 * Handles AJAX functionality for loading latest posts.
 */
class PostAjax implements InstanceInterface, HooksInterface {
	use Singleton;

	private function __construct() {
		$this->action_hooks();
		$this->filter_hooks();
	}

	/**
	 * Register action hooks.
	 */
	public function action_hooks() {
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_ajax_script' ) );
	}

	/**
	 * Register filter hooks.
	 */
	public function filter_hooks() {}

	/**
	 * Enqueue AJAX script data for current post.
	 */
	public function enqueue_ajax_script() {
		if ( is_singular() ) {
			wp_localize_script(
				'twentytwentyfive-child-scripts',
				'ajaxData',
				array(
					'current_post_id' => get_the_ID(),
				)
			);
		}
	}

	/**
	 * Format post data for API response.
	 *
	 * @param WP_Post $post  Post object.
	 * @param array   $terms Optional. Taxonomy terms. Default empty array.
	 * @return array Formatted post data.
	 */
	private static function format_post_data( $post, $terms = array() ) {
		return array(
			'id'        => $post->ID,
			'title'     => get_the_title( $post->ID ),
			'excerpt'   => get_the_excerpt( $post->ID ),
			'permalink' => get_permalink( $post->ID ),
			'date'      => get_the_date( 'F j, Y', $post->ID ),
			'terms'     => $terms,
		);
	}

	/**
	 * Get latest posts with optimized taxonomy loading.
	 *
	 * @param string $post_type  Post type. Default 'post'.
	 * @param int    $exclude_id Post ID to exclude. Default 0.
	 * @param int    $per_page   Number of posts. Default 20.
	 * @param string $taxonomy   Taxonomy to include. Default empty.
	 * @return array Formatted posts data.
	 */
	public static function get_latest_posts( $post_type = 'post', $exclude_id = 0, $per_page = 20, $taxonomy = '' ) {
		$args = array(
			'post_type'      => $post_type,
			'posts_per_page' => $per_page,
			'post_status'    => 'publish',
			'orderby'        => 'date',
			'order'          => 'DESC',
		);

		if ( $exclude_id ) {
			$args['post__not_in'] = array( $exclude_id );
		}

		$posts           = get_posts( $args );
		$formatted_posts = array();

		if ( $taxonomy && taxonomy_exists( $taxonomy ) ) {
			$post_ids  = wp_list_pluck( $posts, 'ID' );
			$all_terms = wp_get_object_terms( $post_ids, $taxonomy, array( 'fields' => 'all_with_object_id' ) );

			$terms_by_post = array();
			foreach ( $all_terms as $term ) {
				if ( ! isset( $terms_by_post[ $term->object_id ] ) ) {
					$terms_by_post[ $term->object_id ] = array();
				}
				$terms_by_post[ $term->object_id ][] = array(
					'name' => $term->name,
					'slug' => $term->slug,
					'link' => get_term_link( $term ),
				);
			}

			foreach ( $posts as $post ) {
				$post_terms        = isset( $terms_by_post[ $post->ID ] ) ? $terms_by_post[ $post->ID ] : array();
				$formatted_posts[] = self::format_post_data( $post, $post_terms );
			}
		} else {
			foreach ( $posts as $post ) {
				$formatted_posts[] = self::format_post_data( $post );
			}
		}

		return $formatted_posts;
	}
}
