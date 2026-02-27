<?php
/**
 * Block Template: Stats
 *
 * @package MiamiEverywhere
 * @var   array $block The block settings and attributes.
 * @var   string $content The block inner HTML (empty).
 * @var   bool $is_preview True during AJAX preview.
 * @var   (int|string) $post_id The post ID this block is saved to.
 */

// Block Alignment
$align_class = $block['align'] ? 'align' . $block['align'] : '';

// Custom Classes
$class_name = 'stats-block';
if ( ! empty( $block['className'] ) ) {
    $class_name .= ' ' . $block['className'];
}

// ACF Fields
$image       = get_field( 'stats_image' );
$stats_items = get_field( 'stats_items' );

// Original classes before attempting utility refactor
$container_classes = 'flex flex-column lg:flex-row'; // As it was before
$image_col_classes = '';
$stats_col_classes = '';
$stats_grid_classes = 'grid grid-cols-2';

?>

<div class="<?php echo esc_attr( $class_name ); ?> <?php echo esc_attr( $align_class ); ?>"> <?php // Removed bg-primary py-8 rounded-lg ?>
    <div class="<?php echo esc_attr( $container_classes ); ?>"> <?php // Removed bg-white rounded-lg md:flex ?>

        <?php // Image Column ?>
        <?php if ( $image ) : ?>
            <div class="stats-block__image-col <?php echo esc_attr( $image_col_classes ); ?> bg-primary"> <?php // Added bg-primary for fallback ?>
                <?php echo wp_get_attachment_image( $image['ID'], 'large', false, array( 'class' => '' ) ); // Removed image utilities ?>
            </div>
        <?php endif; ?>

        <?php // Stats Column ?>
        <?php if ( $stats_items ) : ?>
            <div class="stats-block__stats-col <?php echo esc_attr( $stats_col_classes ); ?>"> <?php // Removed p-8 ?>
                <div class="stats-block__items-grid <?php echo esc_attr( $stats_grid_classes ); ?>"> <?php // Removed items-start gap-8 h-full ?>
                    <?php foreach ( $stats_items as $item ) :
                        $item_title = $item['stat_title'];
                        $blurb = $item['stat_blurb'];
                        ?>
                        <div class="stats-block__item">
                            <?php if ( $item_title ) : ?>
                                <h3 class="stats-block__item-title mt-0 mb-4"><?php echo esc_html( $item_title ); ?></h3> <?php // Removed text-4xl and font-serif utilities. Base H3 style applies. ?>
                            <?php endif; ?>
                            <?php if ( $blurb ) : ?>
                                <div class="stats-block__item-blurb text-base"><?php echo wp_kses_post( $blurb ); ?></div> <?php // Removed text utils ?>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

    </div> <?php // End container_classes div ?>

    <?php if ( $is_preview && ( ! $image && ! $stats_items ) ) : ?>
        <p class="p-4" style="font-style: italic; text-align: center;">Stats Block Preview: Add an image and stats content via ACF fields.</p>
    <?php endif; ?>
</div>
