<?php
/**
 * Template Name: Guide Template
 * Template Post Type: page
 *
 * This template provides a clean layout for guide pages,
 * omitting the standard hero and intro sections.
 *
 * @package MiamiEverywhere
 */

get_header();
?>

<?php // NOTE: Hero and Intro sections are intentionally omitted for this template. ?>

<div class="container" style="margin-top: 4rem; margin-bottom: 4rem;"> <?php // Add some top/bottom margin to compensate for removed sections ?>
	<div class="content-area">
		<?php if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<?php // Optional: Add the page title if desired for guide pages ?>
					<?php /* <h1 class="entry-title"><?php the_title(); ?></h1> */ ?>
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
