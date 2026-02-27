<?php
/**
 * Block Template: Related Stories
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

// Block Alignment & Custom Classes
$block_id     = 'related-stories-' . $block['id'];
$align_class  = $block['align'] ? 'align' . $block['align'] : '';
$custom_class = isset( $block['className'] ) ? $block['className'] : '';

// Reverted back to Grid classes
$layout_classes = 'grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8';

// Get the repeater field data from block settings
$related_stories = get_field( 'related_stories_repeater' );

if ( $related_stories ) : ?>
	<div id="<?php echo esc_attr( $block_id ); ?>"
		 class="related-stories-grid <?php echo esc_attr( $layout_classes ); ?> <?php echo esc_attr( $align_class ); ?> <?php echo esc_attr( $custom_class ); ?>">

		<?php foreach ( $related_stories as $story_data ) :
			$testimonial_post_id   = $story_data['selected_testimonial_post']; // Get Post ID from repeater row
			$story_type_to_display = $story_data['story_type_to_display'];     // Get Story Type from repeater row

			if ( ! $testimonial_post_id || ! $story_type_to_display ) {
				continue; // Skip if essential data is missing
			}

			// --- Fetch Data for this Card ---
			$student_name        = get_field( 'testimonial_author', $testimonial_post_id );
			$class_year          = get_field( 'testimonial_class_year', $testimonial_post_id );
			$card_image_id       = null; // Initialize
			$card_excerpt        = '';   // Initialize
			$found_story         = false;

			// Loop through stories within the selected testimonial CPT
			if ( have_rows( 'testimonial_stories', $testimonial_post_id ) ) {
				while ( have_rows( 'testimonial_stories', $testimonial_post_id ) ) :
					the_row();
					// *** IMPORTANT: Adjust 'story_type' if your subfield name is different ***
					$current_story_type = get_sub_field( 'story_type' );

					if ( $current_story_type === $story_type_to_display ) {
						// Found the matching story type
						$card_image_id = get_sub_field( 'story_card_image' );
						$card_excerpt  = get_sub_field( 'story_excerpt' );
						$found_story   = true;
						break; // Stop looping once found
					}
				endwhile;
			}

			// Skip rendering this card if we didn't find the specific story or author name
			if ( ! $found_story || ! $student_name ) {
				continue;
			}

			// --- Prepare HTML Snippets ---
			$image_html   = '';
			$name_html    = '';
			$excerpt_html = '';
			$link_html    = '';

			// Image
			if ( $card_image_id ) {
				// Add the new utility class along with the BEM class
				$image_container_classes = 'related-story-card__image-container bg-primary';
				$image_classes = 'related-story-card__image img-circle-styled';
				$image_html = '<div class="' . esc_attr($image_container_classes) . '">' . wp_get_attachment_image( $card_image_id, 'thumbnail', false, array( 'class' => $image_classes ) ) . '</div>';
			} else {
				// Placeholder might also need utility classes if used
				$image_html = '<div class="related-story-card__image-placeholder bg-primary"></div>';
			}

			// Name + Year
			$formatted_year = '';
			if ( ! empty( $class_year ) ) {
				$year_digits = preg_replace( '/\D/', '', $class_year );
				if ( strlen( $year_digits ) === 2 || strlen( $year_digits ) === 4 ) {
					$formatted_year = " ’" . substr( $year_digits, -2 );
				} else {
					$formatted_year = ' ' . esc_html( $class_year );
				}
			}
			// Added name utilities: text-primary, font-semibold, mb-2
			$name_html = '<h3 class="related-story-card__name text-primary font-semibold">' . esc_html( $student_name ) . esc_html( $formatted_year ) . '</h3>';

			// Excerpt
			if ( $card_excerpt ) {
				// Added excerpt utilities: text-base, leading-normal, mb-4, mx-auto (text color TBD)
				$excerpt_html = '<p class="related-story-card__excerpt text-base leading-normal mb-4 mx-auto">' . wp_kses_post( $card_excerpt ) . '</p>';
			}

			// Link (Modal Trigger)
			// Added link utilities: ..., relative, pr-8. Added data-story-type attribute. Removed flex utils.
			$link_html = '<a href="#" class="related-story-card__link js-open-testimonial-modal relative pr-8 text-base font-medium uppercase text-primary no-underline mt-2" data-testimonial-id="' . esc_attr( $testimonial_post_id ) . '" data-story-type="' . esc_attr( $story_type_to_display ) . '" aria-label="Read more about ' . esc_attr( $student_name ) . '">'
						. esc_html__( 'Read More', 'miami-everywhere' )
					. '</a>';

			// --- Render Card HTML ---
			// Remove width/padding classes, rely on Grid container
			?>
			<div class="related-story-card"> <?php // REMOVED col-* and p-4 ?>
				<?php echo $image_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				<div class="related-story-card__content">
					<div class="related-story-card__text-wrapper">
						<?php
						echo $name_html;    // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
						echo $excerpt_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
						?>
					</div>
					<?php echo $link_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				</div>
			</div>
			<?php

		endforeach; ?>

	</div>
<?php elseif ( $is_preview ) : ?>
	<div class="acf-placeholder">
		<div class="acf-placeholder-label">Add stories to display using the block settings.</div>
	</div>
<?php endif; ?>
