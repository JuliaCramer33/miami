<?php
/**
 * Navigation class
 *
 * @package MiamiEverywhere
 */

namespace MiamiEverywhere\Classes;

/**
 * Navigation class
 */
class Navigation {
	/**
	 * Display a custom navigation menu
	 *
	 * @param string $theme_location Theme location to display.
	 * @param array  $args           Additional arguments for wp_nav_menu.
	 * @return void
	 */
	public static function nav_menu( $theme_location = 'primary', $args = array() ) {
		$defaults = array(
			'theme_location' => $theme_location,
			'menu_id'        => $theme_location . '-menu',
			'menu_class'     => $theme_location . '-menu nav',
			'container'      => false,
			'fallback_cb'    => false,
		);

		$args = wp_parse_args( $args, $defaults );

		// Add classes to menu items (<li>)
		if (!empty($args['add_li_class']) || !empty($args['menu_item_class'])) {
			add_filter('nav_menu_css_class', function($classes, $item, $args) {
				if (!empty($args->add_li_class)) {
					$classes[] = $args->add_li_class;
				}
				if (!empty($args->menu_item_class)) {
					$classes[] = $args->menu_item_class;
				}
				return $classes;
			}, 10, 3);
		}

		// Add classes to links (<a>)
		if (!empty($args['add_a_class']) || !empty($args['link_class'])) {
			add_filter('nav_menu_link_attributes', function($atts, $item, $args) {
				$new_classes = [];
				if (!empty($args->add_a_class)) {
					$new_classes[] = $args->add_a_class;
				}
				if (!empty($args->link_class)) {
					$new_classes[] = $args->link_class;
				}

				if (!empty($new_classes)) {
					$atts['class'] = isset($atts['class'])
						? $atts['class'] . ' ' . implode(' ', $new_classes)
						: implode(' ', $new_classes);
				}
				return $atts;
			}, 10, 3);
		}

		wp_nav_menu( $args );

		// Remove the filters after the menu is rendered
		remove_all_filters('nav_menu_css_class');
		remove_all_filters('nav_menu_link_attributes');
	}

	/**
	 * Enable CSS Classes field in menu admin
	 *
	 * @return void
	 */
	public static function enable_menu_css_classes() {
		add_filter('wp_nav_menu_item_custom_fields', function () {
			return true;
		});
	}
}
