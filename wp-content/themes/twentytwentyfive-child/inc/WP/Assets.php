<?php

namespace TwentyTwentyFiveChild\WP;

use TwentyTwentyFiveChild\Interfaces\InstanceInterface;
use TwentyTwentyFiveChild\Interfaces\HooksInterface;
use TwentyTwentyFiveChild\Traits\Singleton;

class Assets implements InstanceInterface, HooksInterface {

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
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_parent_styles' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_vite_assets' ) );
	}

	/**
	 * Register filter hooks.
	 */
	public function filter_hooks() {
		add_filter( 'script_loader_tag', array( $this, 'add_module_to_vite_scripts' ), 10, 3 );
	}

	/**
	 * Enqueue parent theme styles.
	 */
	public function enqueue_parent_styles() {
		$parent_theme = wp_get_theme( 'twentytwentyfive' );
		wp_enqueue_style(
			'twentytwentyfive-style',
			get_template_directory_uri() . '/style.css',
			array(),
			$parent_theme->get( 'Version' )
		);
	}

	/**
	 * Enqueue Vite assets based on environment.
	 */
	public function enqueue_vite_assets() {
		if ( $this->is_vite_dev_running() ) {
			$this->enqueue_dev_assets();
		} else {
			$this->enqueue_production_assets();
		}
	}

	/**
	 * Check if Vite dev server is running.
	 *
	 * @return bool
	 */
	private function is_vite_dev_running() {
		$context = stream_context_create(
			array(
				'http' => array(
					'timeout'       => 1,
					'ignore_errors' => true,
				),
			)
		);
		return false !== @file_get_contents( 'http://localhost:3000', false, $context );
	}



	/**
	 * Enqueue development assets.
	 */
	private function enqueue_dev_assets() {
		wp_enqueue_script(
			'vite-client',
			'http://localhost:3000/@vite/client',
			array(),
			null,
			false
		);

		wp_enqueue_script(
			'twentytwentyfive-child-scripts',
			'http://localhost:3000/assets/js/scripts.js',
			array( 'vite-client' ),
			null,
			true
		);
		wp_script_add_data( 'twentytwentyfive-child-scripts', 'type', 'module' );

		wp_enqueue_style(
			'child-styles',
			'http://localhost:3000/assets/scss/styles.scss',
			array( 'twentytwentyfive-style' ),
			null
		);
	}

	/**
	 * Enqueue production assets from Vite manifest.
	 */
	private function enqueue_production_assets() {
		$manifest_path = get_stylesheet_directory() . '/dist/manifest.json';

		if ( file_exists( $manifest_path ) ) {
			$manifest = json_decode( file_get_contents( $manifest_path ), true );

			if ( isset( $manifest['assets/scss/styles.scss'] ) ) {
				wp_enqueue_style(
					'child-styles',
					get_stylesheet_directory_uri() . '/dist/' . $manifest['assets/scss/styles.scss']['file'],
					array( 'twentytwentyfive-style' ),
					null
				);
			}

			if ( isset( $manifest['assets/js/scripts.js'] ) ) {
				wp_enqueue_script(
					'twentytwentyfive-child-scripts',
					get_stylesheet_directory_uri() . '/dist/' . $manifest['assets/js/scripts.js']['file'],
					array(),
					null,
					true
				);
				wp_script_add_data( 'twentytwentyfive-child-scripts', 'type', 'module' );
			}
		} else {
			wp_enqueue_style(
				'child-fallback',
				get_stylesheet_directory_uri() . '/style.css',
				array( 'twentytwentyfive-style' ),
				wp_get_theme()->get( 'Version' )
			);
		}
	}

	/**
	 * Add module type to Vite scripts for proper hot reloading.
	 *
	 * @param string $tag Script tag.
	 * @param string $handle Script handle.
	 * @param string $src Script source URL.
	 * @return string Modified script tag.
	 */
	public function add_module_to_vite_scripts( $tag, $handle, $src ) {
		if ( strpos( $src, 'localhost:3000' ) !== false ) {
			$tag = str_replace( '<script ', '<script type="module" ', $tag );
		}
		return $tag;
	}
}
