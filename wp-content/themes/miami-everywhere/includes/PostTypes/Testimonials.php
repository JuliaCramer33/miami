<?php
/**
 * Testimonials Custom Post Type
 *
 * @package MiamiEverywhere
 */

namespace MiamiEverywhere\PostTypes;

/**
 * Class Testimonials
 */
class Testimonials {

    /**
     * Constructor
     */
    public function __construct() {
        add_action( 'init', array( $this, 'register_post_type' ) );
    }

    /**
     * Register the Testimonials custom post type
     */
    public function register_post_type() {
        $labels = array(
            'name'                  => _x( 'Testimonials', 'Post type general name', 'miami-everywhere' ),
            'singular_name'         => _x( 'Testimonial', 'Post type singular name', 'miami-everywhere' ),
            'menu_name'            => _x( 'Testimonials', 'Admin Menu text', 'miami-everywhere' ),
            'name_admin_bar'       => _x( 'Testimonial', 'Add New on Toolbar', 'miami-everywhere' ),
            'add_new'              => __( 'Add New', 'miami-everywhere' ),
            'add_new_item'         => __( 'Add New Testimonial', 'miami-everywhere' ),
            'new_item'             => __( 'New Testimonial', 'miami-everywhere' ),
            'edit_item'            => __( 'Edit Testimonial', 'miami-everywhere' ),
            'view_item'            => __( 'View Testimonial', 'miami-everywhere' ),
            'all_items'            => __( 'All Testimonials', 'miami-everywhere' ),
            'search_items'         => __( 'Search Testimonials', 'miami-everywhere' ),
            'parent_item_colon'    => __( 'Parent Testimonials:', 'miami-everywhere' ),
            'not_found'            => __( 'No testimonials found.', 'miami-everywhere' ),
            'not_found_in_trash'   => __( 'No testimonials found in Trash.', 'miami-everywhere' ),
            'featured_image'       => _x( 'Testimonial Image', 'Overrides the "Featured Image" phrase', 'miami-everywhere' ),
            'set_featured_image'   => _x( 'Set testimonial image', 'Overrides the "Set featured image" phrase', 'miami-everywhere' ),
            'remove_featured_image' => _x( 'Remove testimonial image', 'Overrides the "Remove featured image" phrase', 'miami-everywhere' ),
            'use_featured_image'   => _x( 'Use as testimonial image', 'Overrides the "Use as featured image" phrase', 'miami-everywhere' ),
        );

        $args = array(
            'labels'             => $labels,
            'public'             => true,
            'show_ui'           => true,
            'show_in_menu'      => true,
            'rewrite'           => array( 'slug' => 'testimonial' ),
            'capability_type'   => 'post',
            'has_archive'       => false,
            'hierarchical'      => false,
            'menu_position'     => 20,
            'menu_icon'         => 'dashicons-format-quote',
            'supports'          => array( 'title', 'editor', 'thumbnail' ),
            'show_in_rest'      => true,
            'exclude_from_search' => true,
        );

        register_post_type( 'testimonial', $args );

        // Register Story Type Taxonomy
        $taxonomy_labels = array(
            'name'              => _x( 'Story Types', 'taxonomy general name', 'miami-everywhere' ),
            'singular_name'     => _x( 'Story Type', 'taxonomy singular name', 'miami-everywhere' ),
            'search_items'      => __( 'Search Story Types', 'miami-everywhere' ),
            'all_items'         => __( 'All Story Types', 'miami-everywhere' ),
            'parent_item'       => __( 'Parent Story Type', 'miami-everywhere' ),
            'parent_item_colon' => __( 'Parent Story Type:', 'miami-everywhere' ),
            'edit_item'         => __( 'Edit Story Type', 'miami-everywhere' ),
            'update_item'       => __( 'Update Story Type', 'miami-everywhere' ),
            'add_new_item'      => __( 'Add New Story Type', 'miami-everywhere' ),
            'new_item_name'     => __( 'New Story Type Name', 'miami-everywhere' ),
            'menu_name'         => __( 'Story Types', 'miami-everywhere' ),
        );

        $taxonomy_args = array(
            'hierarchical'      => true, // Allows parent/child relationships like categories
            'labels'            => $taxonomy_labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => array( 'slug' => 'story-type' ), // URL slug for the taxonomy archive
            'show_in_rest'      => true, // Important for Gutenberg/Block editor
        );

        register_taxonomy( 'story_type', array( 'testimonial' ), $taxonomy_args );
    }

    /**
     * Add custom meta boxes for testimonials - REMOVED
     */
    // public function add_meta_boxes() { ... }

    /**
     * Render the meta box - REMOVED
     */
    // public function render_meta_box( $post ) { ... }

    /**
     * Save the meta box data - REMOVED
     */
    // public function save_meta_box( $post_id ) { ... }
}

