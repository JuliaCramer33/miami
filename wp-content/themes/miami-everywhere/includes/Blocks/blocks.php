<?php
/**
 * Custom ACF Block Registration
 *
 * @package MiamiEverywhere
 */

namespace MiamiEverywhere\Blocks;

/**
 * Register custom blocks
 */
function register_blocks() {
    // This function is no longer needed for ACF blocks as they are auto-loaded.
    // You can keep it if you plan to register non-ACF blocks here.
}

/**
 * Register custom block category
 *
 * @param array $categories Block categories.
 * @return array
 */
function register_block_category( $categories ) {
    return array_merge(
        $categories,
        array(
            array(
                'slug'  => 'miami-blocks',
                'title' => __( 'Miami Everywhere', 'miami-everywhere' ),
            ),
        )
    );
}
add_filter( 'block_categories_all', __NAMESPACE__ . '\\register_block_category', 10, 1 );

/**
 * Blocks Setup
 *
 * @package MiamiEverywhere
 */

namespace MiamiEverywhere\Blocks;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Initialize blocks
 */
function setup_blocks() {
	// Example: Autoload blocks based on subdirectory names (if using Block_Loader)
	// new Block_Loader();

	// Add custom block categories if needed
	// add_filter( 'block_categories_all', __NAMESPACE__ . '\add_block_categories' );

	// Register custom block styles
	add_action( 'init', __NAMESPACE__ . '\register_custom_block_styles' );

	// Enqueue editor-only block assets
	add_action( 'enqueue_block_editor_assets', __NAMESPACE__ . '\enqueue_block_editor_assets' );
}

/**
 * Register Custom Block Styles
 */
function register_custom_block_styles() {
	// Image Block: Circle Styled
	register_block_style(
		'core/image',
		array(
			'name'         => 'circle-styled',
			'label'        => __( 'Circle Styled', 'miami-everywhere' ),
			'is_default'   => false,
		)
	);

	// Columns Block: No Gap
	register_block_style(
		'core/columns',
		array(
			'name'         => 'no-gap',
			'label'        => __( 'No Gap', 'miami-everywhere' ),
			'is_default'   => false,
		)
	);

	// Columns Block: Medium Gap (Example - if default isn't desired)
	// register_block_style(
	// 	'core/columns',
	// 	array(
	// 		'name'         => 'gap-medium',
	// 		'label'        => __( 'Medium Gap', 'miami-everywhere' ),
	// 		'is_default'   => true, // Make this the default if needed
	// 	)
	// );

	// Columns Block: Wide Gap (Example)
	// register_block_style(
	// 	'core/columns',
	// 	array(
	// 		'name'         => 'gap-wide',
	// 		'label'        => __( 'Wide Gap', 'miami-everywhere' ),
	// 		'is_default'   => false,
	// 	)
	// );

	// Add other block style registrations here...
}

/**
 * Enqueue block editor specific assets.
 */
function enqueue_block_editor_assets() {
	// Example: Enqueue editor-only JS or CSS
	// wp_enqueue_script(...);
	// wp_enqueue_style(...);
}

/**
 * Add custom block categories.
 *
 * @param array $categories Array of block categories.
 * @return array Updated categories.
 */
/*
function add_block_categories( $categories ) {
	return array_merge(
		$categories,
		array(
			array(
				'slug' => 'miami-blocks',
				'title' => __( 'Miami Blocks', 'miami-everywhere' ),
			),
		)
	);
}
*/

// Initialize
setup_blocks();
