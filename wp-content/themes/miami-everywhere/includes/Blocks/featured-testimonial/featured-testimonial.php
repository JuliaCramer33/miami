<?php
/**
 * Block Template: Featured Testimonial
 *
 * @package MiamiEverywhere
 * @var   array $block The block settings and attributes.
 * @var   string $content The block inner HTML (empty).
 * @var   bool $is_preview True during AJAX preview.
 * @var   (int|string) $post_id The post ID this block is saved to.
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// ACF Fields
$quote_text   = get_field( 'quote_text' );
$author_image_id = get_field( 'author_image' );
$author_name  = get_field( 'author_name' );
$author_year  = get_field( 'author_year' ); // Optional
$svg_color    = get_field( 'quote_icon_color' ); // Re-added

// Block Alignment & Custom Classes
$block_id     = 'featured-testimonial-' . $block['id'];
$align_class  = $block['align'] ? 'align' . $block['align'] : '';
$custom_class = isset( $block['className'] ) ? $block['className'] : '';

// Prepare wrapper classes
$wrapper_classes = [ 'featured-testimonial', $align_class, $custom_class ];
if ( ! empty( $block['backgroundColor'] ) ) {
	$wrapper_classes[] = 'has-background';
	$wrapper_classes[] = 'has-' . $block['backgroundColor'] . '-background-color';
}
if ( ! empty( $block['textColor'] ) ) {
	$wrapper_classes[] = 'has-text-color';
	$wrapper_classes[] = 'has-' . $block['textColor'] . '-color';
}
$wrapper_attributes = get_block_wrapper_attributes( [ 'class' => implode( ' ', array_filter( $wrapper_classes ) ) ] );

// Prepare inline styles specifically for the SVG icons
$svg_inline_styles = '';
if ( ! empty( $svg_color ) ) {
	$svg_inline_styles = 'style="color: ' . esc_attr( $svg_color ) . ';"'; // Use color property for SVG
}

// Quote SVG data (same as used in modal)
$quote_svg_path = "M20.5 0.675537L29.75 8.17555C21.75 13.4255 14.5 23.4255 13.75 31.4255C14 31.4255 15.75 31.1755 17 31.1755C24 31.1755 29 36.4255 29 43.9255C29 51.1755 23.25 57.1755 15.75 57.1755C7.5 57.1755 0.25 50.4255 0.25 38.1755C0.25 22.9256 9 8.92554 20.5 0.675537ZM60.5 0.675537L69.75 8.17555C61.75 13.4255 54.75 23.4255 53.75 31.4255C54 31.4255 55.75 31.1755 57 31.1755C64 31.1755 69.25 36.4255 69.25 43.9255C69.25 51.1755 63.25 57.1755 55.75 57.1755C47.5 57.1755 40.25 50.4255 40.25 38.1755C40.25 22.9256 49 8.92554 60.5 0.675537Z";

// Basic validation
if ( empty( $quote_text ) || empty( $author_image_id ) || empty( $author_name ) ) {
	if ( $is_preview ) {
		echo '<p class="acf-placeholder-message">Please add quote text, author image, and author name.</p>';
	}
	return; // Exit if required fields are missing
}

// Prepare optional year
$year_suffix = '';
if ( ! empty( $author_year ) ) {
    $year_digits = preg_replace( '/\D/', '', $author_year );
    if ( strlen( $year_digits ) === 2 || strlen( $year_digits ) === 4 ) { // Handle 2 or 4 digit years
        $year_suffix = " ’" . substr( $year_digits, -2 ); // Smart quote and last two digits
    } else {
        $year_suffix = ' ' . esc_html( $author_year ); // Fallback for other formats
    }
}

?>
<div <?php echo $wrapper_attributes; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<div class="featured-testimonial__inner">
		<div class="featured-testimonial__quote-section" >
			<svg class="featured-testimonial__quote-icon featured-testimonial__quote-icon--top" width="70" height="58" viewBox="0 0 70 58" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" <?php echo $svg_inline_styles; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
				<path d="<?php echo esc_attr( $quote_svg_path ); ?>" fill="currentColor"/>
			</svg>

			<blockquote class="featured-testimonial__quote-text">
				<?php echo wp_kses_post( $quote_text ); // Already includes autop ?>
			</blockquote>

			<hr class="featured-testimonial__divider" aria-hidden="true">

			<div class="featured-testimonial__author-info"> <?php // Wrapper for image and name ?>
				<div class="featured-testimonial__author-image bg-primary"> <?php // Added bg-primary for fallback ?>
					<?php echo wp_get_attachment_image( $author_image_id, 'thumbnail', false, array( 'class' => 'img-circle-styled' ) ); // Reuse utility class // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				</div>

				<div class="featured-testimonial__author-name">
					<?php echo esc_html( $author_name ) . esc_html( $year_suffix ); // Ensure year suffix is also escaped ?>
				</div>
			</div> <?php // End author-info ?>

			<svg class="featured-testimonial__quote-icon featured-testimonial__quote-icon--bottom" width="70" height="58" viewBox="0 0 70 58" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" <?php echo $svg_inline_styles; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
				<path d="<?php echo esc_attr( $quote_svg_path ); ?>" fill="currentColor"/>
			</svg>
		</div>
	</div>
</div>
