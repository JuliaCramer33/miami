<?php
/**
 * Block Template: Image Card Grid
 *
 * @package MiamiEverywhere
 * @var   array $block The block settings and attributes.
 * @var   string $content The block inner HTML (empty).
 * @var   bool $is_preview True during AJAX preview.
 * @var   (int|string) $post_id The post ID this block is saved to.
 */

// use function MiamiEverywhere\Utilities\get_acf_link; // Commented out - not currently used in this template

// Block Alignment - Handled by get_block_wrapper_attributes()
// $align_class = $block['align'] ? 'align' . $block['align'] : '';

// Custom Classes & Alignment - Handled by get_block_wrapper_attributes()
$base_class = 'image-card-grid';
// if ( ! empty( $block['className'] ) ) {
//     $class_name .= ' ' . $block['className'];
// }
$wrapper_attributes = get_block_wrapper_attributes( [ 'class' => $base_class ] );

// ACF Fields
$cards = get_field( 'cards' );

// Determine grid columns based on number of cards (default to 3)
$grid_cols = 'grid-cols-1 lg:grid-cols-3'; // Default
if ( $cards ) {
    $card_count = count( $cards );
    if ( $card_count === 2 ) {
        $grid_cols = 'grid-cols-1 lg:grid-cols-2';
    } elseif ( $card_count === 1 ) {
        $grid_cols = 'grid-cols-1 lg:grid-cols-1';
    }
    // Add more logic here if needed for 4+ cards
}

?>

<div <?php echo $wrapper_attributes; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
    <?php if ( $cards ) : ?>
        <div class="grid <?php echo esc_attr( $grid_cols ); ?> gap-4 md:gap-8">
            <?php foreach ( $cards as $card ) :
                $image_id = $card['card_image'];
                $card_title = $card['card_title'];
                $description = $card['card_description'];
                $card_link = $card['card_button_link'];

                // Initialize button variables with defaults
                $button_text = __( 'Learn More', 'miami-everywhere' );
                $button_url = '#';
                $button_target = '_self';

                // Check if $card_link is a valid ACF link array before accessing keys
                if ( is_array( $card_link ) && ! empty( $card_link['url'] ) ) {
                    $button_text = ! empty( $card_link['title'] ) ? $card_link['title'] : $button_text;
                    $button_url = $card_link['url'];
                    $button_target = ! empty( $card_link['target'] ) ? $card_link['target'] : $button_target;
                } elseif ( is_string( $card_link ) && ! empty( $card_link ) ) {
                    // Handle case where the link field might just return a URL string
                    $button_url = $card_link;
                    // Keep default text and target
                }

                // Determine if there is a valid link to display
                $has_valid_link = ( $button_url !== '#' );
                ?>
                <div class="<?php echo esc_attr( $base_class ); ?>__card card relative overflow-hidden bg-neutral-800 flex flex-col justify-end">
                    <div class="card__image-wrapper absolute inset-0 bg-primary">
                        <?php if ( $image_id ) : ?>
                            <?php echo wp_get_attachment_image( $image_id, 'large', false, array( 'class' => 'card__image w-full h-full object-cover' ) ); ?>
                        <?php endif; ?>
                    </div>
                    <div class="card__overlay absolute inset-0"></div>
                    <div class="card__content relative p-6 text-white">
                        <?php if ( $card_title ) : ?>
                            <h3 class="card__title font-bold leading-tight mb-3"><?php echo esc_html( $card_title ); ?></h3>
                        <?php endif; ?>
                        <?php if ( $description ) : ?>
                            <div class="card__description text-base font-normal leading-normal opacity-90 mb-6"><?php echo wp_kses_post( nl2br( $description ) ); ?></div>
                        <?php endif; ?>
                        <?php if ( $has_valid_link ) : ?>
                            <div class="card__cta flex items-center">
                                <a href="<?php echo esc_url( $button_url ); ?>"
                                   class="button button--primary"
                                   target="<?php echo esc_attr( $button_target ); ?>">
                                    <?php echo esc_html( $button_text ); ?>
                                    <span class="button__icon" aria-hidden="true">&gt;</span>
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php elseif ( $is_preview ) : ?>
        <p class="acf-placeholder-message">Add cards using the block settings in the sidebar.</p>
    <?php endif; ?>
</div>
