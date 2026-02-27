<?php
/**
 * This file contains hooks and functions that override the behavior of WP Core.
 *
 * @package MiamiEverywhere
 */

namespace MiamiEverywhere\Overrides;

/**
 * Registers instances where we will override default WP Core behavior.
 *
 * @link https://developer.wordpress.org/reference/functions/print_emoji_detection_script/
 * @link https://developer.wordpress.org/reference/functions/print_emoji_styles/
 * @link https://developer.wordpress.org/reference/functions/wp_staticize_emoji/
 * @link https://developer.wordpress.org/reference/functions/wp_staticize_emoji_for_email/
 * @link https://developer.wordpress.org/reference/functions/wp_generator/
 * @link https://developer.wordpress.org/reference/functions/wlwmanifest_link/
 * @link https://developer.wordpress.org/reference/functions/rsd_link/
 *
 * @return void
 */
function setup() {
	// Remove the Emoji detection script.
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );

	// Remove inline Emoji detection script.
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );

	// Remove Emoji-related styles from front end and back end.
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );

	// Remove Emoji-to-static-img conversion.
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );

	add_filter( 'tiny_mce_plugins', __NAMESPACE__ . '\disable_emojis_tinymce' );
	add_filter( 'wp_resource_hints', __NAMESPACE__ . '\disable_emoji_dns_prefetch', 10, 2 );

	// Remove WordPress generator meta.
	remove_action( 'wp_head', 'wp_generator' );
	// Remove Windows Live Writer manifest link.
	remove_action( 'wp_head', 'wlwmanifest_link' );
	// Remove the link to Really Simple Discovery service endpoint.
	remove_action( 'wp_head', 'rsd_link' );

}

/**
 * Filter function used to remove the TinyMCE emoji plugin.
 *
 * @link https://developer.wordpress.org/reference/hooks/tiny_mce_plugins/
 *
 * @param  array $plugins An array of default TinyMCE plugins.
 * @return array          An array of TinyMCE plugins, without wpemoji.
 */
function disable_emojis_tinymce( $plugins ) {
	if ( is_array( $plugins ) && in_array( 'wpemoji', $plugins, true ) ) {
		return array_diff( $plugins, array( 'wpemoji' ) );
	}

	return $plugins;
}

/**
 * Remove emoji CDN hostname from DNS prefetching hints.
 *
 * @link https://developer.wordpress.org/reference/hooks/emoji_svg_url/
 *
 * @param  array  $urls          URLs to print for resource hints.
 * @param  string $relation_type The relation type the URLs are printed for.
 * @return array                 Difference betwen the two arrays.
 */
function disable_emoji_dns_prefetch( $urls, $relation_type ) {
	if ( 'dns-prefetch' === $relation_type ) {
		/** This filter is documented in wp-includes/formatting.php */
		$emoji_svg_url = apply_filters( 'emoji_svg_url', 'https://s.w.org/images/core/emoji/2/svg/' );

		$urls = array_values( array_diff( $urls, array( $emoji_svg_url ) ) );
	}

	return $urls;
}

/**
 * Modify the custom logo HTML to link to miamioh.edu and open in a new tab.
 *
 * This function is hooked into 'get_custom_logo' to alter the output of the_custom_logo().
 * It changes the link to a hardcoded URL and ensures it opens in a new tab.
 *
 * @param string $html The original HTML for the custom logo.
 * @return string The modified HTML for the custom logo.
 */
function miami_everywhere_change_logo_link( $html ) {
	$doc = new \DOMDocument();
	// Wrap the HTML in a div to make it a valid document for parsing.
	// Suppress errors and use UTF-8 encoding.
	@$doc->loadHTML( '<div>' . mb_convert_encoding( $html, 'HTML-ENTITIES', 'UTF-8' ) . '</div>', LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD );

	$link = $doc->getElementsByTagName( 'a' )->item( 0 );

	if ( $link ) {
		// If the link already exists, just modify its attributes.
		$link->setAttribute( 'href', 'https://miamioh.edu' );
		$link->setAttribute( 'target', '_blank' );
		$link->setAttribute( 'rel', 'noopener noreferrer' );
	} else {
		// If there is no link (like on the homepage), create one and wrap the image.
		$image = $doc->getElementsByTagName( 'img' )->item( 0 );
		if ( $image ) {
			$new_link = $doc->createElement( 'a' );
			$new_link->setAttribute( 'href', 'https://miamioh.edu' );
			$new_link->setAttribute( 'target', '_blank' );
			$new_link->setAttribute( 'rel', 'noopener noreferrer' );

			// Move the image inside the new link.
			$new_link->appendChild( $image );
			// Add the new link to the document.
			$doc->getElementsByTagName( 'div' )->item( 0 )->appendChild( $new_link );
		}
	}

	// Extract the HTML from the wrapper div.
	$body     = $doc->getElementsByTagName( 'div' )->item( 0 );
	$new_html = '';
	if ( $body ) {
		foreach ( $body->childNodes as $child ) {
			$new_html .= $doc->saveHTML( $child );
		}
	} else {
		return $html; // Fallback to original html if something went wrong.
	}

	return $new_html;
}
add_filter( 'get_custom_logo', __NAMESPACE__ . '\\miami_everywhere_change_logo_link' );
