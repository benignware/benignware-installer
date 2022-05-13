<?php

/**
 * Single Topic Lead Content Part
 *
 * @package bbPress
 * @subpackage Theme
 */

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

do_action( 'bbp_template_before_lead_topic' ); ?>

<div id="bbp-topic-<?php bbp_topic_id(); ?>-lead" class="bbp-lead-topic">

	<div class="bbp-header row">

		<div class="bbp-topic-author"><?php esc_html_e( 'Creator',  'bbpress' ); ?></div><!-- .bbp-topic-author -->

		<div class="bbp-topic-content">

			<?php esc_html_e( 'Topic', 'bbpress' ); ?>

		</div><!-- .bbp-topic-content -->

</div><!-- .bbp-header -->

	<div class="bbp-body">

		<div class="bbp-topic-header">

			<div class="bbp-meta">

				<span class="bbp-topic-post-date"><?php bbp_topic_post_date(); ?></span>

				<a href="<?php bbp_topic_permalink(); ?>" class="bbp-topic-permalink">#<?php bbp_topic_id(); ?></a>

				<?php do_action( 'bbp_theme_before_topic_admin_links' ); ?>

				<?php bbp_topic_admin_links(); ?>

				<?php do_action( 'bbp_theme_after_topic_admin_links' ); ?>

			</div><!-- .bbp-meta -->

		</div><!-- .bbp-topic-header -->

		<div id="post-<?php bbp_topic_id(); ?>" <?php bbp_topic_class(bbp_get_topic_id(), array( 'row g-0 border-bottom my-4 align-items-center' )); ?>>

			<div class="bbp-topic-author col-md-3">

				<?php do_action( 'bbp_theme_before_topic_author_details' ); ?>

				<?php bbp_topic_author_link( array( 'show_role' => true ) ); ?>

				<?php if ( current_user_can( 'moderate', bbp_get_reply_id() ) ) : ?>

					<?php do_action( 'bbp_theme_before_topic_author_admin_details' ); ?>

					<div class="bbp-topic-ip"><?php bbp_author_ip( bbp_get_topic_id() ); ?></div>

					<?php do_action( 'bbp_theme_after_topic_author_admin_details' ); ?>

				<?php endif; ?>

				<?php do_action( 'bbp_theme_after_topic_author_details' ); ?>

			</div><!-- .bbp-topic-author -->

			<div class="bbp-topic-content col-md-9">

				<?php do_action( 'bbp_theme_before_topic_content' ); ?>

				<?php bbp_topic_content(); ?>

				<?php do_action( 'bbp_theme_after_topic_content' ); ?>

			</div><!-- .bbp-topic-content -->

		</div><!-- #post-<?php bbp_topic_id(); ?> -->

	</div><!-- .bbp-body -->

	<div class="bbp-footer">

		<div class="bbp-topic-author"><?php esc_html_e( 'Creator',  'bbpress' ); ?></div>

		<div class="bbp-topic-content">

			<?php esc_html_e( 'Topic', 'bbpress' ); ?>

		</div><!-- .bbp-topic-content -->

	</div>

</div><!-- #bbp-topic-<?php bbp_topic_id(); ?>-lead -->

<?php do_action( 'bbp_template_after_lead_topic' );
