<?php
/**
 * Block Registration & Fields: Image Card Grid
 *
 * @package MiamiEverywhere
 */

// NOTE: No namespace or function wrapper needed here when included directly by the loader during acf/init

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register the Image Card Grid block TYPE directly.
 */
if ( function_exists( 'acf_register_block_type' ) ) {
	acf_register_block_type(
		array(
			'name'            => 'image-card-grid',
			'title'           => __( 'Image Card Grid', 'miami-everywhere' ),
			'description'     => __( 'A grid of cards, each with an image, title, and description.', 'miami-everywhere' ),
			'render_template' => 'includes/Blocks/image-card-grid/image-card-grid.php',
			'category'        => 'miami-blocks',
			'icon'            => 'images-alt2',
			'keywords'        => array( 'card', 'grid', 'image', 'promo', 'link' ),
			'mode'            => 'preview',
			'supports'        => array(
				'align' => array( 'wide', 'full' ),
				'jsx'   => true,
			),
		)
	);
}

/**
 * Define ACF Fields for Image Card Grid block directly.
 */
if ( function_exists( 'acf_add_local_field_group' ) ) :
    acf_add_local_field_group( array(
        'key' => 'group_66217b5a7c1d0', // Unique Group Key
        'title' => 'Block: Image Card Grid',
        'fields' => array(
            array(
                'key' => 'field_66217b6e9d5e1', // Unique Field Key
                'label' => 'Cards',
                'name' => 'cards',
                'type' => 'repeater',
                'instructions' => 'Add cards to the grid.',
                'required' => 1,
                'layout' => 'block', // Use block layout for better sidebar UI
                'button_label' => 'Add Card',
                'min' => 1,
                'sub_fields' => array(
                    array(
                        'key' => 'field_66217ba09d5e2', // Sub Field Key
                        'label' => 'Image',
                        'name' => 'card_image',
                        'type' => 'image',
                        'instructions' => 'Background image for the card.',
                        'required' => 1,
                        'return_format' => 'id', // Return Image ID for flexibility
                        'preview_size' => 'medium',
                        'library' => 'all',
                    ),
                    array(
                        'key' => 'field_66217bdc9d5e3', // Sub Field Key
                        'label' => 'Title',
                        'name' => 'card_title',
                        'type' => 'text',
                        'required' => 1,
                    ),
                    array(
                        'key' => 'field_66217bf49d5e4', // Sub Field Key
                        'label' => 'Description',
                        'name' => 'card_description',
                        'type' => 'textarea',
                        'required' => 1,
                        'rows' => 3,
                    ),
                    array(
                        'key' => 'field_66217c0e9d5e5', // Sub Field Key
                        'label' => 'Button Link',
                        'name' => 'card_button_link',
                        'type' => 'link', // Use ACF Link field type
                        'instructions' => 'Link for the button.',
                        'required' => 1,
                        'return_format' => 'array', // Returns url, title, target
                    ),
                ),
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'block',
                    'operator' => '==',
                    'value' => 'acf/image-card-grid', // Matches block name
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
        'description' => 'Fields for the Image Card Grid block.',
    ) );
endif;
