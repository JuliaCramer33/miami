<?php
/**
 * Block Styles
 *
 * @package MiamiEverywhere
 */

namespace MiamiEverywhere\BlockStyles;

/**
 * Register custom block styles
 */
function register_block_styles() {
    // Register the outline style for buttons and make it the default
    register_block_style(
        'core/button',
        array(
            'name'         => 'outline',
            'label'        => __( 'Outline', 'miami-everywhere' ),
            'is_default'   => true,
        )
    );

    // Register the offset style for buttons
    register_block_style(
        'core/button',
        array(
            'name'         => 'offset',
            'label'        => __( 'Offset', 'miami-everywhere' ),
        )
    );
}
add_action( 'init', __NAMESPACE__ . '\\register_block_styles' );
