<?php

/**
 * Topics Loop - Single
 *
 * @package bbPress
 * @subpackage Theme
 */

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

?>

<div id="bbp-topic-<?php bbp_topic_id(); ?>" <?php bbp_topic_class(bbp_get_topic_id(), array( 'row g-0 border-bottom my-4 align-items-center' )); ?>>
	<div class="bbp-topic-title col-md-8">

		<?php if ( bbp_is_user_home() ) : ?>

			<?php if ( bbp_is_favorites() ) : ?>

				<span class="bbp-row-actions">

					<?php do_action( 'bbp_theme_before_topic_favorites_action' ); ?>

					<?php bbp_topic_favorite_link( array( 'before' => '', 'favorite' => '+', 'favorited' => '&times;' ) ); ?>

					<?php do_action( 'bbp_theme_after_topic_favorites_action' ); ?>

				</span>

			<?php elseif ( bbp_is_subscriptions() ) : ?>

				<span class="bbp-row-actions">

					<?php do_action( 'bbp_theme_before_topic_subscription_action' ); ?>

					<?php bbp_topic_subscription_link( array( 'before' => '', 'subscribe' => '+', 'unsubscribe' => '&times;' ) ); ?>

					<?php do_action( 'bbp_theme_after_topic_subscription_action' ); ?>

				</span>

			<?php endif; ?>

		<?php endif; ?>

		<?php do_action( 'bbp_theme_before_topic_title' ); ?>

		<h5>
			<a class="bbp-topic-permalink text-decoration-none" href="<?php bbp_topic_permalink(); ?>"><?php bbp_topic_title(); ?></a>
		</h5>

		<?php do_action( 'bbp_theme_after_topic_title' ); ?>

		<?php bbp_topic_pagination(); ?>

		<?php do_action( 'bbp_theme_before_topic_meta' ); ?>

		<p class="bbp-topic-meta text-muted">

			<?php do_action( 'bbp_theme_before_topic_started_by' ); ?>

			<span class="bbp-topic-started-by"><?php printf( esc_html__( 'Started by %1$s', 'bbpress' ), bbp_get_topic_author_link( array( 'size' => '14', 'type' => 'name' ) ) ); ?></span>

			<?php do_action( 'bbp_theme_after_topic_started_by' ); ?>

			<?php if ( ! bbp_is_single_forum() || ( bbp_get_topic_forum_id() !== bbp_get_forum_id() ) ) : ?>

				<?php do_action( 'bbp_theme_before_topic_started_in' ); ?>

				<span class="bbp-topic-started-in"><?php printf( esc_html__( 'in: %1$s', 'bbpress' ), '<a href="' . bbp_get_forum_permalink( bbp_get_topic_forum_id() ) . '">' . bbp_get_forum_title( bbp_get_topic_forum_id() ) . '</a>' ); ?></span>
				<?php do_action( 'bbp_theme_after_topic_started_in' ); ?>

			<?php endif; ?>

		</p>

		<?php do_action( 'bbp_theme_after_topic_meta' ); ?>

		<?php bbp_topic_row_actions(); ?>

	</div>

	<div class="bbp-topic-voice-count col-md-1 text-center">
		<span class="lead"><?php bbp_topic_voice_count(); ?></span><br/>
		<span class="text-muted"><?php esc_html_e( 'Voices', 'bbpress' ); ?></span>
	</div>

	<div class="bbp-forum-reply-count col-md-1 text-center">
		<span class="lead"><?php bbp_show_lead_topic() ? bbp_topic_reply_count() : bbp_topic_post_count(); ?></span><br/>
		<span class="text-muted"><?php bbp_show_lead_topic()
				? esc_html_e( 'Replies', 'bbpress' )
				: esc_html_e( 'Posts',   'bbpress' );
			?></span>
	</div>

	<div class="bbp-topic-freshness col-md-2 text-center">

		<?php do_action( 'bbp_theme_before_topic_freshness_link' ); ?>

		<?php bbp_topic_freshness_link(); ?>

		<?php do_action( 'bbp_theme_after_topic_freshness_link' ); ?>

		<p class="bbp-topic-meta">

			<?php do_action( 'bbp_theme_before_topic_freshness_author' ); ?>

			<span class="bbp-topic-freshness-author">
				<?php printf( esc_html__( 'by %1$s', 'bbpress' ), bbp_get_topic_author_link( array( 'size' => 14, 'type' => 'name' ) ) ); ?>
			</span>

			<?php do_action( 'bbp_theme_after_topic_freshness_author' ); ?>

		</p>
	</div>
</div><!-- #bbp-topic-<?php bbp_topic_id(); ?> -->
