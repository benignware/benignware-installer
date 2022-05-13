<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Benignware
 * @subpackage sitekick
 * @since 1.0.0
 */

?>
CONTENT ARCHIVE
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php if ( ! is_front_page() ) : ?>
		<header class="entry-header alignwide container">
			<?php get_template_part( 'template-parts/header/entry-header' ); ?>
			<?php /* sitekick_post_thumbnail(); */ ?>
		</header>
	<?php elseif ( has_post_thumbnail() ) : ?>
		<header class="entry-header alignwide container">
			<?php /* sitekick_post_thumbnail(); */ ?>
		</header>
	<?php endif; ?>

	<div class="entry-content container">
		<?php
		the_content();

		wp_link_pages(
			array(
				'before'   => '<nav class="page-links" aria-label="' . esc_attr__( 'Page', 'sitekick' ) . '">',
				'after'    => '</nav>',
				/* translators: %: page number. */
				'pagelink' => esc_html__( 'Page %', 'sitekick' ),
			)
		);
		?>
	</div><!-- .entry-content -->

	<?php if ( get_edit_post_link() ) : ?>
		<footer class="entry-footer default-max-width container">
			<?php
			edit_post_link(
				sprintf(
					/* translators: %s: Name of current post. Only visible to screen readers. */
					esc_html__( 'Edit %s', 'sitekick' ),
					'<span class="screen-reader-text">' . get_the_title() . '</span>'
				),
				'<span class="edit-link">',
				'</span>'
			);
			?>
		</footer><!-- .entry-footer -->
	<?php endif; ?>
</article><!-- #post-<?php the_ID(); ?> -->
