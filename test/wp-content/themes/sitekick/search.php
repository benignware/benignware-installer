<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package Benignware
 * @subpackage sitekick
 * @since 1.0.0
 */

get_header(); ?>

<?php if ( have_posts() ): ?>
	<div class="search-results container">
		<div class="row">
			<div class="col-md-<?= is_active_sidebar('sidebar-1') ? '8' : '12'; ?>">
				<?php if ( have_posts() ): ?>
					<header class="page-header alignwide">
					<div class="container">
						<h1 class="page-title">
							<?php
							printf(
								/* translators: %s: search term. */
								esc_html__( 'Results for "%s"', 'sitekick' ),
								'<span class="page-description search-term">' . esc_html( get_search_query() ) . '</span>'
							);
							?>
						</h1>
					</div>
				</header><!-- .page-header -->

				<div class="search-result-count default-max-width container">
					<?php
					printf(
						esc_html(
							/* translators: %d: the number of search results. */
							_n(
								'We found %d result for your search.',
								'We found %d results for your search.',
								(int) $wp_query->found_posts,
								'sitekick'
							)
						),
						(int) $wp_query->found_posts
					);
					?>
				</div><!-- .search-result-count -->
					<div class="row">
						<?php while ( have_posts() ): the_post(); ?>
							<div class="col col-md-<?= is_active_sidebar('sidebar-1') ? '12' : '6'; ?>">
								<?php get_template_part( 'template-parts/content/content-excerpt', get_post_format() ); ?>
							</div>
						<?php endwhile; ?>
					</div>
				<?php else: ?>
					<?php get_template_part( 'template-parts/content/content-none' ); ?>
				<?php endif; ?>
			</div>
			<?php if (is_active_sidebar('sidebar-1')): ?>
				<?php get_template_part( 'template-parts/sidebar/sidebar-widgets' ); ?>
			<?php endif; ?>
		</div>
	</div>
<?php else: get_template_part( 'template-parts/content/content-none' ); ?>
<?php endif; ?>

<?php get_footer();
