<?php
/**
 * Theme Setup
 *
 * @package MiamiEverywhere
 */

namespace MiamiEverywhere\Setup;

/**
 * Set up theme defaults and register support for various WordPress features.
 */
function theme_setup() {
    // Essential WordPress features
    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'customize-selective-refresh-widgets' );

    // HTML5 support for specific elements
    add_theme_support(
        'html5',
        array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
            'script',
            'style',
            'navigation-widgets', // Added from a duplicate declaration
        )
    );

    // Editor and Block Editor features
    add_theme_support( 'align-wide' );
    add_theme_support( 'responsive-embeds' );
    add_theme_support( 'editor-styles' );
    add_editor_style( 'dist/css/editor-style.css' );
    add_theme_support( 'wp-block-styles' );

    // Customizer features
    add_theme_support(
        'custom-logo',
        array(
            'height'      => 100,
            'width'       => 400,
            'flex-width'  => true,
            'flex-height' => true,
            'unlink-homepage-logo' => true,
        )
    );
    // Note: add_theme_support( 'custom-background' ); // Consider if truly needed
    // Note: add_theme_support( 'custom-header' );   // Consider if truly needed

    // Gutenberg custom features (if your theme explicitly uses these PHP flags)
    // add_theme_support( 'custom-spacing' );
    // add_theme_support( 'custom-line-height' );
    // add_theme_support( 'custom-units' );
    // add_theme_support( 'custom-font-sizes' ); // Often handled via theme.json or editor-styles
    // add_theme_support( 'custom-color' );     // Often handled via theme.json or editor-styles

    // Post Formats (if used by the theme)
    add_theme_support( 'post-formats', array(
        'aside',
        'image',
        'video',
        'quote',
        'link',
        'gallery',
        'status',
        'audio',
        'chat',
    ) );

    // Register nav menus.
    register_nav_menus(
        array(
            'primary' => esc_html__('Primary Menu', 'miami-everywhere'),
            'footer' => esc_html__('Footer Menu', 'miami-everywhere'),
            'footer-utility' => esc_html__('Footer Utility Menu', 'miami-everywhere'),
            'main-campus' => esc_html__('Main Campus Menu', 'miami-everywhere'),
            'social' => esc_html__('Social Links Menu', 'miami-everywhere'),
        )
    );
}
add_action( 'after_setup_theme', __NAMESPACE__ . '\theme_setup' );

/**
 * Set the content width in pixels.
 */
function content_width() {
    $GLOBALS['content_width'] = apply_filters( 'miami_everywhere_content_width', 1200 );
}
add_action( 'after_setup_theme', __NAMESPACE__ . '\content_width', 0 );

/**
 * Register widget area.
 */
function widgets_init() {
    register_sidebar(
        array(
            'name'          => __( 'Footer Widget Area', 'miami-everywhere' ),
            'id'            => 'footer-1',
            'description'   => __( 'Add widgets here to appear in your footer.', 'miami-everywhere' ),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        )
    );
}
add_action( 'widgets_init', __NAMESPACE__ . '\widgets_init' );

// Note: The lines for `custom-spacing`, `custom-line-height`, etc., are commented out.
// These are often better managed via theme.json in modern WordPress themes or might not be needed
// if your theme doesn't leverage these specific PHP flags for block editor features.
// Review if these are actively used or if their functionality is handled elsewhere (e.g., theme.json, editor SCSS).

/**
 * Add SVG support for uploads.
 *
 * @param array $mimes Current allowed mime types.
 * @return array Modified mime types.
 */
function miami_everywhere_mime_types( $mimes ) {
	$mimes['svg'] = 'image/svg+xml';
	$mimes['svgz'] = 'image/svg+xml';
	return $mimes;
}
add_filter( 'upload_mimes', __NAMESPACE__ . '\miami_everywhere_mime_types' );

/**
 * Fix SVG thumbnail display in media library.
 */
function miami_everywhere_fix_svg_thumb_display() {
	echo '<style type="text/css">
		/* Ensure SVG thumbnails are not distorted in the media library grid view */
		.attachment-266x266.size-266x266.wp-thumbnail-icon img[src$="svg"],
		.attachment-100x100.size-100x100.wp-thumbnail-icon img[src$="svg"],
		.attachment-thumbnail.size-thumbnail.wp-thumbnail-icon img[src$="svg"],
		.media-modal-content .attachment-details img[src$="svg"] {
			width: 100% !important;
			height: auto !important;
		}
		/* Fix for SVG in the Customizer logo preview */
		.customize-control-site_logo .custom-logo-link img[src$="svg"] {
			width: auto;
			max-width: 100%;
			height: auto;
		}
	</style>';
}
add_action( 'admin_head', __NAMESPACE__ . '\miami_everywhere_fix_svg_thumb_display' );
