<?php
/**
 * Admin Features & Customizations
 *
 * Includes dashboard widgets, admin notices, etc.
 *
 * @package MiamiEverywhere\Setup
 */

namespace MiamiEverywhere\Setup;

/**
 * Register the custom dashboard widget.
 */
function miami_add_content_guide_widget() {
    wp_add_dashboard_widget(
        'miami_content_guide_widget',          // New widget slug
        esc_html__( 'Content Editing Guide', 'miami-everywhere' ), // New title
        __NAMESPACE__ . '\miami_render_content_guide_widget' // New display function
    );
}
add_action( 'wp_dashboard_setup', __NAMESPACE__ . '\miami_add_content_guide_widget' );

/**
 * Render the content for the custom dashboard widget.
 */
function miami_render_content_guide_widget() {
    $guide_pages = [
        'utility-class-guide' => [
            'title' => __( 'Utility Class Guide', 'miami-everywhere' ),
            'desc'  => __( 'Learn how to apply common styling adjustments like spacing and alignment using CSS utility classes.', 'miami-everywhere' ),
        ],
        'block-guide' => [
            'title' => __( 'Custom Block Guide', 'miami-everywhere' ),
            'desc'  => __( 'Explore the custom blocks available in this theme and understand their fields and options.', 'miami-everywhere' ),
        ],
    ];

    $output = '';

    foreach ( $guide_pages as $slug => $details ) {
        $args = [
            'name'           => $slug,
            'post_type'      => 'page',
            'post_status'    => ['private', 'publish'], // Look for private or published pages
            'numberposts'    => 1,
        ];
        $page_query_result = get_posts($args);
        $guide_page = !empty($page_query_result) ? $page_query_result[0] : null;

        if ( $guide_page instanceof \WP_Post ) {
            $guide_page_url = get_permalink( $guide_page->ID );
            $output .= '<div style="margin-bottom: 1.5em;">';
            $output .= '<h4>' . esc_html( $details['title'] ) . '</h4>';
            $output .= '<p>' . esc_html( $details['desc'] ) . '</p>';
            $output .= '<p><a href="' . esc_url( $guide_page_url ) . '" class="button button-secondary">';
            $output .= sprintf( esc_html__( 'View %s', 'miami-everywhere' ), esc_html( $details['title'] ) );
            $output .= '</a></p>';
            $output .= '</div>';
        }
    }

    if ( empty( $output ) ) {
        echo '<p>' . esc_html__( 'No content guides found.', 'miami-everywhere' ) . '</p>';
    } else {
        // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        echo $output;
    }
}
