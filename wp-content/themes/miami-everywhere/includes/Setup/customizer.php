<?php
/**
 * Theme Customizer
 *
 * @package MiamiEverywhere
 */

namespace MiamiEverywhere\Setup\Customizer;

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param \WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function customize_register( $wp_customize ) {
	// Add Footer Settings Section
	$wp_customize->add_section(
		'footer_settings',
		array(
			'title'    => __( 'Footer Settings', 'miami-everywhere' ),
			'priority' => 120,
		)
	);

	// Add Address Setting
	$wp_customize->add_setting(
		'footer_address',
		array(
			'default'           => '',
			'sanitize_callback' => 'wp_kses_post',
			'transport'         => 'postMessage',
		)
	);

	// Add Address Control
	$wp_customize->add_control(
		'footer_address',
		array(
			'label'       => __( 'Footer Address', 'miami-everywhere' ),
			'section'     => 'footer_settings',
			'type'        => 'textarea',
		)
	);

	// Add Phone Number Setting
	$wp_customize->add_setting(
		'footer_phone_number',
		array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'postMessage',
		)
	);

	// Add Phone Number Control
	$wp_customize->add_control(
		'footer_phone_number',
		array(
			'label'       => __( 'Footer Phone Number', 'miami-everywhere' ),
			'section'     => 'footer_settings',
			'type'        => 'text',
		)
	);
}
add_action( 'customize_register', __NAMESPACE__ . '\customize_register' ); 
