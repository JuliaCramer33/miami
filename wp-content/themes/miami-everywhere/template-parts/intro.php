<?php
/**
 * Template part for displaying the intro section
 *
 * @package Miami_Everywhere
 */

$intro_title = get_field('intro_title');
$intro_content = get_field('intro_content');
$intro_cta = get_field('intro_cta');
$intro_bg_color = get_field('intro_background_color');

// Prepare inline style string
$intro_style = $intro_bg_color ? 'style="background-color: ' . esc_attr($intro_bg_color) . ';"' : '';

?>

<section class="intro" <?php echo $intro_style; ?>>
    <div class="intro__inner">
        <div class="intro__icon-wrapper">
            <img class="intro__line-end-icon"
                 src="<?php echo esc_url( get_template_directory_uri() . '/dist/images/icons/meta-icon.svg' ); ?>"
                 alt=""
                 aria-hidden="true">
        </div>
        <div class="intro__text-container js-fade-in">
            <?php if ($intro_title) : ?>
                <h2 class="intro__title"><?php echo esc_html($intro_title); ?></h2>
            <?php endif; ?>

            <?php if ($intro_content) : ?>
                <div class="intro__content">
                    <?php echo wp_kses_post($intro_content); ?>
                </div>
            <?php endif; ?>

            <?php if ($intro_cta) : ?>
                <div class="intro__cta">
                    <a href="<?php echo esc_url($intro_cta['url']); ?>"
                       class="button"
                       <?php echo $intro_cta['target'] ? 'target="' . esc_attr($intro_cta['target']) . '"' : ''; ?>>
                        <?php echo esc_html($intro_cta['title']); ?>
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
