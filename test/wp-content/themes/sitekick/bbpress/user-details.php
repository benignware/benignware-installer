<?php

/**
 * User Details
 *
 * @package bbPress
 * @subpackage Theme
 */

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

do_action( 'bbp_template_before_user_details' ); ?>
<div id="bbp-single-user-details" class="col-md-4">
	<div id="bbp-user-avatar">
		<span class='vcard d-flex flex-column align-items-center'>
			<a class="url fn n" href="<?php bbp_user_profile_url(); ?>" title="<?php bbp_displayed_user_field( 'display_name' ); ?>" rel="me">
				<?php echo get_avatar( bbp_get_displayed_user_field( 'user_email', 'raw' ), apply_filters( 'bbp_single_user_details_avatar_size', 250 ), '', '', $args = array( 'class' => 'rounded-circle mb-3' ) ); ?>
			</a>

			<h5 class="mb-2"><strong><?php bbp_displayed_user_field( 'display_name' ); ?></strong></h5>
      <p class="text-muted">Web designer</p>
		</span>
	</div>

	<?php do_action( 'bbp_template_before_user_details_menu_items' ); ?>

	<nav id="bbp-user-navigation">
		<ul class="nav nav-pills flex-column">
			<li class="nav-item<?php if ( bbp_is_single_user_profile() ) :?> current<?php endif; ?>">
				<span class="vcard bbp-user-profile-link">
					<a class="url fn n nav-link<?= ( bbp_is_single_user_profile() ) ? ' active' : '' ?>" href="<?php bbp_user_profile_url(); ?>" title="<?php printf( esc_attr__( "%s's Profile", 'bbpress' ), bbp_get_displayed_user_field( 'display_name' ) ); ?>" rel="me"><?php esc_html_e( 'Profile', 'bbpress' ); ?></a>
				</span>
			</li>

			<li class="nav-item<?php if ( bbp_is_single_user_topics() ) :?> current<?php endif; ?>">
				<span class='bbp-user-topics-created-link'>
					<a class="nav-link<?= ( bbp_is_single_user_topics() ) ? ' active' : '' ?>" href="<?php bbp_user_topics_created_url(); ?>" title="<?php printf( esc_attr__( "%s's Topics Started", 'bbpress' ), bbp_get_displayed_user_field( 'display_name' ) ); ?>"><?php esc_html_e( 'Topics Started', 'bbpress' ); ?></a>
				</span>
			</li>

			<li class="nav-item<?php if ( bbp_is_single_user_replies() ) :?> current<?php endif; ?>">
				<span class='bbp-user-replies-created-link'>
					<a class="nav-link<?= ( bbp_is_single_user_replies() ) ? ' active' : '' ?>" href="<?php bbp_user_replies_created_url(); ?>" title="<?php printf( esc_attr__( "%s's Replies Created", 'bbpress' ), bbp_get_displayed_user_field( 'display_name' ) ); ?>"><?php esc_html_e( 'Replies Created', 'bbpress' ); ?></a>
				</span>
			</li>

			<?php if ( bbp_is_engagements_active() ) : ?>
				<li class="nav-item<?php if ( bbp_is_single_user_engagements() ) :?> current<?php endif; ?>">
					<span class='bbp-user-engagements-created-link'>
						<a class="nav-link<?= ( bbp_is_single_user_engagements() ) ? ' active' : '' ?>" href="<?php bbp_user_engagements_url(); ?>" title="<?php printf( esc_attr__( "%s's Engagements", 'bbpress' ), bbp_get_displayed_user_field( 'display_name' ) ); ?>"><?php esc_html_e( 'Engagements', 'bbpress' ); ?></a>
					</span>
				</li>
			<?php endif; ?>

			<?php if ( bbp_is_favorites_active() ) : ?>
				<li class="nav-item<?php if ( bbp_is_favorites() ) :?> current<?php endif; ?>">
					<span class="bbp-user-favorites-link">
						<a class="nav-link<?= ( bbp_is_favorites() ) ? ' active' : '' ?>" href="<?php bbp_favorites_permalink(); ?>" title="<?php printf( esc_attr__( "%s's Favorites", 'bbpress' ), bbp_get_displayed_user_field( 'display_name' ) ); ?>"><?php esc_html_e( 'Favorites', 'bbpress' ); ?></a>
					</span>
				</li>
			<?php endif; ?>

			<?php if ( bbp_is_user_home() || current_user_can( 'edit_user', bbp_get_displayed_user_id() ) ) : ?>

				<?php if ( bbp_is_subscriptions_active() ) : ?>
					<li class="nav-item<?php if ( bbp_is_subscriptions() ) :?> current<?php endif; ?>">
						<span class="bbp-user-subscriptions-link">
							<a class="nav-link<?= ( bbp_is_subscriptions() ) ? ' active' : '' ?>" href="<?php bbp_subscriptions_permalink(); ?>" title="<?php printf( esc_attr__( "%s's Subscriptions", 'bbpress' ), bbp_get_displayed_user_field( 'display_name' ) ); ?>"><?php esc_html_e( 'Subscriptions', 'bbpress' ); ?></a>
						</span>
					</li>
				<?php endif; ?>

				<li class="nav-item<?php if ( bbp_is_single_user_edit() ) :?> current<?php endif; ?>">
					<span class="bbp-user-edit-link">
						<a class="nav-link<?= ( bbp_is_single_user_edit() ) ? ' active' : '' ?>" href="<?php bbp_user_profile_edit_url(); ?>" title="<?php printf( esc_attr__( "Edit %s's Profile", 'bbpress' ), bbp_get_displayed_user_field( 'display_name' ) ); ?>"><?php esc_html_e( 'Edit', 'bbpress' ); ?></a>
					</span>
				</li>

			<?php endif; ?>

		</ul>

		<?php do_action( 'bbp_template_after_user_details_menu_items' ); ?>

	</nav>
</div>

<?php do_action( 'bbp_template_after_user_details' );
