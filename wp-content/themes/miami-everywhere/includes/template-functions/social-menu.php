<?php
/**
 * Social Menu Functions
 *
 * @package Miami_Everywhere
 */

namespace MiamiEverywhere\TemplateFunctions;

/**
 * Display social links menu
 *
 * @param array $args Optional. Arguments to pass to wp_nav_menu().
 */
function social_menu( $args = array() ) {
	$defaults = array(
		'theme_location' => 'social',
		'menu_class'     => 'social-menu',
		'container'      => 'nav',
		'container_class' => 'social-navigation',
		'depth'          => 1,
		'link_before'    => '',
		'link_after'     => '',
		'fallback_cb'    => '',
		'walker'         => new \MiamiEverywhere\Classes\Social_Menu_Walker(),
	);

	$args = wp_parse_args( $args, $defaults );

	if ( has_nav_menu( 'social' ) ) {
		wp_nav_menu( $args );
	}
}

/**
 * Display social links menu in mobile navigation
 */
function social_menu_mobile() {
	if ( has_nav_menu( 'social' ) ) {
		echo '<div class="mobile-social-menu-container">';
		social_menu( array(
			'container_class' => 'social-navigation-mobile',
			'menu_class'     => 'social-menu social-menu-mobile',
		) );
		echo '</div>';
	}
}
