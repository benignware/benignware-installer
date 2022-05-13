<?php
/**
 * Displays the post header
 *
 * @package Benignware
 * @subpackage sitekick
 * @since 1.0.0
 */

// Don't show the title if the post-format is `aside` or `status`.
$post_format = get_post_format();
if ( 'aside' === $post_format || 'status' === $post_format ) {
	return;
}
?>

<header class="entry-header">
	<?php
	the_title( sprintf( '<h2 class="entry-title card-title default-max-width h4"><a class="text-decoration-none" href="%s">', esc_url( get_permalink() ) ), '</a></h2>' );
	?>
</header><!-- .entry-header -->
