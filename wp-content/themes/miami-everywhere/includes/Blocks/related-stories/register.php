<?php
/**
 * Block Registration: Related Stories
 *
 * @package MiamiEverywhere
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( function_exists( 'acf_register_block_type' ) ) {
	acf_register_block_type(
		array(
			'name'            => 'related-stories',
			'title'           => __( 'Related Stories', 'miami-everywhere' ),
			'description'     => __( 'Displays a grid of selected story posts.', 'miami-everywhere' ),
			'render_template' => 'includes/Blocks/related-stories/related-stories.php',
			'category'        => 'miami-blocks', // Or your custom category
			'icon'            => 'admin-post', // Consider a more relevant icon like 'list-view' or 'excerpt-view'
			'keywords'        => array( 'testimonial', 'story', 'related', 'card' ),
			'supports'        => array(
				'align' => true,
				'mode'  => false, // Typically render blocks server-side
				'jsx'   => false,
			),
			'enqueue_assets'  => function() {
				// Enqueue block-specific styles if needed (if not handled globally)
				// wp_enqueue_style('block-related-stories', get_template_directory_uri() . '/assets/css/blocks/related-stories.css', array(), filemtime(get_template_directory() . '/assets/css/blocks/related-stories.css'));
			},
		)
	);
}

// Define ACF Field Group for the Block
if ( function_exists( 'acf_add_local_field_group' ) ) :

	acf_add_local_field_group(
		array(
			'key'                   => 'group_related_stories_block',
			'title'                 => 'Block: Related Stories',
			'fields'                => array(
				array(
					'key'        => 'field_related_stories_repeater',
					'label'      => 'Stories to Display',
					'name'       => 'related_stories_repeater',
					'type'       => 'repeater',
					'instructions' => 'Add each story card you want to display.',
					'required'   => 1,
					'layout'     => 'block', // or 'table', 'row'
					'button_label' => 'Add Story Card',
					'min'        => 1,
					'max'        => 0, // 0 = no limit
					'sub_fields' => array(
						array(
							'key'           => 'field_related_testimonial_post',
							'label'         => 'Select Testimonial',
							'name'          => 'selected_testimonial_post',
							'type'          => 'post_object',
							'instructions'  => 'Choose the testimonial containing the story.',
							'required'      => 1,
							'post_type'     => array( 'testimonial' ),
							'taxonomy'      => array(), // Optional: filter by taxonomy
							'allow_null'    => 0,
							'multiple'      => 0, // Select only one post
							'return_format' => 'id', // Return Post ID
							'ui'            => 1,
						),
						array(
							'key'           => 'field_related_story_type',
							'label'         => 'Story Type to Display',
							'name'          => 'story_type_to_display',
							'type'          => 'select',
							'instructions'  => 'Select which story type from the chosen testimonial to display.',
							'required'      => 1,
							'choices'       => array(), // Initialize as empty, will be populated by filter
							'allow_null'    => 0,
							'multiple'      => 0,
							'ui'            => 1,
							'ajax'          => 0,
							'return_format' => 'value', // Return the choice key (e.g., 'field_work')
							'placeholder'   => '',
						),
					),
				),
			),
			'location'              => array(
				array(
					array(
						'param'    => 'block',
						'operator' => '==',
						'value'    => 'acf/related-stories',
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

endif;
