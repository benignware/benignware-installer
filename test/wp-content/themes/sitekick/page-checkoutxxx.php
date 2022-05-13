<?php
/**
 * The template for displaying checkout page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Benignware
 * @subpackage sitekick
 * @since 1.0.0
 */

get_header(); ?>
<?php if (has_post_thumbnail()) : ?>
	<div class="post-thumbnail">
		<a href="<?php the_permalink(); ?>">
			<?php the_post_thumbnail('post-thumbnail', array('class' => 'mb-0 w-100') ); ?>
		</a>
	</div><!-- .post-thumbnail -->
<?php endif; ?>

<div class="container my-4">
  <?php
    /* Start the Loop */
    while ( have_posts() ) :
      the_post();
      get_template_part( 'template-parts/content/content-page' );

      // If comments are open or there is at least one comment, load up the comment template.
      if ( comments_open() || get_comments_number() ) {
        comments_template();
      }
    endwhile; // End of the loop.
  ?>
</div>

<?php get_footer();


