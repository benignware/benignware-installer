<?php

/**
 * Topics Loop
 *
 * @package bbPress
 * @subpackage Theme
 */

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

do_action( 'bbp_template_before_topics_loop' ); ?>

<div id="bbp-forum-<?php bbp_forum_id(); ?>" class="bbp-topics">
	<!-- <div class="bbp-header">
		<div class="forum-titles row">
			<div class="bbp-topic-title col-md-8"><?php esc_html_e( 'Topic', 'bbpress' ); ?></div>
			<div class="bbp-topic-voice-count col-md-1 text-center"><?php esc_html_e( 'Voices', 'bbpress' ); ?></div>
			<div class="bbp-topic-reply-count col-md-1 text-center"><?php bbp_show_lead_topic()
				? esc_html_e( 'Replies', 'bbpress' )
				: esc_html_e( 'Posts',   'bbpress' );
			?></div>
			<div class="bbp-topic-freshness col-md-2 text-center"><?php esc_html_e( 'Last Post', 'bbpress' ); ?></div>
		</div>
	</div> -->

	<div class="bbp-body">

		<?php while ( bbp_topics() ) : bbp_the_topic(); ?>

			<?php bbp_get_template_part( 'loop', 'single-topic' ); ?>

		<?php endwhile; ?>

	</div>

	<div class="bbp-footer">
		<div class="tr">
			<p>
				<span class="td colspan<?php echo ( bbp_is_user_home() && ( bbp_is_favorites() || bbp_is_subscriptions() ) ) ? '5' : '4'; ?>">&nbsp;</span>
			</p>
		</div><!-- .tr -->
	</div>
</div><!-- #bbp-forum-<?php bbp_forum_id(); ?> -->

<?php do_action( 'bbp_template_after_topics_loop' );
