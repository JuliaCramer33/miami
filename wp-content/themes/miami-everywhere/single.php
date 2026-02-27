<?php
/**
 * The template for displaying all single posts
 *
 * @package MiamiEverywhere
 */

get_header();
?>

<?php get_template_part( 'template-parts/content/page-title' ); ?>

<div class="container">
	<div class="content-area">
		<?php if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<?php if ( 'post' === get_post_type() ) : ?>
						<div class="entry-meta">
							<span class="posted-on">
								<?php
								echo sprintf(
									/* translators: %s: post date */
									esc_html__( 'Posted on %s', 'miami-everywhere' ),
									'<time datetime="' . esc_attr( get_the_date( 'c' ) ) . '">' . esc_html( get_the_date() ) . '</time>'
								);
								?>
							</span>
							<span class="byline">
								<?php
								echo sprintf(
									/* translators: %s: post author */
									esc_html__( 'by %s', 'miami-everywhere' ),
									'<span class="author vcard"><a href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
								);
								?>
							</span>
						</div>
					<?php endif; ?>

					<div class="entry-content">
						<?php the_content(); ?>
					</div>

					<footer class="entry-footer">
						<?php
						// Display categories and tags
						$categories_list = get_the_category_list( esc_html__( ', ', 'miami-everywhere' ) );
						if ( $categories_list ) {
							printf( '<span class="cat-links">' . esc_html__( 'Categories: %1$s', 'miami-everywhere' ) . '</span>', $categories_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
						}

						$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'miami-everywhere' ) );
						if ( $tags_list ) {
							printf( '<span class="tags-links">' . esc_html__( 'Tags: %1$s', 'miami-everywhere' ) . '</span>', $tags_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
						}
						?>
					</footer>
				</article>

				<?php
				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;
				?>

				<nav class="navigation post-navigation">
					<h2 class="screen-reader-text"><?php esc_html_e( 'Post navigation', 'miami-everywhere' ); ?></h2>
					<div class="nav-links">
						<?php
						previous_post_link( '<div class="nav-previous">%link</div>', esc_html__( '← Previous Post', 'miami-everywhere' ) );
						next_post_link( '<div class="nav-next">%link</div>', esc_html__( 'Next Post →', 'miami-everywhere' ) );
						?>
					</div>
				</nav>
			<?php endwhile; ?>
		<?php else : ?>
			<p><?php esc_html_e( 'No posts found.', 'miami-everywhere' ); ?></p>
		<?php endif; ?>
	</div>
</div>

<?php
get_footer();
