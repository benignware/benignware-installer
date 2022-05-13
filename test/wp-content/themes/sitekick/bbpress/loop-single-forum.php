<?php

/**
 * Forums Loop - Single Forum
 *
 * @package bbPress
 * @subpackage Theme
 */

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

?>
<div id="bbp-forum-<?php bbp_forum_id(); ?>" <?php bbp_forum_class( bbp_get_forum_id(), array( 'row g-0 border-bottom mb-4 pb-4 align-items-center' ) ); ?>>
	<div class="bbp-forum-info col-md-8">

		<?php if ( bbp_is_user_home() && bbp_is_subscriptions() ) : ?>

			<span class="bbp-row-actions">

				<?php do_action( 'bbp_theme_before_forum_subscription_action' ); ?>

				<?php bbp_forum_subscription_link( array( 'before' => '', 'subscribe' => '+', 'unsubscribe' => '&times;' ) ); ?>

				<?php do_action( 'bbp_theme_after_forum_subscription_action' ); ?>

			</span>

		<?php endif; ?>

		<?php do_action( 'bbp_theme_before_forum_title' ); ?>

		<h5>
			<a class="bbp-forum-title text-decoration-none" href="<?php bbp_forum_permalink(); ?>"><?php bbp_forum_title(); ?></a>
		</h5>

		<?php do_action( 'bbp_theme_after_forum_title' ); ?>

		<?php do_action( 'bbp_theme_before_forum_description' ); ?>

		<div class="bbp-forum-content text-muted"><?php bbp_forum_content(); ?></div>

		<?php do_action( 'bbp_theme_after_forum_description' ); ?>

		<?php /* do_action( 'bbp_theme_before_forum_sub_forums' ); */ ?>

		<?php /* bbp_list_forums(); */ ?>

		<?php /* do_action( 'bbp_theme_after_forum_sub_forums' ); */ ?>

		<?php bbp_forum_row_actions(); ?>

		</div>

	<div class="bbp-forum-topic-count col-md-1 text-center">
		<span class="lead"><?php bbp_forum_topic_count(); ?></span><br/>
		<span class="text-muted"><?php esc_html_e( 'Topics', 'bbpress' ); ?></span>
	</div>

	<div class="bbp-forum-reply-count col-md-1 text-center">
		<span class="lead"><?php bbp_show_lead_topic() ? bbp_forum_reply_count() : bbp_forum_post_count(); ?></span><br/>
		<span class="text-muted"><?php bbp_show_lead_topic()
				? esc_html_e( 'Replies', 'bbpress' )
				: esc_html_e( 'Posts',   'bbpress' );
			?></span>
	</div>

	<div class="bbp-forum-freshness col-md-2 text-center">

		<?php do_action( 'bbp_theme_before_forum_freshness_link' ); ?>

		<?php bbp_forum_freshness_link(); ?>

		<?php do_action( 'bbp_theme_after_forum_freshness_link' ); ?>

		<p class="bbp-topic-meta">

			<?php do_action( 'bbp_theme_before_topic_author' ); ?>

			<span class="bbp-topic-freshness-author"><?php bbp_author_link( array( 'post_id' => bbp_get_forum_last_active_id(), 'size' => 14 ) ); ?></span>

			<?php do_action( 'bbp_theme_after_topic_author' ); ?>

		</p>
	</div>
</div><!-- #bbp-forum-<?php bbp_forum_id(); ?> -->
