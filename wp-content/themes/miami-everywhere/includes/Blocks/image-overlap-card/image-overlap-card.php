<?php
/**
 * Block Template: Image Overlap Card
 *
 * @package MiamiEverywhere
 * @var   array $block The block settings and attributes.
 * @var   string $content The block inner HTML (empty).
 * @var   bool $is_preview True during AJAX preview.
 * @var   (int|string) $post_id The post ID this block is saved to.
 */

// Block Variables
$base_class = 'image-overlap-card'; // Base BEM class

// Block Alignment
$align_class = $block['align'] ? 'align' . $block['align'] : '';

// Custom Classes - build the full wrapper class string manually
$class_name = $base_class; // Start with base class
if ( ! empty( $block['className'] ) ) {
    $class_name .= ' ' . $block['className']; // Add custom classes
}

// ACF Fields (using names defined in register.php)
$image_id    = get_field( 'image' );
$card_title  = get_field( 'card_title' );
$description = get_field( 'card_description' );

// Basic validation: Ensure required fields have data, especially in preview
if ( empty( $image_id ) || empty( $card_title ) ) {
    if ( $is_preview ) {
        echo '<p class="acf-placeholder-message">Please add an image and title using the block settings in the sidebar.</p>';
        return; // Stop rendering if essential data is missing in preview
    }
    // Optionally return early on frontend too if data is missing, or render gracefully
    // return;
}

?>

<div class="<?php echo esc_attr( $class_name ); ?> <?php echo esc_attr( $align_class ); ?> relative"> <?php // Main wrapper uses $class_name + $align_class ?>
    <div class="<?php echo esc_attr( $base_class ); ?>__image-wrapper bg-primary"> <?php // Inner elements use $base_class. Added bg-primary for fallback. ?>
        <?php if ( $image_id ) : ?>
            <?php // Use a size appropriate for wide/full layouts, e.g., 'large' or a custom size
            ?>
            <?php echo wp_get_attachment_image( $image_id, 'large', false, array( 'class' => esc_attr( $base_class ) . '__image' ) ); // Inner elements use $base_class ?>
        <?php endif; ?>
    </div>

    <div class="<?php echo esc_attr( $base_class ); ?>__content-wrapper mx-auto px-4 md:px-0"> <?php // Inner elements use $base_class ?>
        <div class="<?php echo esc_attr( $base_class ); ?>__text-box bg-white pl-4 pr-4 pt-4 pb-4 pl-md-8 pr-md-8 pt-md-6 pb-md-6 shadow-lg relative z-10 -mt-20"> <?php // Inner elements use $base_class ?>
            <?php if ( $card_title ) : ?>
                <h4 class="text-primary mb-4 mt-0 font-semibold text-4xl"><?php echo esc_html( $card_title ); ?></h4> <?php // Removed text-3xl and font-serif. Base H3 style applies. Added text-4xl for 36px font size. ?>
            <?php endif; ?>
            <?php if ( $description ) : ?>
                <div class="text-base leading-normal text-neutral-700"><?php echo wp_kses_post( wpautop( $description ) ); ?></div> <?php // Changed from leading-relaxed to leading-normal ?>
            <?php endif; ?>
        </div>
    </div>
</div>
