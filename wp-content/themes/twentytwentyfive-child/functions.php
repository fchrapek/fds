<?php

if (!defined('ABSPATH')) {
    exit;
}

define('CHILD_THEME_NAMESPACE', 'TwentyTwentyFiveChild\\');

/**
 * Autoloader for custom classes
 */
spl_autoload_register(function ($class_name) {
    $base_directory = get_stylesheet_directory() . '/inc/';
    $namespace_prefix_length = strlen(CHILD_THEME_NAMESPACE);
    
    if (strncmp(CHILD_THEME_NAMESPACE, $class_name, $namespace_prefix_length) !== 0) {
        return;
    }
    
    $relative_class_name = substr($class_name, $namespace_prefix_length);
    $class_filename = $base_directory . str_replace('\\', '/', $relative_class_name) . '.php';
    
    if (file_exists($class_filename)) {
        require $class_filename;
    }
});

/**
 * Initialize classes
 */
TwentyTwentyFiveChild\WP\Theme::get_instance();
TwentyTwentyFiveChild\WP\Assets::get_instance();
TwentyTwentyFiveChild\WP\CustomPostTypes::get_instance();
TwentyTwentyFiveChild\WP\CustomTaxonomies::get_instance();
TwentyTwentyFiveChild\WP\AjaxEndpoints::get_instance();
TwentyTwentyFiveChild\WP\PostAjax::get_instance();
