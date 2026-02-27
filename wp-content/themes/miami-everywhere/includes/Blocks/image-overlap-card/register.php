<?php
/**
 * Block Registration & Fields: Image Overlap Card
 *
 * @package MiamiEverywhere
 */

// NOTE: No namespace or function wrapper needed here when included directly by the loader during acf/init

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register the Image Overlap Card block TYPE directly.
 */
if ( function_exists( 'acf_register_block_type' ) ) {
    acf_register_block_type([
        'name'            => 'image-overlap-card', // Use name without acf/ prefix here
        'title'           => __( 'Image Overlap Card', 'miami-everywhere' ),
        'description'     => __( 'A card with an overlapping image.', 'miami-everywhere' ),
        'category'        => 'miami-blocks', // Assuming a custom category
        'icon'            => 'columns', // Example icon
        'keywords'        => [ 'image', 'text', 'overlap', 'card' ],
        'render_template' => 'includes/Blocks/image-overlap-card/image-overlap-card.php',
        'mode'            => 'preview', // Or 'edit', 'auto'
        'supports'        => [
            'align' => [ 'wide', 'full' ], // Allow wide and full alignment
            'mode'  => false, // Disable mode switching in editor if desired
            'jsx'   => false, // No inner blocks expected for this simple block
        ],
        // 'enqueue_style'   => get_template_directory_uri() . '/dist/css/style.css', // REMOVED AGAIN - Causes conflicts, rely on add_editor_style
        // 'enqueue_script'  => get_template_directory_uri() . '/dist/js/main.js', // If JS interaction needed
    ]);
}

/**
 * Define ACF Fields for Image Overlap Card block directly.
 */
if ( function_exists( 'acf_add_local_field_group' ) ) :
    acf_add_local_field_group( array(
        'key' => 'group_ioc_668fca1b9c9e1', // Unique Group Key (ioc = image overlap card)
        'title' => 'Block: Image Overlap Card',
        'fields' => array(
            array(
                'key' => 'field_ioc_668fca32b0f7a', // Unique Field Key
                'label' => 'Image',
                'name' => 'image',
                'type' => 'image',
                'instructions' => 'The main background image.',
                'required' => 1,
                'return_format' => 'id', // Return Image ID
                'preview_size' => 'large',
                'library' => 'all',
            ),
            array(
                'key' => 'field_ioc_668fca5fb0f7b', // Unique Field Key
                'label' => 'Title',
                'name' => 'card_title',
                'type' => 'text',
                'instructions' => 'Title displayed in the overlapping text box.',
                'required' => 1,
            ),
            array(
                'key' => 'field_ioc_668fca89b0f7c', // Unique Field Key
                'label' => 'Description',
                'name' => 'card_description',
                'type' => 'textarea', // Simple textarea often sufficient
                'instructions' => 'Main text content for the overlapping box.',
                'required' => 1,
                'rows' => 4,
                'new_lines' => 'wpautop', // Automatically add paragraphs
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'block',
                    'operator' => '==',
                    'value' => 'acf/image-overlap-card', // Match block name (ACF adds prefix here)
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
        'description' => 'Fields for the Image Overlap Card block.',
    ) );
endif;
