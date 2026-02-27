<?php
/**
 * Template part for displaying the hero section
 *
 * @package Miami_Everywhere
 */

// Get the featured image
$featured_image = get_field('hero_image'); // Try ACF field first
if (!$featured_image) {
    $featured_image = get_the_post_thumbnail_url(get_the_ID(), 'full'); // Fallback to featured image
}

// Get the alt text
$featured_image_alt = '';
if (is_array($featured_image)) {
    $featured_image_alt = $featured_image['alt'];
    $featured_image = $featured_image['url'];
} else {
    $featured_image_alt = get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true);
}

// Get the page title
$page_title = get_the_title();

// Get the ACF page icon
$page_icon = get_field('page_icon');

// Get ACF button fields
$hero_button_link_obj = get_field('hero_button_link');
$display_hero_button  = false;
$link_url             = '#';
$link_title           = '';
$link_target          = '_self';
$link_text            = '';

if ( $hero_button_link_obj && ! empty( $hero_button_link_obj['url'] ) && ! empty( $hero_button_link_obj['title'] ) ) {
	$display_hero_button = true;
	$link_url            = esc_url( $hero_button_link_obj['url'] );
	$link_text           = esc_html( $hero_button_link_obj['title'] );
	$link_target         = ! empty( $hero_button_link_obj['target'] ) ? esc_attr( $hero_button_link_obj['target'] ) : '_self';
}

// Get optional hero subtitle
$hero_subtitle = get_field('hero_subtitle');
?>

<section class="hero" role="banner" aria-labelledby="hero-title">
    <?php if ($featured_image) : ?>
        <div class="hero__image-wrapper">
            <img
                src="<?php echo esc_url($featured_image); ?>"
                alt="<?php echo esc_attr($featured_image_alt); ?>"
                class="hero__image"
                <?php if (empty($featured_image_alt)) : ?>
                    role="presentation"
                    alt=""
                <?php endif; ?>
            >
            <div class="hero__overlay"></div>
        </div>
    <?php endif; ?>

    <div class="hero__content">
        <div class="hero__text-container">
            <div class="hero__title-wrapper">
                <?php if ($page_icon) : ?>
                    <div class="hero__icon">
                        <?php
                        // Handle ACF image field return format
                        if (is_array($page_icon)) {
                            echo wp_get_attachment_image($page_icon['ID'], 'thumbnail', false,
                                array('alt' => '', 'role' => 'presentation'));
                        } else {
                            // Fallback for direct ID
                            echo wp_get_attachment_image($page_icon, 'thumbnail', false,
                                array('alt' => '', 'role' => 'presentation'));
                        }
                        ?>
                    </div>
                <?php endif; ?>
                <div class="hero__title-container">
                    <?php if ($page_title) : ?>
                        <?php
                        // Define allowed tags for wp_kses
                        $allowed_tags = array(
                            'br' => array(),
                        );
                        // Decode entities *before* sanitizing
                        $decoded_title = html_entity_decode( $page_title );
                        ?>
                        <h1 id="hero-title" class="hero__title"><?php echo wp_kses( $decoded_title, $allowed_tags ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></h1>
                    <?php endif; ?>

                    <?php if ( $display_hero_button ) : ?>
                        <a href="<?php echo $link_url; ?>" class="button button--primary hero__button" target="<?php echo $link_target; ?>">
                            <?php echo $link_text; ?>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>
