<?php

use function benignware\sitekick\get_post_title_class;
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Benignware
 * @subpackage sitekick
 * @since 1.0.0
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header alignwide">
		<?php if (has_post_thumbnail()) : ?>
			<div class="post-thumbnail">
				<a href="<?php the_permalink(); ?>">
					<?php the_post_thumbnail('post-thumbnail', array('class' => 'mb-0 w-100') ); ?>
				</a>
			</div><!-- .post-thumbnail -->
		<?php endif; ?>
		<div class="page-header py-4 border-bottom mb-4">
			<div class="container">
				<?php the_title( sprintf('<h1 class="%s">', get_post_title_class()), '</h1>' ); ?>
			</div>
		</div>
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

				<footer class="entry-footer default-max-width">
					<?php /*sitekick_entry_meta_footer(); */?>
				</footer><!-- .entry-footer -->
			</div>

			<?php if (is_active_sidebar('sidebar-1')): ?>
				<?php get_template_part( 'template-parts/sidebar/sidebar-widgets' ); ?>
			<?php endif; ?>
		</div>
	</div>
</article><!-- #post-${ID} -->
