<?php

use function benignware\sitekick\get_icon;
use function benignware\sitekick\get_login_form;

// if (is_user_logged_in()) {
//   wp_redirect(get_permalink(get_option('woocommerce_myaccount_page_id')));
// }

/**
* Template Name: Login Page
*
* @package WordPress
* @subpackage Sitekick
* @since Sitekick 1.0
*/
$active_sidebar = true;

get_header(); ?>
<div class="container pt-4">
	<div class="row g-0 sidebar-container">
		<div class="<?= $active_sidebar ? 'col-lg-8 pe-4' : 'col-lg-12'; ?>">
			<?php if ( have_posts() ): ?>
				<div class="row g-4">
					<?php while ( have_posts() ): the_post(); ?>
						<div class="col-md-<?= get_theme_mod('blog_columns') ? (is_active_sidebar('sidebar-1') ? 6 : 4) : 12; ?>">
							<?php get_template_part( 'template-parts/content/content', get_theme_mod( 'blog_content', 'content' ) ); ?>
						</div>
					<?php endwhile; ?>
				</div>
			<?php else: ?>
				<h1><?= __('Sign in'); ?></h1>
			<?php endif; ?>
			<p>
				<?= sprintf( wp_kses( __( 'Haven\'t got an account yet? Sign up <a href="%s">here</a>.', 'site-kick' ), array(  'a' => array( 'href' => array() ) ) ), esc_url( wp_registration_url() ) ); ?>
			</p>
			<div class="row">
				<div class="col-md-8">
					<?= get_login_form([
						'redirect' => home_url()
					]); ?>
				</div>
			</div>
		</div>
		<?php if ($active_sidebar): ?>
			<?php get_template_part( 'template-parts/sidebar/sidebar-widgets' ); ?>
		<?php endif; ?>
	</div>
</div>
<?php get_footer();