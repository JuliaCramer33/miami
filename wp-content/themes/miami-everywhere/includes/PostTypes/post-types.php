<?php
/**
 * Post type functions
 *
 * @package MiamiEverywhere
 */

namespace MiamiEverywhere\Functions;

/**
 * Initialize post types
 *
 * @return void
 */
function init_post_types() {
	new \MiamiEverywhere\PostTypes\Testimonials();
}
add_action( 'after_setup_theme', __NAMESPACE__ . '\init_post_types' );

/**
 * Remove old function hooks
 *
 * @return void
 */
function remove_old_hooks() {
	remove_action( 'init', 'MiamiEverywhere\\PostTypes\\Testimonials\\register_post_type' );
	remove_action( 'add_meta_boxes', 'MiamiEverywhere\\PostTypes\\Testimonials\\add_meta_boxes' );
	remove_action( 'save_post_testimonial', 'MiamiEverywhere\\PostTypes\\Testimonials\\save_meta_box' );
}
add_action( 'init', __NAMESPACE__ . '\remove_old_hooks' );
