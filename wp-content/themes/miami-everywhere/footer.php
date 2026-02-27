<?php
/**
 * The template for displaying the footer.
 *
 * @package MiamiEverywhere
 */

use MiamiEverywhere\Classes\Navigation;

?>
			</main><!-- #main -->

			<footer class="site-footer bg-primary text-white" role="contentinfo">
				<!-- Main Footer Section -->
				<div class="container pt-16 pb-16">
					<div class="footer-grid">
						<!-- Column 1: Logo -->
						<div class="footer-logo">
							<?php
							$footer_logo = get_custom_logo();
							if ($footer_logo) {
								echo wp_kses_post($footer_logo);
							} else {
								echo '<div class="site-footer__brand">' . esc_html(get_bloginfo('name')) . '</div>';
							}
							?>
						</div>

						<!-- Column 2: Navigation -->
						<div class="footer-nav">
							<h4 class="footer-column-title"><?php esc_html_e('Navigation', 'miami-everywhere'); ?></h4>
							<?php
							if (has_nav_menu('footer')) {
								Navigation::nav_menu('footer', array(
									'menu_class' => 'footer-menu',
									'menu_item_class' => 'footer-menu__item',
									'link_class' => 'footer-menu__link',
									'depth' => 1,
								));
							}
							?>
						</div>

						<!-- Column 3: Social Links -->
						<div class="footer-social">
							<h4 class="footer-column-title"><?php esc_html_e('Follow Us', 'miami-everywhere'); ?></h4>
							<?php
							if (has_nav_menu('social')) : ?>
								<?php Navigation::nav_menu('social', array(
									'menu_class' => 'social-menu',
									'menu_item_class' => 'social-menu__item',
									'link_class' => 'social-menu__link'
								)); ?>
							<?php endif; ?>

							<?php
							$footer_address = get_theme_mod( 'footer_address' );
							$footer_phone   = get_theme_mod( 'footer_phone_number' );
							?>
							<div class="footer-contact-info mt-8">
								<h4 class="footer-column-title mb-4"><?php esc_html_e( 'Miami University', 'miami-everywhere' ); ?></h4>
								<?php if ( ! empty( $footer_address ) ) : ?>
									<address class="not-italic text-sm leading-relaxed">
										<?php echo wp_kses_post( nl2br( $footer_address ) ); ?>
									</address>
								<?php endif; ?>
								<?php if ( ! empty( $footer_phone ) ) : ?>
									<a href="<?php echo esc_url( 'tel:' . preg_replace( '/[^\d+]/', '', $footer_phone ) ); ?>" class="block mt-4 text-sm">
										<?php echo esc_html( $footer_phone ); ?>
									</a>
								<?php endif; ?>
							</div>
						</div>
					</div>
				</div>

				<!-- Footer Utility Section -->
				<div class="footer-utility bg-accent pt-6 pb-6">
					<div class="container max-w-[600px] mx-auto">
						<?php if (has_nav_menu('footer-utility')) : ?>
							<?php
							Navigation::nav_menu('footer-utility', array(
								'menu_class' => 'footer-utility__menu',
								'depth' => 1,
							));
							?>
						<?php endif; ?>
					</div>
				</div>

				<!-- Copyright Section -->
				<div class="footer-copyright bg-black py-4">
					<div class="container">
						<p class="text-sm text-white text-center">&copy; <?php echo esc_html(gmdate('Y')); ?> <?php echo esc_html(get_bloginfo('name')); ?>. <?php esc_html_e('All rights reserved.', 'miami-everywhere'); ?></p>
					</div>
				</div>
			</footer>
		</div><!-- .site -->

		<?php get_template_part('template-parts/modal', 'testimonial'); // Include Modal HTML ?>
		<?php wp_footer(); ?>
	</body>
</html>
