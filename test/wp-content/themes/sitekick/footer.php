<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Benignware
 * @subpackage sitekick
 * @since 1.0.0
 */

?>
			</main><!-- #main -->
		</section><!-- #primary -->
	</div><!-- #content -->
</div><!-- #page -->

<?php // get_template_part( 'template-parts/footer/footer-widgets' ); ?>

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="navbar navbar-<?= get_theme_mod('colorscheme', 'light') ?> bg-<?= get_theme_mod('colorscheme', 'light') ?> navbar-expand-lg border-top">
			<div class="container">
				<ul aria-label="<?php esc_attr_e( 'Social menu', 'sitekick' ); ?>" class="footer-navigation-wrapper nav navbar-nav nav-horizontal">
					<?php
						wp_nav_menu(
							array(
								'theme_location' => 'social',
								'items_wrap'     => '%3$s',
								'container'      => false,
								'depth'          => 1,
								'link_before'    => '<span>',
								'link_after'     => '</span>',
								'fallback_cb'    => false,
							)
						);
					?>
				</ul>
				<ul aria-label="<?php esc_attr_e( 'Footer menu', 'sitekick' ); ?>" class="footer-navigation-wrapper nav navbar-nav">
					<?php
					wp_nav_menu(
						array(
							'theme_location' => 'footer',
							'items_wrap'     => '%3$s',
							'container'      => false,
							'depth'          => 1,
							'link_before'    => '<span>',
							'link_after'     => '</span>',
							'fallback_cb'    => false,
						)
					);
					?>
				</ul>
			</nav><!-- .footer-navigation -->
			
			<div class="site-info d-none">
				<div class="site-name">
					<?php if ( has_custom_logo() ) : ?>
						<div class="site-logo"><?php the_custom_logo(); ?></div>
					<?php else : ?>
						<?php if ( get_bloginfo( 'name' ) && get_theme_mod( 'display_title_and_tagline', true ) ) : ?>
							<?php if ( is_front_page() && ! is_paged() ) : ?>
								<?php bloginfo( 'name' ); ?>
							<?php else : ?>
								<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a>
							<?php endif; ?>
						<?php endif; ?>
					<?php endif; ?>
				</div><!-- .site-name -->
				<div class="powered-by">
					<?php
					printf(
						/* translators: %s: WordPress. */
						esc_html__( 'Proudly powered by %s.', 'sitekick' ),
						'<a href="' . esc_attr__( 'https://wordpress.org/', 'sitekick' ) . '">WordPress</a>'
					);
					?>
				</div><!-- .powered-by -->
			</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
