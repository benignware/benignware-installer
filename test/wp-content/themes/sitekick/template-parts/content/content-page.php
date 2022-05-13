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

// print_r($wp_query->query_vars);
// CONTENT PAGE: <?= get_the_ID(); ?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header alignwide">
		<?php if (has_post_thumbnail()) : ?>
			<div class="post-thumbnail">
				<a href="<?php the_permalink(); ?>">
					<?php the_post_thumbnail('post-thumbnail', array('class' => 'mb-0 w-100') ); ?>
				</a>
			</div><!-- .post-thumbnail -->
		<?php endif; ?>
		<?php if (!is_front_page() && !is_home()): ?>
			<div class="page-header py-4 border-bottom mb-4">
				<div class="container">
					<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
					<?php if ( has_excerpt() ) : // Only show custom excerpts not autoexcerpts ?>
						<div class="entry-subtitle lead"><?php echo get_the_excerpt(); ?></div>
					<?php endif; ?>
				</div>
			</div>
		<?php endif; ?>
	</header>

	<div class="container my-4">
		<div class="row g-0 sidebar-container">
			<div class="<?= is_active_sidebar('sidebar-1') ? 'col-lg-8 pe-4' : 'col-lg-12'; ?>">
				<div class="entry-content">
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
			</div>
			<?php if (is_active_sidebar('sidebar-1')): ?>
				<?php get_template_part( 'template-parts/sidebar/sidebar-widgets' ); ?>
			<?php endif; ?>
		</div>
	</div>
</article><!-- #post-${ID} -->

<?php
/*

global $wp_query;

if (get_post_type() && is_post_type_archive()): ?>
	<div class="container">
		<?php
			global $wp_query;
			$wp_query = new WP_Query(array(
				'post_type' => get_queried_object()->name
			));

			$archive_post_type = is_archive() ? get_queried_object()->name : null;

			while ( have_posts() ) :
				the_post();
				get_template_part( 'template-parts/content/content' );
			endwhile; // End of the loop.

			wp_reset_query();
		?>
	</div>
<?php endif; ?>
*/