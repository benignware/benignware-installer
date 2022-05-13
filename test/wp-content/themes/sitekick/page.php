<?php
use function benignware\sitekick\has_submenu;

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
		<?php get_template_part( 'template-parts/content/content-page' ); ?>
	<?php endwhile; ?>
<?php else: ?>
	<?php get_template_part( 'template-parts/content/content-none' ); ?>
<?php endif; ?>

<?php get_footer();



