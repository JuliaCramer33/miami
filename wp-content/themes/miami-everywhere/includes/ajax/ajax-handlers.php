<?php
/**
 * Theme AJAX Handlers
 *
 * @package MiamiEverywhere
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * AJAX handler to fetch testimonial story data for the modal.
 */
function miami_get_testimonial_story_data() {
    // 1. Verify Nonce
    check_ajax_referer( 'testimonial_modal_nonce', 'nonce' );

    // 2. Get and Sanitize Input Data
    $testimonial_id = isset( $_POST['testimonial_id'] ) ? absint( $_POST['testimonial_id'] ) : 0;
    $story_type     = isset( $_POST['story_type'] ) ? sanitize_key( $_POST['story_type'] ) : '';

    // 3. Validate Input
    if ( ! $testimonial_id || ! $story_type || get_post_type( $testimonial_id ) !== 'testimonial' ) {
        wp_send_json_error( array( 'message' => 'Invalid request.' ) );
    }

    // 4. Fetch Data
    $data = array();
    $found_story = false;

    // General Testimonial Fields
    $data['name']        = get_field( 'testimonial_author', $testimonial_id );
    $data['class_year']  = get_field( 'testimonial_class_year', $testimonial_id );
    $data['major']       = get_field( 'testimonial_major', $testimonial_id );
    $data['minor']       = get_field( 'testimonial_minor', $testimonial_id );

    // Check if essential name field is present
    if ( empty( $data['name'] ) ) {
         wp_send_json_error( array( 'message' => 'Testimonial data incomplete (missing name).' ) );
    }

    // Loop through stories to find the specific one
    if ( have_rows( 'testimonial_stories', $testimonial_id ) ) {
        while ( have_rows( 'testimonial_stories', $testimonial_id ) ) :
            the_row();
            // *** Adjust 'story_type' if your subfield name is different ***
            $current_story_type = get_sub_field( 'story_type' );

            if ( $current_story_type === $story_type ) {
                // Found the matching story
                // $data['header_image_id'] = get_sub_field( 'story_card_image' ); // REMOVED: Don't use story-specific image for header
                $data['main_content']    = get_sub_field( 'story_main_content' );
                $data['pull_quote']      = get_sub_field( 'story_pull_quote' );
                $data['gallery_ids']     = get_sub_field( 'story_gallery' ); // Get array of IDs
                $found_story = true;
                break; // Stop looping
            }
        endwhile;
    }

    // 5. Handle "Not Found"
    if ( ! $found_story ) {
        wp_send_json_error( array( 'message' => "Story type '{$story_type}' not found for this testimonial." ) );
    }

    // 6. Prepare & Sanitize/Escape Data for JSON

    // Format Class Year
    $formatted_year = '';
    if ( ! empty( $data['class_year'] ) ) {
        $year_digits = preg_replace( '/\D/', '', $data['class_year'] );
        // Always use 4 digits if available, otherwise use original input
        if ( strlen( $year_digits ) === 4 ) {
            $formatted_year = $year_digits; // Use the full 4 digits
        } else {
            // Fallback for non-4-digit inputs (or original non-numeric)
            $formatted_year = esc_html( $data['class_year'] );
        }
    }
    $data['formatted_year'] = $formatted_year; // Assign the potentially 4-digit year
    // Remove original class year if desired
    // unset($data['class_year']);

    // Get the featured image URL
    $featured_image_id = get_post_thumbnail_id( $testimonial_id );
    $featured_image_url = $featured_image_id ? get_the_post_thumbnail_url($testimonial_id, '1536x1536') : ''; // Use 1536x1536 for better quality

    // Get the gallery images HTML
    $gallery_field = get_field('gallery', $testimonial_id);

    // Get Gallery Image URLs & Alt Text (Example: Medium size)
    $data['gallery_html'] = '';
    if ( ! empty( $data['gallery_ids'] ) && is_array( $data['gallery_ids'] ) ) {
        foreach ( $data['gallery_ids'] as $image_id ) {
            // Get image URL
            $img_url = wp_get_attachment_image_url( $image_id, 'medium_large' ); // Use medium_large for better quality/size balance
            // Get alt text
            $img_alt = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
            $img_alt = $img_alt ? esc_attr( $img_alt ) : ( ! empty( $data['name'] ) ? esc_attr( $data['name'] ) : '' ) . ' gallery image'; // Safer fallback alt text

            if ( $img_url ) {
                 // Add classes for potential styling if needed
                 // Wrap the image in a div for JS targeting and layout
                 $data['gallery_html'] .= '<div class="gallery-image-item">';
                 $placeholder_src = 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7';
                 $data['gallery_html'] .= '<img src="' . $placeholder_src . '" data-splide-lazy="' . esc_url( $img_url ) . '" data-actual-src="' . esc_url( $img_url ) . '" alt="' . $img_alt . '" class="w-full h-auto object-cover rounded">';
                 $data['gallery_html'] .= '</div>';
            }
        }
    }
     // Remove IDs if no longer needed
    // unset($data['gallery_ids']);
    // unset($data['header_image_id']);

    // Explicitly set the header image URL to the post's featured image URL (confirmed requirement)
    $data['header_image_url'] = $featured_image_url;

    // --- Sanitize/Escape Output ---
    $data['name']           = ! empty( $data['name'] ) ? esc_html( $data['name'] ) : '';
    $data['formatted_year'] = esc_html( $data['formatted_year'] ); // Already processed, just escape
    $data['major']          = ! empty( $data['major'] ) ? esc_html( $data['major'] ) : '';
    $data['minor']          = ! empty( $data['minor'] ) ? esc_html( $data['minor'] ) : '';
    $data['main_content']   = ! empty( $data['main_content'] ) ? wp_kses_post( $data['main_content'] ) : ''; // Sanitize WYSIWYG
    $data['pull_quote']     = ! empty( $data['pull_quote'] ) ? wp_kses_post( $data['pull_quote'] ) : ''; // Sanitize WYSIWYG (adjust if plain text)
    // gallery_html is already generated with esc_url/esc_attr

    // 7. Send Sanitized/Escaped JSON Response
    wp_send_json_success( $data );

    // 8. Die is required
    wp_die();
}
add_action( 'wp_ajax_get_testimonial_story', 'miami_get_testimonial_story_data' );
add_action( 'wp_ajax_nopriv_get_testimonial_story', 'miami_get_testimonial_story_data' );
