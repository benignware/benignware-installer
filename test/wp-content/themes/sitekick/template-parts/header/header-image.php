<?php
/**
 * Displays header media
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */
?>
<?php if (is_front_page() && is_home()): ?>
	<div class="custom-header bg-dark position-relative">
		<?php if (has_header_image()): ?>
			<div class="custom-header-media">
				<?php the_custom_header_markup(); ?>
			</div>
		<?php endif; ?>
		<?php get_template_part( 'template-parts/header/site', 'branding' ); ?>
	</div><!-- .custom-header -->
<?php endif;