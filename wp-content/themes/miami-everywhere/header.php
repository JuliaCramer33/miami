<?php
/**
 * The template for displaying the header.
 *
 * @package MiamiEverywhere
 */

use MiamiEverywhere\Classes\Navigation;

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<?php wp_head(); ?>
	</head>
	<body <?php body_class(); ?>>
		<?php wp_body_open(); ?>

		<a href="#main" class="skip-link sr-only"><?php esc_html_e( 'Skip to main content', 'miami-everywhere' ); ?></a>

		<div class="site">
			<header class="site-header bg-primary text-white" role="banner">
				<div class="site-header__inner container flex items-center justify-between">
					<div class="site-branding">
						<?php if ( has_custom_logo() ) : ?>
							<div class="site-header__logo">
								<?php the_custom_logo(); ?>
							</div>
						<?php endif; ?>
					</div>

					<button class="site-header__nav-toggle" aria-controls="main-navigation" aria-expanded="false">
						<span class="screen-reader-text"><?php esc_html_e( 'Menu', 'miami-everywhere' ); ?></span>
						<span></span>
					</button>

					<nav class="main-navigation fixed inset-0 bg-primary text-white overflow-y-auto -translate-x-full transition-transform duration-300 ease-in-out md:relative md:inset-auto md:transform-none md:p-0 md:flex md:flex-row md:items-start md:justify-start md:flex-nowrap md:w-auto md:translate-x-0" role="navigation" aria-label="<?php esc_attr_e( 'Main Navigation', 'miami-everywhere' ); ?>">
						<?php Navigation::nav_menu( 'primary', array(
							'menu_class' => 'main-navigation__list flex flex-col w-full md:flex-row md:flex-nowrap md:w-auto md:justify-start',
							'menu_item_class' => 'main-navigation__item flex items-center w-auto md:mx-4 md:whitespace-nowrap md:flex-shrink-0',
							'link_class' => 'main-navigation__link block text-white uppercase relative md:whitespace-nowrap hover:text-warm-white transition-colors md:after:content-[""] md:after:absolute md:after:bottom-0 md:after:left-0 md:after:h-0.5 md:after:w-0 md:after:bg-white md:after:transition-all md:hover:after:w-full'
						) ); ?>

						<div class="mobile-menu-extras mt-8 md:hidden">
							<?php
							// Main Campus Menu
							if ( has_nav_menu( 'main-campus' ) ) : ?>
								<div class="main-campus-menu-container border-t border-b border-white/40 my-4 py-4">
									<?php Navigation::nav_menu( 'main-campus', array(
										'menu_class' => 'list-none m-0 mb-8 p-0',
									) ); ?>
								</div>
							<?php endif; ?>

							<?php
							// Social Menu
							if ( has_nav_menu( 'social' ) ) : ?>
								<div class="mobile-nav-social mt-auto pt-4">
									<p class="text-sm font-medium tracking-wider uppercase mb-6 text-white">FOLLOW US</p>
									<?php
									Navigation::nav_menu('social', array(
										'menu_class' => 'social-menu flex flex-wrap gap-4 list-none m-0 p-0 w-full justify-start'
									));
									?>
								</div>
							<?php endif; ?>
						</div>
					</nav>
				</div>
			</header>

			<div class="site-title bg-light-tan py-4">
				<div class="container">
					<div class="flex flex-row items-center justify-start w-full">
						<?php if ( get_bloginfo( 'name' ) ) : ?>
							<span class="font-sans text-base font-bold leading-tight text-text"><?php bloginfo( 'name' ); ?></span>
						<?php endif; ?>
						<?php if ( get_bloginfo( 'description' ) ) : ?>
							<span class="font-serif text-base leading-normal text-text-light italic ml-2"><?php echo esc_html( get_bloginfo( 'description' ) ); ?></span>
						<?php endif; ?>
					</div>
				</div>
			</div>

			<main id="main" class="site-main" role="main" tabindex="-1">
