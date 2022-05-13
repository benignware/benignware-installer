<?php

use function benignware\sitekick\get_icon;

if (is_user_logged_in()) {
  wp_redirect(get_permalink(get_option('woocommerce_myaccount_page_id')));
}

/**
* Template Name: Registration Page
*
* @package WordPress
* @subpackage Sitekick
* @since Sitekick 1.0
*/
get_header(); ?>

<div class="container pt-4">
	<div class="row g-0 sidebar-container">
		<div class="<?= is_active_sidebar('sidebar-1') ? 'col-lg-8 pe-4' : 'col-lg-12'; ?>">
			<?php if ( have_posts() ): ?>
				<div class="row g-4">
					<?php while ( have_posts() ): the_post(); ?>
						<div class="col-md-<?= get_theme_mod('blog_columns') ? (is_active_sidebar('sidebar-1') ? 6 : 4) : 12; ?>">
							<?php get_template_part( 'template-parts/content/content', get_theme_mod( 'blog_content', 'content' ) ); ?>
						</div>
					<?php endwhile; ?>
				</div>
			<?php else: ?>
				<h1><?= __('Registration'); ?></h1>
			<?php endif; ?>
			<p>
				<?= sprintf( wp_kses( __( 'Already signed up? Login <a href="%s">here</a>.', 'site-kick' ), array(  'a' => array( 'href' => array() ) ) ), esc_url( wp_login_url() ) ); ?>
			</p>
			<?php echo do_shortcode('[sitekick_wc_reg_form]'); ?>
		</div>
		<?php if (is_active_sidebar('sidebar-1')): ?>
			<?php get_template_part( 'template-parts/sidebar/sidebar-widgets' ); ?>
		<?php endif; ?>
	</div>
</div>
<?php get_footer();