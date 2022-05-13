<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Benignware
 * @subpackage sitekick
 * @since 1.0.0
 */

get_header(); ?>

<?php if ( have_posts() ): ?>
	<?php while ( have_posts() ): the_post(); ?>
		<?php get_template_part( 'template-parts/content/content-single'); ?>
		<?php if ( is_attachment() ): ?>
			<?php
				// Parent post navigation.
				the_post_navigation(
					array(
						/* translators: %s: parent post link. */
						'prev_text' => sprintf( __( '<span class="meta-nav">Published in</span><span class="post-title">%s</span>', 'sitekick' ), '%title' ),
					)
				);
			?>
		<?php endif; ?>
	<?php endwhile; ?>
<?php else: ?>
	<?php get_template_part( 'template-parts/content/content-none' ); ?>
<?php endif; ?>

<?php get_footer();
