<?php
use function benignware\sitekick\get_icon;
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Benignware
 * @subpackage sitekick
 * @since 1.0.0
 */

get_header();
?>
<header class="page-header py-4 mb-4 border-bottom">
	<div class="container">
		<?php the_archive_title( '<h1 class="page-title">', '</h1>' ); ?>
		<?php if ( get_the_archive_description() ) : ?>
			<p class="archive-description"><?php echo wp_kses_post( wpautop( get_the_archive_description() ) ); ?></p>
		<?php endif; ?>
	</div>
</header><!-- .page-header -->

<div class="container">
	<div class="row g-0 sidebar-container">
		<div class="<?= is_active_sidebar('sidebar-1') ? 'col-lg-8 pe-4' : 'col-lg-12'; ?>">
			<?php if ( have_posts() ): ?>
				<div class="row g-4">
					<?php while ( have_posts() ): the_post(); ?>
						<div class="col-md-<?= get_theme_mod('blog_columns', get_post_type() !== 'post') ? (is_active_sidebar('sidebar-1') ? 6 : 4) : 12; ?>">
							<?php get_template_part( 'template-parts/content/content', get_theme_mod( 'blog_content', 'excerpt' ) ); ?>
						</div>
					<?php endwhile; ?>
				</div>
				<nav class="my-4">
					<?php
						the_posts_pagination( array(
							'prev_text' => get_icon( 'angle-left' ) . '<span class="screen-reader-text">' . __( 'Previous page', 'twentyseventeen' ) . '</span>',
							'next_text' => '<span class="screen-reader-text">' . __( 'Next page', 'twentyseventeen' ) . '</span>' . get_icon('angle-right'),
							'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'twentyseventeen' ) . ' </span>',
							'after_page_number' => '',
							'type' => 'list'
						) );
					?>
				</nav>
			<?php else: ?>
				<?php get_template_part( 'template-parts/content/content-none' ); ?>
			<?php endif; ?>
		</div>
		<?php if (is_active_sidebar('sidebar-1')): ?>
			<?php get_template_part( 'template-parts/sidebar/sidebar-widgets' ); ?>
		<?php endif; ?>
	</div>
</div>

<?php get_footer(); ?>
