<?php
/**
 * Miami Everywhere functions and definitions
 *
 * @package MiamiEverywhere
 */

namespace MiamiEverywhere;

// Use statements for included classes/namespaces
use MiamiEverywhere\Setup\Setup;
use MiamiEverywhere\Blocks\Block_Loader;
use MiamiEverywhere\Classes\Classes;
use MiamiEverywhere\PostTypes\Testimonials;

// Autoloader for theme classes - MUST BE INCLUDED EARLY
if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
	require_once __DIR__ . '/vendor/autoload.php';
} else {
	// Optional: Add an admin notice if autoloader is missing
	add_action('admin_notices', function() {
		echo '<div class="notice notice-error"><p><strong>Miami Everywhere Theme Error:</strong> Composer autoloader not found. Please run <code>composer install</code> in the theme directory.</p></div>';
	});
	// Prevent further execution if critical classes won't load
	return;
}

// Define theme constants
define( 'MIAMI_EVERYWHERE_VERSION', '1.0.0' );
define( 'MIAMI_EVERYWHERE_TEMPLATE_PATH', get_template_directory() );
define( 'MIAMI_EVERYWHERE_PATH', get_template_directory_uri() );
define( 'MIAMI_EVERYWHERE_MINIMUM_PHP_VERSION', '7.4' );

/**
 * Load includes
 * Array of PROCEDURAL files to include. Classes handled by Composer Autoloader.
 *
 * @var array
 */
$includes = array(
	// Core Setup & Theme Features (Procedural)
	'/includes/Setup/theme-setup.php',
	'/includes/Setup/overrides.php',
	'/includes/Setup/admin-features.php',
	'/includes/Setup/customizer.php',

	// Blocks (Procedural registration files)
	'/includes/Blocks/blocks.php',            // Contains category registration
	'/includes/Blocks/styles.php',            // Block style registrations

	// ACF Field Definitions (Procedural)
	'/includes/acf/page-options.php',
	'/includes/acf/testimonial-fields.php',

	// Frontend Functionality (Procedural)
	'/includes/ajax/ajax-handlers.php', // Corrected filename
);

// Loop to include only the necessary procedural files
foreach ( $includes as $file ) {
	$filepath = MIAMI_EVERYWHERE_TEMPLATE_PATH . $file;
	if ( file_exists( $filepath ) ) {
		require_once $filepath;
	} else {
		// trigger_error( sprintf( 'Error locating %s for inclusion.', $file ), E_USER_WARNING );
	}
}

// Initialize hooks (Relying on autoloader now)
add_action( 'admin_init', array( Setup::class, 'check_php_version' ) );
add_action( 'after_setup_theme', array( Setup::class, 'add_editor_styles' ) );

// ADD THE NEW ACTION HOOK FOR THE NEW FUNCTION
add_action( 'wp_enqueue_scripts', 'MiamiEverywhere\miami_everywhere_enqueue_assets' );

/**
 * Enqueue scripts and styles directly.
 * Replicates logic from the removed Assets class.
 */
function miami_everywhere_enqueue_assets() {
    $theme_uri = get_template_directory_uri();
    $theme_path = get_template_directory();

    // --- TEMPORARY SIMPLIFICATION FOR DEBUGGING ---

    // --- Enqueue External Assets ---
    // Adobe Fonts (Keep this as a known dependency)
    wp_enqueue_style(
        'adobe-fonts',
        'https://use.typekit.net/xsd0pxk.css',
        array(),
        null
    );

    // ---
    // --- Asset File Paths ---
    $css_asset_path = $theme_path . '/dist/js/style.asset.php'; // Look for style asset where build places it (in js dir)
    $js_asset_path = $theme_path . '/dist/js/main.asset.php';  // Correct location

    // --- Default Asset Values ---
    $css_asset = [
        'version'      => '1.0.0', // Default
        'dependencies' => ['adobe-fonts']
    ];
    $js_asset = [
        'version'      => '1.0.0', // Default
        'dependencies' => ['wp-element', 'jquery'] // Assuming wp-element might be needed by build?
    ];

    // --- Load CSS Asset File ---
    if (file_exists($css_asset_path)) {
        $asset_data = include $css_asset_path;
        if (is_array($asset_data) && isset($asset_data['dependencies']) && isset($asset_data['version'])) {
            $css_asset = $asset_data;
        }
    } else {
         // error_log('Miami Theme: CSS asset file not found: ' . $css_asset_path);
    }

    // --- Load JS Asset File ---
    if (file_exists($js_asset_path)) {
        $asset_data = include $js_asset_path;
        if (is_array($asset_data) && isset($asset_data['dependencies']) && isset($asset_data['version'])) {
            $js_asset = $asset_data;
        }
    } else {
        // error_log('Miami Theme: JS asset file not found: ' . $js_asset_path);
    }

    // --- Dependency Checks (Ensure required defaults are present) ---
    if (!in_array('adobe-fonts', $css_asset['dependencies'])) {
        $css_asset['dependencies'][] = 'adobe-fonts';
    }
    if (!in_array('jquery', $js_asset['dependencies'])) {
        $js_asset['dependencies'][] = 'jquery';
    }
    // ---

    // --- Enqueue Splide Assets (REMOVED - Now imported via SCSS) ---
    /*
    // Splide Core CSS
    $splide_core_css_path = '/dist/vendor/splide/css/splide-core.min.css';
    if ( file_exists( $theme_path . $splide_core_css_path ) ) {
        wp_enqueue_style(
            'splide-core-css',
            $theme_uri . $splide_core_css_path,
            array(), // Core has no Splide dependencies
            filemtime( $theme_path . $splide_core_css_path )
        );
    } // Optional else log

    // Splide Theme CSS
    $splide_theme_css_path = '/dist/vendor/splide/css/splide.min.css';
    if ( file_exists( $theme_path . $splide_theme_css_path ) ) {
        wp_enqueue_style(
            'splide-theme-css',
            $theme_uri . $splide_theme_css_path,
            ['splide-core-css'], // Depends on the core Splide CSS
            filemtime( $theme_path . $splide_theme_css_path )
        );
    } // Optional else log
    */

    // --- Enqueue Main Theme Assets ---
    // Main Stylesheet
    $main_style_path = '/dist/css/style.css'; // Correct path based on dist structure
    if ( file_exists( $theme_path . $main_style_path ) ) {
        wp_enqueue_style(
            'miami-everywhere-style',
            $theme_uri . $main_style_path,
            // Use dependencies from CSS asset file, ensure Adobe Fonts is included
            array_unique(array_merge($css_asset['dependencies'], ['adobe-fonts'])),
            $css_asset['version'] // Use version from CSS asset file
        );
    } else {
         // error_log('Miami Theme: style.css not found at ' . $theme_path . $main_style_path);
    }

    // Main Script
    $main_js_path = '/dist/js/main.js';
    if ( file_exists( $theme_path . $main_js_path ) ) {
        wp_enqueue_script(
            'miami-everywhere-main',
            $theme_uri . $main_js_path,
            array_unique($js_asset['dependencies']), // Reverted - Use dependencies from JS asset file (currently empty)
            $js_asset['version'], // Use version from JS asset file
            true // Load in footer
        );
    } else {
        // error_log('Miami Theme: main.js not found at ' . $theme_path . $main_js_path);
    }

    // --- Localize Script & Comment Reply (Keep these) ---
    wp_localize_script(
        'miami-everywhere-main',
        'miamiAjax',
        array(
            'ajaxUrl' => admin_url( 'admin-ajax.php' ),
            'nonce'   => wp_create_nonce( 'testimonial_modal_nonce' )
        )
    );
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }

    // Removed debug echo
}

/**
 * Wrapper function for backward compatibility or simpler template usage
 */
function miami_everywhere_nav_menu( $theme_location = 'primary', $args = array() ) {
	if ( class_exists( \MiamiEverywhere\Classes\Navigation::class ) && method_exists( \MiamiEverywhere\Classes\Navigation::class, 'nav_menu' ) ) {
		\MiamiEverywhere\Classes\Navigation::nav_menu( $theme_location, $args );
	}
}

// Initialize block loader
if ( class_exists( Block_Loader::class ) ) {
	Block_Loader::init();
}

// Instantiate Post Types to trigger registration hooks
if ( class_exists( Testimonials::class ) ) {
    new Testimonials();
}

/**
 * Dynamically populate ACF select field choices from taxonomy terms.
 *
 * @param array $field The field settings.
 * @return array Modified field settings.
 */
function populate_acf_select_from_taxonomy( $field ) {
    // Only target specific fields if needed, otherwise apply to all fields using this filter
    // if ( $field['key'] !== 'field_your_target_field_key' ) return $field;

    // Ensure taxonomy exists
    if ( ! taxonomy_exists( 'story_type' ) ) {
        return $field;
    }

    // Get taxonomy terms
    $terms = get_terms( array(
        'taxonomy'   => 'story_type',
        'hide_empty' => false, // Include terms even if they haven't been used yet
        'orderby'    => 'name',
        'order'      => 'ASC',
    ) );

    // Check for errors or no terms
    if ( is_wp_error( $terms ) || empty( $terms ) ) {
        return $field;
    }

    // Format terms for ACF choices (value => label)
    $choices = array();
    foreach ( $terms as $term ) {
        $choices[ $term->slug ] = $term->name;
    }

    // Populate the field choices
    $field['choices'] = $choices;

    return $field;
}

// Hook for the 'Story Type' field within the Testimonial CPT repeater
add_filter( 'acf/load_field/key=field_66219f7c1b2c4', 'MiamiEverywhere\populate_acf_select_from_taxonomy' );

// Hook for the 'Story Type to Display' field within the Related Stories block settings repeater
add_filter( 'acf/load_field/key=field_related_story_type', 'MiamiEverywhere\populate_acf_select_from_taxonomy' );
