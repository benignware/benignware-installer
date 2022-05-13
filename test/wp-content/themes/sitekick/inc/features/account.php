<?php

// add_filter('login_redirect', function ( $redirect_to, $request, $user ) {
// 	global $user;
	
// 	if ( isset( $user->roles ) && is_array( $user->roles ) ) {
// 		if ( in_array( "administrator", $user->roles ) ) {
// 			return $redirect_to;
// 		} else {
// 			return home_url();
// 		}
// 	} else {
// 		return $redirect_to;
// 	}
// }, 10, 3);

add_filter('register_url', function($url) {
	return site_url( 'registration' );
});

add_filter('login_url', function($login_url, $redirect, $force_reauth) {
	global $wp;

	if (!isset($redirect) || strpos($redirect, 'wp-') === FALSE) {
		return apply_filters( 'sitekick_login_url', $login_url, $redirect, $force_reauth);
	}

	return $login_url;
}, 10, 3);

// add_filter('logout_url', function($logout_url, $redirect ) {
// 	return $logout_url;
// }, 10, 2);



// add_filter('clean_url', function( $url ) {
//   if ($url === wp_login_url()) {
// 		$url = apply_filters('sitekick_login_url', '/login');
// 	}

//   return $url;
// }, 11, 1);

add_action('template_redirect', function () {
	$login_url = parse_url(apply_filters('sitekick_login_url', wp_login_url()), PHP_URL_PATH);
	$register_url = parse_url(apply_filters('register_url', wp_registration_url()), PHP_URL_PATH);

	$template_id = null;

	if (strpos($_SERVER['REQUEST_URI'], $login_url) === 0) {
		$template_id = 'login';
	}

	if (strpos($_SERVER['REQUEST_URI'], $register_url) === 0) {
		$template_id = 'registration';
	}

	$match = preg_match('~^/(login|registration)(?:$|[?#])?~', $_SERVER['REQUEST_URI'], $matches);

	if ($template_id) {
		$template = esc_url(sprintf('%s/page-%s.php', get_template_directory(), $template_id));

		if (file_exists($template)) {
			global $wp_query;
			if ($wp_query->is_404) {
				$wp_query->is_404 = false;
				$wp_query->is_archive = true;
			}
			header("HTTP/1.1 200 OK");
			include($template);
			die();
		}
	}
});
      
add_filter( 'logout_redirect', function( $redirect_to, $requested_redirect_to, $user ) {
	// $user_roles = $user->roles;
	// $user_has_admin_role = in_array( 'administrator', $user_roles );

	// if ( $user_has_admin_role ) :
	// 	$redirect_to = admin_url();
	// else:
	// 	$redirect_to = home_url();
	// endif;

	$redirect_to = home_url();

	return $redirect_to;
}, 9999, 3 );


add_action( 'wp_login_failed', function() {
	if (!isset($_POST['frontend']) || !$_POST['frontend']) {
		return;
	}

	$login_url = apply_filters('sitekick_login_url', wp_login_url());
  $login_url = add_query_arg( 'error', base64_encode(json_encode([
		'message' => __('Invalid username and/or password.')
	])), wp_login_url() );

  wp_redirect( $login_url );
  exit;
});
 

add_filter( 'authenticate', function( $user, $username, $password ) {
	if (!isset($_POST['frontend']) || !$_POST['frontend']) {
		return $user;
	}

	$field_errors = array_reduce([
		['log', $username, 'Username'],
		['pwd', $password, 'Password']
	], function($result, $item) {
		return array_merge($result, empty($item[1]) ? [
			$item[0] => __(sprintf('%s can\'t be empty.', __($item[2])))
		] : []);
	}, []);

	if (count($field_errors)) {
		$login_url = apply_filters('sitekick_login_url', wp_login_url());
		$login_url = add_query_arg( 'error', base64_encode(json_encode([
			'fields' => $field_errors
		])), $login_url);

		wp_redirect( $login_url );
		exit;
	}

	return $user;
}, 1, 3);


add_filter('sitekick_login_url', function() {
	return get_site_url(get_current_blog_id(), 'login');
});
