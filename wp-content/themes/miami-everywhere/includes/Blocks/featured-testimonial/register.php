<?php
/**
 * Block Registration & Fields: Featured Testimonial
 *
 * @package MiamiEverywhere
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Register the block type directly
if ( function_exists( 'acf_register_block_type' ) ) {
	acf_register_block_type(
		array(
			'name'            => 'featured-testimonial',
			'title'           => __( 'Featured Testimonial', 'miami-everywhere' ),
			'description'     => __( 'Displays a styled testimonial card with quote and image.', 'miami-everywhere' ),
			'render_template' => dirname( __FILE__ ) . '/featured-testimonial.php', // Use relative path
			'category'        => 'miami-blocks',
			'icon'            => 'format-quote',
			'keywords'        => array( 'testimonial', 'quote', 'featured', 'card' ),
			'mode'            => 'preview',
			'supports'        => array(
				'align' => array( 'wide', 'full' ),
				'jsx'   => true,
				'color' => array(
					'background' => true,
					'text' => true,
					'gradients' => false,
					'link' => false,
				),
			),
			'enqueue_style'   => get_template_directory_uri() . '/dist/style.css',
		)
	);
}

// Register the field group directly
if ( function_exists( 'acf_add_local_field_group' ) ) {
	acf_add_local_field_group(
		array(
			'key'                   => 'group_featured_testimonial',
			'title'                 => 'Featured Testimonial Content',
			'fields'                => array(
				array(
					'key'   => 'field_ft_quote',
					'label' => 'Quote Text',
					'name'  => 'quote_text',
					'type'  => 'wysiwyg',
					'tabs' => 'visual',
					'toolbar' => 'basic',
					'media_upload' => 0,
					'required' => 1,
				),
				array(
					'key'           => 'field_ft_image',
					'label'         => 'Author Image',
					'name'          => 'author_image',
					'type'          => 'image',
					'required'      => 1,
					'return_format' => 'id',
					'preview_size'  => 'thumbnail',
					'library'       => 'all',
				),
				array(
					'key'   => 'field_ft_name',
					'label' => 'Author Name',
					'name'  => 'author_name',
					'type'  => 'text',
					'required' => 1,
				),
				array(
					'key'   => 'field_ft_year',
					'label' => 'Author Class Year (e.g., \'24)',
					'name'  => 'author_year',
					'type'  => 'text',
				),
				array(
					'key'           => 'field_ft_svg_color',
					'label'         => 'Quote Icon Color',
					'name'          => 'quote_icon_color',
					'type'          => 'color_picker',
					'instructions'  => 'Optional: Overrides the text color for the quote mark SVGs.',
					'required'      => 0,
					'use_theme_palette' => 1, // Use theme.json palette
					'default_value' => '', // Default will be inherited text color
				),
			),
			'location'              => array(
				array(
					array(
						'param'    => 'block',
						'operator' => '==',
						'value'    => 'acf/featured-testimonial',
					),
				),
			),
			'menu_order'            => 0,
			'position'              => 'normal',
			'style'                 => 'default',
			'label_placement'       => 'top',
			'instruction_placement' => 'label',
			'hide_on_screen'        => '',
			'active'                => true,
			'description'           => '',
		)
	);
}
