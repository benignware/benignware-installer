<?php

require_once 'shortcode.php';
require_once 'acf.php';

/**
 * Allows Advanced Custom Fields field groups to be displayed on the Memberships
 * plan edit page
 *
 * @param string[] array of meta box IDs
 */

add_filter( 'wc_memberships_allowed_meta_box_ids', function( $allowed_meta_box_ids ) {
	if ( function_exists( 'acf_get_field_groups' ) ) {

		$field_groups = array_merge(
			acf_get_field_groups( array( 'post_type' => 'wc_membership_plan' ) ),
			acf_get_field_groups( array( 'post_type' => 'wc_user_membership' ) )
		);

		foreach ( $field_groups as $field_group ) {
			$allowed_meta_box_ids[] = 'acf-' . $field_group['key'];
		}
	}

	return $allowed_meta_box_ids;
});

add_action( 'woocommerce_product_query', function( $q ) { 
  // Exclude membership products from shop page
	$membership_plans = wc_memberships_get_membership_plans();
  $product_ids = array_reduce($membership_plans, function($result, $membership_plan) {
    return array_merge($result, $membership_plan->get_product_ids());
  }, []);

	$q->set( 'post__not_in', (array) $product_ids );
} );

add_filter( 'woocommerce_related_products', function( $related_posts, $product_id, $args ){
  // HERE set your product IDs to exclude
  $membership_plans = wc_memberships_get_membership_plans();
  $product_ids = array_reduce($membership_plans, function($result, $membership_plan) {
    return array_merge($result, $membership_plan->get_product_ids());
  }, []);

  return array_diff( $related_posts, $product_ids );
}, 10, 3 );


function can_user_access_content($post_id = null, $user_id = null) {
  global $post;

  if ( current_user_can('editor') || current_user_can('administrator') ) {
    return true;
  }

  if ($post && !$post_id) {
    $post_id = $post->ID;
  }

  if (!$user_id) {
    $user_id = get_current_user_id($user_id);
  }

  // check if there's a force public on this content
  if (get_post_meta($post_id, '_wc_memberships_force_public', true) == 'yes') {
    return true;
  }

  $args = array( 'status' => array( 'active' ));
  $plans = wc_memberships_get_user_memberships( $user_id, $args );
  $user_plans = array();

  foreach($plans as $plan){
    array_push($user_plans,$plan->plan_id);
  }
  $rules = wc_memberships()->get_rules_instance()->get_post_content_restriction_rules( $post_id );

  if (count($rules) === 0) {
    return true;
  }

  foreach($rules as $rule) {
    if (in_array($rule->get_membership_plan_id(), $user_plans)){
      return true;
    }
  }       
  return false;
}

// Remove membership-restricted forums from the main bbPress query
add_filter( 'bbp_after_has_forums_parse_args', function ( $vars ) {
	if (!function_exists( 'can_user_access_content')) {
    return;
  }
 
	$query = new WP_Query( $vars );
 
	$forum_ids = array();
 
	foreach ( $query->posts as $forum ) {
		$forum_ids[] = $forum->ID;
	}
 
	$accessible = array_filter($forum_ids, function($forum_id) {
    return can_user_access_content($forum_id);
  });
 
	$vars['post__in'] = $accessible;
 
	return $vars;
} );
