<?php
/**
 * Template part for displaying the page title
 *
 * @package MiamiEverywhere
 */

?>

<div class="page-title">
	<div class="container">
		<div class="page-title__content">
			<?php if ( is_front_page() && is_home() ) : ?>
				<h1 class="page-title__heading"><?php bloginfo( 'name' ); ?></h1>
				<?php if ( get_bloginfo( 'description' ) ) : ?>
					<p class="page-title__description"><?php bloginfo( 'description' ); ?></p>
				<?php endif; ?>
			<?php elseif ( is_front_page() ) : ?>
				<h1 class="page-title__heading"><?php bloginfo( 'name' ); ?></h1>
				<?php if ( get_bloginfo( 'description' ) ) : ?>
					<p class="page-title__description"><?php bloginfo( 'description' ); ?></p>
				<?php endif; ?>
			<?php elseif ( is_home() ) : ?>
				<h1 class="page-title__heading"><?php single_post_title(); ?></h1>
			<?php elseif ( is_search() ) : ?>
				<h1 class="page-title__heading">
					<?php
					/* translators: %s: search query */
					printf( esc_html__( 'Search Results for: %s', 'miami-everywhere' ), '<span>' . get_search_query() . '</span>' );
					?>
				</h1>
			<?php elseif ( is_archive() ) : ?>
				<h1 class="page-title__heading">
					<?php
					if ( is_category() ) {
						single_cat_title();
					} elseif ( is_tag() ) {
						single_tag_title();
					} elseif ( is_author() ) {
						the_post();
						/* translators: %s: author name */
						printf( esc_html__( 'Author: %s', 'miami-everywhere' ), '<span class="vcard">' . get_the_author() . '</span>' );
						rewind_posts();
					} elseif ( is_day() ) {
						/* translators: %s: day */
						printf( esc_html__( 'Day: %s', 'miami-everywhere' ), '<span>' . get_the_date() . '</span>' );
					} elseif ( is_month() ) {
						/* translators: %s: month */
						printf( esc_html__( 'Month: %s', 'miami-everywhere' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'miami-everywhere' ) ) . '</span>' );
					} elseif ( is_year() ) {
						/* translators: %s: year */
						printf( esc_html__( 'Year: %s', 'miami-everywhere' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'miami-everywhere' ) ) . '</span>' );
					} elseif ( is_tax( 'post_format' ) ) {
						if ( is_tax( 'post_format', 'post-format-aside' ) ) {
							esc_html_e( 'Asides', 'miami-everywhere' );
						} elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) {
							esc_html_e( 'Galleries', 'miami-everywhere' );
						} elseif ( is_tax( 'post_format', 'post-format-image' ) ) {
							esc_html_e( 'Images', 'miami-everywhere' );
						} elseif ( is_tax( 'post_format', 'post-format-video' ) ) {
							esc_html_e( 'Videos', 'miami-everywhere' );
						} elseif ( is_tax( 'post_format', 'post-format-quote' ) ) {
							esc_html_e( 'Quotes', 'miami-everywhere' );
						} elseif ( is_tax( 'post_format', 'post-format-link' ) ) {
							esc_html_e( 'Links', 'miami-everywhere' );
						} elseif ( is_tax( 'post_format', 'post-format-status' ) ) {
							esc_html_e( 'Statuses', 'miami-everywhere' );
						} elseif ( is_tax( 'post_format', 'post-format-audio' ) ) {
							esc_html_e( 'Audios', 'miami-everywhere' );
						} elseif ( is_tax( 'post_format', 'post-format-chat' ) ) {
							esc_html_e( 'Chats', 'miami-everywhere' );
						}
					} elseif ( is_post_type_archive() ) {
						post_type_archive_title();
					} else {
						the_archive_title();
					}
					?>
				</h1>
				<?php the_archive_description( '<div class="page-title__description">', '</div>' ); ?>
			<?php elseif ( is_404() ) : ?>
				<h1 class="page-title__heading"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'miami-everywhere' ); ?></h1>
			<?php else : ?>
				<?php
				// Define allowed tags for wp_kses
				$allowed_tags = array(
					'br' => array(),
				);
				// Decode entities *before* sanitizing
				$title_raw = get_the_title();
				$decoded_title = html_entity_decode( $title_raw );
				?>
				<h1 class="page-title__heading"><?php echo wp_kses( $decoded_title, $allowed_tags ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></h1>
			<?php endif; ?>
		</div>
	</div>
</div>
