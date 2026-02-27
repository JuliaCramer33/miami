<?php
/**
 * The main template file
 *
 * @package MiamiEverywhere
 */

get_header();
?>

<?php get_template_part( 'template-parts/content/page-title' ); ?>

<div class="container">
	<div class="content-area">
		<?php if ( have_posts() ) : ?>
			<div class="posts-list">
				<?php while ( have_posts() ) : the_post(); ?>
					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<header class="entry-header">
							<h2 class="entry-title">
								<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
							</h2>

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
						</header>

						<div class="entry-content">
							<?php the_excerpt(); ?>
						</div>

						<footer class="entry-footer">
							<a href="<?php the_permalink(); ?>" class="read-more">
								<?php esc_html_e( 'Read More', 'miami-everywhere' ); ?>
								<span class="screen-reader-text">
									<?php
									/* translators: %s: post title */
									printf( esc_html__( 'about %s', 'miami-everywhere' ), get_the_title() );
									?>
								</span>
							</a>
						</footer>
					</article>
				<?php endwhile; ?>
			</div>

			<?php
			the_posts_pagination(
				array(
					'prev_text' => esc_html__( 'Previous', 'miami-everywhere' ),
					'next_text' => esc_html__( 'Next', 'miami-everywhere' ),
				)
			);
			?>

		<?php else : ?>
			<p><?php esc_html_e( 'No posts found.', 'miami-everywhere' ); ?></p>
		<?php endif; ?>
	</div>
</div>

<?php
get_footer();
