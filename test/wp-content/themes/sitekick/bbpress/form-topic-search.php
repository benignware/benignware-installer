<?php

/**
 * Search
 *
 * @package bbPress
 * @subpackage Theme
 */

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

if ( bbp_allow_search() ) : ?>

	<div class="bbp-search-form">
		<form role="search" method="get" id="bbp-topic-search-form">
			<label class="screen-reader-text hidden" for="ts"><?php esc_html_e( 'Search topics:', 'bbpress' ); ?></label>
			<div class="input-group mb-3">
				<input class="form-control" type="text" value="<?php bbp_search_terms(); ?>" name="ts" id="ts" />
				<button class="button btn btn-primary" type="submit" id="bbp_search_submit"><?php esc_attr_e( 'Search', 'bbpress' ); ?></button>
			</div>
		</form>
	</div>

<?php endif;
