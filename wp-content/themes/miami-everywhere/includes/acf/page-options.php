<?php
/**
 * Register ACF fields for page options
 *
 * @package Miami_Everywhere
 */

if (function_exists('acf_add_local_field_group')):

    acf_add_local_field_group(array(
        'key' => 'group_page_settings',
        'title' => 'Page Settings',
        'fields' => array(
            array(
                'key' => 'field_hero_section',
                'label' => 'Hero Section',
                'name' => '',
                'type' => 'tab',
                'placement' => 'top',
            ),
            array(
                'key' => 'field_page_icon',
                'label' => 'Page Icon',
                'name' => 'page_icon',
                'type' => 'image',
                'instructions' => 'Select an icon to display in the hero section',
                'required' => 0,
                'return_format' => 'array',
                'preview_size' => 'thumbnail',
                'library' => 'all',
                'mime_types' => 'jpg,jpeg,png,gif,svg',
                'wrapper' => array(
                    'width' => '50',
                ),
            ),
            array(
                'key' => 'field_hero_button_link',
                'label' => 'Hero Button Link',
                'name' => 'hero_button_link',
                'type' => 'link',
                'instructions' => 'Select the link for the hero button.',
                'required' => 0,
                'return_format' => 'array',
                'wrapper' => array(
                    'width' => '50',
                ),
            ),
            array(
                'key' => 'field_intro_section',
                'label' => 'Intro Section',
                'name' => '',
                'type' => 'tab',
                'placement' => 'top',
            ),
            array(
                'key' => 'field_intro_title',
                'label' => 'Intro Title',
                'name' => 'intro_title',
                'type' => 'text',
                'instructions' => 'Enter the title for the intro section',
                'required' => 0,
                'wrapper' => array(
                    'width' => '100',
                ),
            ),
            array(
                'key' => 'field_intro_content',
                'label' => 'Intro Content',
                'name' => 'intro_content',
                'type' => 'wysiwyg',
                'instructions' => 'Enter the content for the intro section',
                'required' => 0,
                'tabs' => 'all',
                'toolbar' => 'full',
                'media_upload' => 0,
            ),
            array(
                'key' => 'field_intro_cta',
                'label' => 'Call to Action',
                'name' => 'intro_cta',
                'type' => 'link',
                'instructions' => 'Add a call to action button (optional)',
                'required' => 0,
                'return_format' => 'array',
            ),
            array(
                'key' => 'field_intro_background_color',
                'label' => 'Intro Background Color',
                'name' => 'intro_background_color',
                'type' => 'radio',
                'instructions' => 'Select an optional background color for the intro section.',
                'required' => 0,
                'choices' => array(
                    '#FFFFFF' => 'White',
                    '#FAF9F7' => 'Warm White',
                ),
                'allow_null' => 1,
                'other_choice' => 0,
                'save_other_choice' => 0,
                'default_value' => '#FFFFFF',
                'layout' => 'vertical',
                'return_format' => 'value',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'page',
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
        'description' => '',
        'show_in_rest' => 0,
    ));

endif;
