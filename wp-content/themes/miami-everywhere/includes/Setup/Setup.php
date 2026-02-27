<?php
/**
 * Setup class
 *
 * @package MiamiEverywhere
 */

namespace MiamiEverywhere\Setup;

/**
 * Setup class
 */
class Setup {
	/**
	 * Initialize the setup
	 */
	public static function init() {
		add_action( 'after_setup_theme', array( __CLASS__, 'setup' ) );
		add_action( 'customize_register', array( __CLASS__, 'customize_register' ) );
	}

	/**
	 * Check PHP version
	 *
	 * @return void
	 */
	public static function check_php_version() {
		if ( version_compare( PHP_VERSION, '7.4', '<' ) ) {
			add_action( 'admin_notices', array( __CLASS__, 'php_version_notice' ) );
		}
	}

	/**
	 * Add editor styles for Gutenberg
	 *
	 * @return void
	 */
	public static function add_editor_styles() {
		add_theme_support('editor-styles');
		add_editor_style( 'assets/css/editor-style.css' );
	}

	/**
	 * Register customizer settings
	 *
	 * @param WP_Customize_Manager $wp_customize Customizer manager instance.
	 */
	public static function customize_register( $wp_customize ) {
		// Add setting for theme title
		$wp_customize->add_setting(
			'theme_title',
			array(
				'default'           => '',
				'sanitize_callback' => 'sanitize_text_field',
			)
		);

		// Add control for theme title
		$wp_customize->add_control(
			'theme_title',
			array(
				'label'    => __( 'Theme Title', 'miami-everywhere' ),
				'section'  => 'title_tagline',
				'type'     => 'text',
				'priority' => 20,
			)
		);

		// Add setting for theme tagline
		$wp_customize->add_setting(
			'theme_tagline',
			array(
				'default'           => '',
				'sanitize_callback' => 'sanitize_text_field',
			)
		);

		// Add control for theme tagline
		$wp_customize->add_control(
			'theme_tagline',
			array(
				'label'    => __( 'Theme Tagline', 'miami-everywhere' ),
				'section'  => 'title_tagline',
				'type'     => 'text',
				'priority' => 30,
			)
		);
	}

	/**
	 * Display PHP version notice
	 */
	public static function php_version_notice() {
		?>
		<div class="notice notice-error">
			<p>
				<?php
				printf(
					/* translators: %s: PHP version */
					esc_html__( 'Miami Everywhere requires PHP version %s or higher. Please contact your hosting provider to upgrade PHP.', 'miami-everywhere' ),
					'7.4'
				);
				?>
			</p>
		</div>
		<?php
	}
}
