<?php
/**
 * Block Registration & Fields: Stats
 *
 * @package MiamiEverywhere
 */

// NOTE: No namespace or function wrapper needed here when included directly by the loader during acf/init

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register the Stats block TYPE directly.
 */
if ( function_exists( 'acf_register_block_type' ) ) {
	acf_register_block_type(
		array(
			'name'            => 'stats',
			'title'           => __( 'Stats', 'miami-everywhere' ),
			'description'     => __( 'A block displaying an image and a list of statistics.', 'miami-everywhere' ),
			'render_template' => 'includes/Blocks/stats/stats.php',
			'category'        => 'miami-blocks',
			'icon'            => 'chart-bar',
			'keywords'        => array( 'stats', 'statistics', 'numbers', 'image' ),
			'supports'        => array(
				'align' => array( 'wide', 'full' ),
				'mode'  => true,
				'jsx'   => true,
			),
		)
	);
}

/**
 * Define ACF Fields for Stats Block directly.
 */
if ( function_exists( 'acf_add_local_field_group' ) ) :
    acf_add_local_field_group( array(
        'key' => 'group_661d9a8bbf9e9',
        'title' => 'Block: Stats',     // Title shown in the ACF UI
        'fields' => array(
            array(
                'key' => 'field_661d9a9b3c1a1',
                'label' => 'Image',
                'name' => 'stats_image',
                'type' => 'image',
                'instructions' => 'Select the image for the left column.',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'return_format' => 'array', // Or 'id' or 'url'
                'preview_size' => 'medium',
                'library' => 'all',
                'min_width' => '',
                'min_height' => '',
                'min_size' => '',
                'max_width' => '',
                'max_height' => '',
                'max_size' => '',
                'mime_types' => '',
            ),
            array(
                'key' => 'field_661d9ac63c1a2',
                'label' => 'Stats Items',
                'name' => 'stats_items',
                'type' => 'repeater',
                'instructions' => 'Add statistics for the right column grid.',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'collapsed' => '',
                'min' => 0,
                'max' => 4, // Limit to 4 for the 2x2 grid, adjust if needed
                'layout' => 'row', // Changed from 'table' for better sidebar display
                'button_label' => 'Add Stat',
                'sub_fields' => array(
                    array(
                        'key' => 'field_661d9ae83c1a3',
                        'label' => 'Stat Title',
                        'name' => 'stat_title',
                        'type' => 'text',
                        'instructions' => '',
                        'required' => 1,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '40',
                            'class' => '',
                            'id' => '',
                        ),
                        'default_value' => '',
                        'placeholder' => '',
                        'prepend' => '',
                        'append' => '',
                        'maxlength' => '',
                    ),
                    array(
                        'key' => 'field_661d9b0f3c1a4',
                        'label' => 'Stat Blurb',
                        'name' => 'stat_blurb',
                        'type' => 'wysiwyg',
                        'instructions' => '',
                        'required' => 1,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '60',
                            'class' => '',
                            'id' => '',
                        ),
                        'default_value' => '',
                        'tabs' => 'visual',
                        'toolbar' => 'basic',
                        'media_upload' => 0,
                        'delay' => 0,
                    ),
                ),
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'block',
                    'operator' => '==',
                    // ACF prefixes block names with 'acf/' when registered via acf_register_block_type
                    'value' => 'acf/stats',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => 'Fields for the Stats block.',
    ) );
endif;
