<?php
/**
 * Template part for displaying post archives and search results
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Benignware
 * @subpackage sitekick
 * @since 1.0.0
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class('card'); ?>>
	<?php if (is_search() || !get_theme_mod('blog_columns', get_post_type() !== 'post')): ?>
		<div class="row g-0">
			<div class="col-md-4">
	<?php endif; ?>
	<?php if (has_post_thumbnail() && ! is_single()) : ?>
		<a href="<?php the_permalink(); ?>">
			<?php the_post_thumbnail( 'large', array('class' => 'card-img-top mb-0') ); ?>
		</a>
	<?php endif; ?>
	<?php if (is_search() || !get_theme_mod('blog_columns', get_post_type() !== 'post')): ?>
		</div>
		<div class="col-md-8">
	<?php endif; ?>
	<div class="card-body">
		<?php get_template_part( 'template-parts/header/excerpt-header', get_post_format() ); ?>
		<div class="card-text">
			<?php get_template_part( 'template-parts/excerpt/excerpt', get_post_format() ); ?>
		</div>
	</div><!-- .entry-content -->
	<?php if (is_search() || !get_theme_mod('blog_columns', get_post_type() !== 'post')): ?>
		</div>
	<?php endif; ?>
	<footer class="entry-footer default-max-width container">
		<?php /* sitekick_entry_meta_footer(); */ ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-${ID} -->
