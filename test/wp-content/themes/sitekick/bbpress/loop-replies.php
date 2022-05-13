<?php

/**
 * Replies Loop
 *
 * @package bbPress
 * @subpackage Theme
 */

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

do_action( 'bbp_template_before_replies_loop' ); ?>

<div id="topic-<?php bbp_topic_id(); ?>-replies" class="forums bbp-replies">

	<div class="bbp-header row g-0 d-none">
		<div class="bbp-reply-author col-md-2"><?php esc_html_e( 'Author',  'bbpress' ); ?></div><!-- .bbp-reply-author -->
		<div class="bbp-reply-content col-md-10"><?php bbp_show_lead_topic()
			? esc_html_e( 'Replies', 'bbpress' )
			: esc_html_e( 'Posts',   'bbpress' );
		?></div><!-- .bbp-reply-content -->
	</div><!-- .bbp-header -->

	<div class="bbp-body">

		<?php if ( bbp_thread_replies() ) : ?>
			<?php bbp_list_replies(); ?>

		<?php else : ?>

			<?php while ( bbp_replies() ) : bbp_the_reply(); ?>
				<?php bbp_get_template_part( 'loop', 'single-reply' ); ?>

			<?php endwhile; ?>

		<?php endif; ?>

	</div><!-- .bbp-body -->

	<div class="bbp-footer d-none">
		<div class="bbp-reply-author"><?php esc_html_e( 'Author',  'bbpress' ); ?></div>
		<div class="bbp-reply-content"><?php bbp_show_lead_topic()
			? esc_html_e( 'Replies', 'bbpress' )
			: esc_html_e( 'Posts',   'bbpress' );
		?></div><!-- .bbp-reply-content -->
	</div><!-- .bbp-footer -->
</div><!-- #topic-<?php bbp_topic_id(); ?>-replies -->

<?php do_action( 'bbp_template_after_replies_loop' );
