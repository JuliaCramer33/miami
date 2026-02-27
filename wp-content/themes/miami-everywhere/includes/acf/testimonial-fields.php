<?php
/**
 * ACF Field Group: Testimonial Details
 *
 * @package MiamiEverywhere
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( function_exists( 'acf_add_local_field_group' ) ) :

    acf_add_local_field_group( array(
        'key' => 'group_66218b5a7c9f1', // Unique Group Key
        'title' => 'Testimonial Details',
        'fields' => array(
            array(
                'key' => 'field_66218b6e9d5e8', // Unique Field Key
                'label' => 'Student Name',
                'name' => 'testimonial_author', // Keep name for data compatibility
                'type' => 'text',
                'required' => 1,
                'instructions' => 'Enter the name of the student providing the testimonial.',
                'wrapper' => array(
                    'width' => '', 'class' => '', 'id' => '',
                ),
            ),
            array(
                'key' => 'field_662195b0a4c1e', // Unique Field Key
                'label' => 'Class Year',
                'name' => 'testimonial_class_year',
                'type' => 'text',
                'required' => 0,
                'instructions' => 'Enter the class year (e.g., 2024).',
                'placeholder' => '2024',
                'maxlength' => 4,
                'wrapper' => array(
                    'width' => '33', 'class' => '', 'id' => '',
                ),
            ),
            array(
                'key' => 'field_662195dca4c1f', // Unique Field Key
                'label' => 'Major(s)',
                'name' => 'testimonial_major',
                'type' => 'text',
                'required' => 0,
                'instructions' => 'Enter the major or majors.',
                'wrapper' => array(
                    'width' => '33', 'class' => '', 'id' => '',
                ),
            ),
            array(
                'key' => 'field_66219603a4c20', // Unique Field Key
                'label' => 'Minor(s)',
                'name' => 'testimonial_minor',
                'type' => 'text',
                'required' => 0,
                'instructions' => 'Enter the minor or minors (optional).',
                'wrapper' => array(
                    'width' => '33', 'class' => '', 'id' => '',
                ),
            ),
            array(
                'key' => 'field_66219f4a1b2c3', // Stories Repeater
                'label' => 'Stories',
                'name' => 'testimonial_stories',
                'type' => 'repeater',
                'instructions' => 'Add specific stories/quotes for different contexts (e.g., Field Work, Study Abroad).',
                'required' => 0, // Allow testimonials without specific stories for now?
                'layout' => 'block',
                'button_label' => 'Add Story',
                'sub_fields' => array(
                    array(
                        'key' => 'field_66219f7c1b2c4', // Story Type Select
                        'label' => 'Story Type',
                        'name' => 'story_type',
                        'type' => 'select',
                        'required' => 1,
                        'choices' => array(), // Initialize as empty, will be populated by filter
                        'allow_null' => 0,
                        'multiple' => 0,
                        'ui' => 1,
                        'ajax' => 0,
                        'return_format' => 'value',
                        'placeholder' => 'Select the context...',
                        'wrapper' => array(
                            'width' => '', 'class' => '', 'id' => '', // Full width
                        ),
                    ),
                    array(
                        'key' => 'field_card_image', // Moved Up - Profile Image
                        'label' => 'Profile Image',
                        'name' => 'story_card_image',
                        'type' => 'image',
                        'required' => 1,
                        'instructions' => 'A circular profile image for the testimonial card.', //Need to add specs later
                        'return_format' => 'id', // Return Image ID
                        'preview_size' => 'medium',
                        'library' => 'all',
                        'wrapper' => array(
                            'width' => '', 'class' => '', 'id' => '', // Full width or adjust
                        ),
                    ),
                    array(
                        'key' => 'field_story_excerpt', // Story Excerpt
                        'label' => 'Story Excerpt',
                        'name' => 'story_excerpt',
                        'type' => 'textarea',
                        'required' => 0,
                        'instructions' => 'Enter a short (1-2 line) excerpt for this specific story.',
                        'rows' => 2,
                        'new_lines' => '',
                        'wrapper' => array(
                            'width' => '', 'class' => '', 'id' => '', // Full width
                        ),
                    ),
                    array(
                        'key' => 'field_6621a0171b2c5', // Story Main Content WYSIWYG
                        'label' => 'Story Main Content',
                        'name' => 'story_main_content',
                        'type' => 'wysiwyg',
                        'required' => 1,
                        'tabs' => 'all',
                        'toolbar' => 'full',
                        'media_upload' => 1,
                        'wrapper' => array(
                            'width' => '', 'class' => '', 'id' => '',
                        ),
                    ),
                    array(
                        'key' => 'field_6621aa8a1b2c6', // Story Gallery
                        'label' => 'Story Gallery',
                        'name' => 'story_gallery',
                        'type' => 'gallery',
                        'required' => 0,
                        'instructions' => 'Add images relevant to this specific story (optional).',
                        'return_format' => 'id', // Return Image IDs
                        'preview_size' => 'thumbnail',
                        'insert' => 'append',
                        'library' => 'all',
                        'wrapper' => array(
                            'width' => '50', 'class' => '', 'id' => '',
                        ),
                    ),
                    array(
                        'key' => 'field_6621aae01b2c7', // Story Pull Quote WYSIWYG
                        'label' => 'Story Pull Quote',
                        'name' => 'story_pull_quote',
                        'type' => 'wysiwyg',
                        'required' => 0,
                        'instructions' => 'Enter a prominent quote for this story (optional). The cite will be the main Testimonial name.',
                        'tabs' => 'all',
                        'toolbar' => 'basic', // Keep it simple
                        'media_upload' => 0,
                        'wrapper' => array(
                            'width' => '50', 'class' => '', 'id' => '',
                        ),
                    ),
                ),
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'testimonial', // Assign to the Testimonial CPT
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal', // Or 'side'
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => array(
            // 'permalink', // Keep permalink box unless CPT is truly private
            // 'the_content', // Keep main editor visible for now
            'excerpt',
            'discussion',
            'comments',
            'revisions',
            'slug',
            'author',
            'format',
            // 'page_attributes',
            // 'featured_image', // Keep featured image (thumbnail support is on)
            'categories',
            'tags',
            'send-trackbacks',
        ),
        'active' => true,
        'description' => 'Custom fields for testimonials.',
    ) );

endif;
