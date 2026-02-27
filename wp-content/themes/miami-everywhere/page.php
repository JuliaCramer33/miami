<?php
/**
 * The template for displaying all pages
 *
 * @package MiamiEverywhere
 */

get_header();
?>

<?php get_template_part( 'template-parts/hero' ); ?>

<?php // Add the single scroll indicator line structure ?>
<div class="scroll-indicator-line" aria-hidden="true">
	<div class="scroll-indicator-line__inner"></div>
</div>

<?php
// Only include the intro section if there's content
if (get_field('intro_title') || get_field('intro_content')) :
    get_template_part('template-parts/intro');
endif;
?>

<div class="container">
	<div class="content-area">
		<?php if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<div class="entry-content">
						<?php the_content(); ?>
					</div>
				</article>
			<?php endwhile; ?>
		<?php else : ?>
			<p><?php esc_html_e( 'No content found.', 'miami-everywhere' ); ?></p>
		<?php endif; ?>
	</div>
</div>

<?php
get_footer();
