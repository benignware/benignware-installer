<?php

/**
 * Forums Loop
 *
 * @package bbPress
 * @subpackage Theme
 */

// Exit if accessed directly
defined( 'ABSPATH' ) || exit; ?>

<?php do_action( 'bbp_template_before_forums_loop' ); ?>

<div id="forums-list-<?php bbp_forum_id(); ?>" class="bbp-forums" style="clear: both">

	<!-- <div class="bbp-header">

		<div class="forum-titles row">
			<div class="bbp-forum-info col-md-8"><?php esc_html_e( 'Forum', 'bbpress' ); ?></div>
			<div class="bbp-forum-topic-count col-md-1 text-center"><?php esc_html_e( 'Topics', 'bbpress' ); ?></div>
			<div class="bbp-forum-reply-count col-md-1 text-center"><?php bbp_show_lead_topic()
				? esc_html_e( 'Replies', 'bbpress' )
				: esc_html_e( 'Posts',   'bbpress' );
			?></div>
			<div class="bbp-forum-freshness col-md-2 text-center"><?php esc_html_e( 'Last Post', 'bbpress' ); ?></div>
	</div> -->

	</div><!-- .bbp-header -->

	<div class="bbp-body">

		<?php while ( bbp_forums() ) : bbp_the_forum(); ?>

			<?php bbp_get_template_part( 'loop', 'single-forum' ); ?>

		<?php endwhile; ?>

	</div><!-- .bbp-body -->

	<div class="bbp-footer">
		<div class="tr">
			<p class="td colspan4">&nbsp;</p>
		</div><!-- .tr -->

	</div><!-- .bbp-footer -->

</div><!-- .forums-directory -->

<?php do_action( 'bbp_template_after_forums_loop' );
