<?php

use function benignware\bootstrap_hooks\get_markup;
use function benignware\sitekick\get_asset;
use function benignware\sitekick\get_asset_url;

require_once 'blocks.php';

// Remove each style one by one
add_filter( 'woocommerce_enqueue_styles', function( $enqueue_styles ) {
	unset( $enqueue_styles['woocommerce-general'] );	// Remove the gloss
	// unset( $enqueue_styles['woocommerce-layout'] );		// Remove the layout
	// unset( $enqueue_styles['woocommerce-smallscreen'] );	// Remove the smallscreen optimisation

	return $enqueue_styles;
} );

// Or just remove them all in one line
// add_filter( 'woocommerce_enqueue_styles', '__return_false' );

add_filter( 'wp_nav_menu_objects', function( $items ) {
  global $sitekick_wc_account_endpoints;

  if (!isset($sitekick_wc_account_endpoints)) {
    $sitekick_wc_account_endpoints = array_filter(array_map(function($name) {
      return get_option('woocommerce_'. $name . '_endpoint', $name);
    }, [
      'logout',
      // 'checkout_pay',
      // 'checkout_order_received',
      'myaccount_add_payment_method',
      'myaccount_delete_payment_method',
      'myaccount_set_default_payment_method',
      'myaccount_orders',
      'myaccount_view_order',
      'myaccount_downloads',
      'myaccount_edit_account',
      'myaccount_edit_address',
      'myaccount_payment_methods',
      // 'myaccount_lost_password'
    ]));
  }

	if ( ! is_user_logged_in() ) {
		foreach ($sitekick_wc_account_endpoints as $endpoint) {
      if ( ! empty( $endpoint ) && ! empty( $items ) && is_array( $items ) ) {
        foreach ( $items as $key => $item ) {
          if ( empty( $item->url ) ) {
            continue;
          }
          $path  = wp_parse_url( $item->url, PHP_URL_PATH );
          $query = wp_parse_url( $item->url, PHP_URL_QUERY );
  
          if ( strstr( $path, $endpoint ) || strstr( $query, $endpoint ) ) {
            unset( $items[ $key ] );
          }
        }
      }
    }
	}

	return $items;
}, 10 );

add_filter('render_block', function($content, $block)  {
  $name = $block['blockName'];
  $attrs = $block['attrs'];

  // echo $name;

  return $content;
}, 10, 2);



/**
 * @snippet       WooCommerce User Registration Shortcode
 * @how-to        Get CustomizeWoo.com FREE
 * @author        Rodolfo Melogli
 * @compatible    WooCommerce 4.0
 * @donate $9     https://businessbloomer.com/bloomer-armada/
 */
   
add_shortcode( 'sitekick_wc_reg_form', function() {
   if ( is_admin() ) return;
   if ( is_user_logged_in() ) return;
   ob_start();
 
   // NOTE: THE FOLLOWING <FORM></FORM> IS COPIED FROM woocommerce\templates\myaccount\form-login.php
   // IF WOOCOMMERCE RELEASES AN UPDATE TO THAT TEMPLATE, YOU MUST CHANGE THIS ACCORDINGLY
   do_action( 'woocommerce_before_customer_login_form' );
 

   ?>
    <form method="post" class="woocommerce-form woocommerce-form-register register" <?php do_action( 'woocommerce_register_form_tag' ); ?> >

      <?php do_action( 'woocommerce_register_form_start' ); ?>

      <?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>

      <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
        <label for="reg_username"><?php esc_html_e( 'Username', 'woocommerce' ); ?> <span class="required">*</span></label>
        <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="reg_username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
      </p>

      <?php endif; ?>

      <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
      <label for="reg_email"><?php esc_html_e( 'Email address', 'woocommerce' ); ?> <span class="required">*</span></label>
      <input type="email" class="woocommerce-Input woocommerce-Input--text input-text" name="email" id="reg_email" autocomplete="email" value="<?php echo ( ! empty( $_POST['email'] ) ) ? esc_attr( wp_unslash( $_POST['email'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
      </p>

      <?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>

      <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
        <label for="reg_password"><?php esc_html_e( 'Password', 'woocommerce' ); ?> <span class="required">*</span></label>
        <input type="password" class="woocommerce-Input woocommerce-Input--text input-text" name="password" id="reg_password" autocomplete="new-password" />
      </p>

      <?php else : ?>

      <p><?php esc_html_e( 'A password will be sent to your email address.', 'woocommerce' ); ?></p>

      <?php endif; ?>

      <?php do_action( 'woocommerce_register_form' ); ?>

      <p class="woocommerce-FormRow form-row">
      <?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
      <button type="submit" class="woocommerce-Button woocommerce-button button woocommerce-form-register__submit" name="register" value="<?php esc_attr_e( 'Register', 'woocommerce' ); ?>"><?php esc_html_e( 'Register', 'woocommerce' ); ?></button>
      </p>

      <?php do_action( 'woocommerce_register_form_end' ); ?>

    </form>
   <?php
     
   $content = ob_get_clean();
   $content = get_markup($content);

   return $content;
});


add_filter('woocommerce_settings_pages', function($value) {
  $value = array_merge($value, array(
    'title'    => __( 'Registration page', 'woocommerce' ),
    /* Translators: %s Page contents. */
    'desc'     => sprintf( __( 'Page contents: [%s]', 'woocommerce' ), apply_filters( 'woocommerce_registration_shortcode_tag', 'woocommerce_registration' ) ),
    'id'       => 'woocommerce_registration_page_id',
    'type'     => 'single_select_page_with_search',
    'default'  => '',
    'class'    => 'wc-page-search',
    'css'      => 'min-width:300px;',
    'args'     => array(
      'exclude' =>
        array(
          wc_get_page_id( 'checkout' ),
          wc_get_page_id( 'myaccount' ),
        ),
    ),
    'desc_tip' => true,
    'autoload' => false,
  ));

  return $value;
}, 10, 2);



// add_action( 'woocommerce_checkout_before_order_review', function($html) {
//   ob_start();
// } );

// add_action( 'woocommerce_checkout_after_order_review', function($html) {
//   $content = ob_get_clean();
//   $content = get_markup($content);
  
//   echo 'HELLO';
//   echo $content;
// } );

// define('SITEKICK_ACCOUNT_ENDPOINT', 'account');

// add_filter('woocommerce_get_endpoint_url', function( $url, $endpoint, $value, $permalink ) {
//   $account_endpoints = [
//     'orders',
//     'downloads',
//     'edit-address',
//     'payment-methods',
//     'avatar'
//   ];

//   if (in_array($endpoint, $account_endpooints)) {
//     $url = home_url(SITEKICK_ACCOUNT_ENDPOINT . '/' . $endpoint);
//   }
  
//   return $url;
// }, 10, 4);


add_action('init', function() {
	add_rewrite_endpoint('avatar', EP_ROOT | EP_PAGES);
});

add_filter('woocommerce_account_menu_items', function($items) {
	$logout = $items['customer-logout'];
	unset($items['customer-logout']);

  if (shortcode_exists('user_profile_avatar_upload')) {
    $items['avatar'] = __('Avatar', 'sitekick');
  }
	
	$items['customer-logout'] = $logout;
	return $items;
});

add_action('woocommerce_account_avatar_endpoint', function() {
  if (shortcode_exists('user_profile_avatar_upload')) {
    echo do_shortcode('[user_profile_avatar_upload]');
  }
});


add_filter ( 'woocommerce_account_menu_items', function( $menu_links ){
	// We will hook "sometext" later
	$new = array( 'profile' => 'Profile', 'avatar' => 'Avatar' );
 
	// Or in case you need 2 links
	// $new = array( 'link1' => 'Link 1', 'link2' => 'Link 2' );
 
	// array_slice() is good when you want to add an element between the other ones
	$menu_links = array_slice( $menu_links, 0, 1, true ) 
	+ $new
	+ array_slice( $menu_links, 1, NULL, true );
 
	return $menu_links;
});

 
add_filter( 'woocommerce_get_endpoint_url', function( $url, $endpoint, $value, $permalink ){
	if ( $endpoint === 'profile' ) {
    if (function_exists('bbp_get_user_profile_url')) {
      $current_user = wp_get_current_user();
      $url = bbp_get_user_profile_url($current_user->ID);
    }
	}

	return $url;
}, 10, 4 );

// add_action('woocommerce_before_account_navigation', function() {
//   $content = 
// }
#

/**
 * Change the placeholder image
 */
add_filter('woocommerce_placeholder_img_src', function( $src ) {
  return get_asset('img/placeholder.{jpg,png,gif,svg}');
});

add_filter('woocommerce_placeholder_img', function($image_html, $size, $dimensions) {
	$image  = wc_placeholder_img_src( $size );
  $placeholder_url = get_asset_url('img/placeholder.{jpg,png,gif,svg}');
	$image_html = '<img src="' . $placeholder_url . '"' . esc_attr( $image ) . '" alt="' . esc_attr__( 'Placeholder', 'woocommerce' ) . '" width="' . esc_attr( $dimensions['width'] ) . '" class="woocommerce-placeholder wp-post-image" height="' . esc_attr( $dimensions['height'] ) . '" />';

	return $image_html;
}
, 10, 3);


remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
add_action( 'woocommerce_before_shop_loop_item_title', function() {
  global $product;
  $size = 'woocommerce_thumbnail';

  $image_size = apply_filters( 'single_product_archive_thumbnail_size', $size );

  $html = $product ? $product->get_image( $image_size ) : '';

  $doc = new DOMDocument();
  @$doc->loadHTML(sprintf("<?xml encoding=\"utf-8\" ?>%s", $html));
  $doc_xpath = new DOMXpath($doc);
  $image = $doc_xpath->query('//img')->item(0);

  if ($image) {
    $class = $image->hasAttribute('class') ? $image->getAttribute('class') : '';
    $classes = array_unique(array_filter(explode(' ', $classes)));
    $classes = apply_filters('sitekick_product_thumbnail_class', $classes);

    $class = implode(' ', array_unique(array_filter($classes)));
    $image->setAttribute('class', $class);

    $html = preg_replace('~(?:<\?[^>]*>|<(?:!DOCTYPE|/?(?:html|head|body))[^>]*>)\s*~i', '', $doc->saveHTML());
  }

  echo $html;
}, 10 );

remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
add_action( 'woocommerce_before_shop_loop_item', function() {
  ob_start();
  woocommerce_template_loop_product_link_open();
  $html = ob_get_clean();

  // echo '<textarea>' . $html . '</textarea>';
  
  $doc = new DOMDocument();
  @$doc->loadHTML(sprintf("<?xml encoding=\"utf-8\" ?>%s", $html));
  $doc_xpath = new DOMXpath($doc);
  
  $link = $doc_xpath->query('//a')->item(0);

  if ($link) {
    $class = $link->hasAttribute('class') ? $link->getAttribute('class') : '';
    $classes = array_unique(array_filter(explode(' ', $classes)));
    $classes = apply_filters('sitekick_product_loop_link_class', $classes);

    $class = implode(' ', array_unique(array_filter($classes)));
    $link->setAttribute('class', $class);
  }

  $html = preg_replace('~(?:<\?[^>]*>|<(?:!DOCTYPE|/?(?:html|head|body))[^>]*>)\s*~i', '', $doc->saveHTML());

  echo $html;
});

remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
add_action( 'woocommerce_shop_loop_item_title', function() {
  ob_start();
  woocommerce_template_loop_product_title();
  $html = ob_get_clean();

  // echo '<textarea>' . $html . '</textarea>';
  
  $doc = new DOMDocument();
  @$doc->loadHTML(sprintf("<?xml encoding=\"utf-8\" ?>%s", $html));
  $doc_xpath = new DOMXpath($doc);
  $heading = $doc_xpath->query('//h1|//h2|//h3')->item(0);

  if ($heading) {
    $class = $heading->hasAttribute('class') ? $heading->getAttribute('class') : '';
    $classes = array_unique(array_filter(explode(' ', $classes)));
    $classes = apply_filters('sitekick_product_loop_title_class', $classes);

    $class = implode(' ', array_unique(array_filter($classes)));
    $heading->setAttribute('class', $class);
  }

  $html = preg_replace('~(?:<\?[^>]*>|<(?:!DOCTYPE|/?(?:html|head|body))[^>]*>)\s*~i', '', $doc->saveHTML());

  echo $html;
});

add_filter('woocommerce_sale_flash', function($html) {
  $doc = new DOMDocument();
  @$doc->loadHTML(sprintf("<?xml encoding=\"utf-8\" ?>%s", $html));
  $doc_xpath = new DOMXpath($doc);
  $badge = $doc_xpath->query('/html/body/*')->item(0);

  if ($badge) {
    $class = $badge->hasAttribute('class') ? $badge->getAttribute('class') : '';
    $classes = array_unique(array_filter(explode(' ', $classes)));
    $classes = apply_filters('sitekick_product_sale_flash_class', $classes);

    $class = implode(' ', array_unique(array_filter($classes)));
    $badge->setAttribute('class', $class);

    $html = preg_replace('~(?:<\?[^>]*>|<(?:!DOCTYPE|/?(?:html|head|body))[^>]*>)\s*~i', '', $doc->saveHTML());
  }

  return $html;
});

add_filter('woocommerce_loop_add_to_cart_link', function($html) {
  $doc = new DOMDocument();
  @$doc->loadHTML(sprintf("<?xml encoding=\"utf-8\" ?>%s", $html));
  $doc_xpath = new DOMXpath($doc);
  $link = $doc_xpath->query('//a')->item(0);

  if ($link) {
    $class = $link->hasAttribute('class') ? $link->getAttribute('class') : '';
    $classes = array_unique(array_filter(explode(' ', $classes)));
    $classes = apply_filters('sitekick_product_add_to_card_link_class', $classes);

    $class = implode(' ', array_unique(array_filter($classes)));
    $link->setAttribute('class', $class);

    $html = preg_replace('~(?:<\?[^>]*>|<(?:!DOCTYPE|/?(?:html|head|body))[^>]*>)\s*~i', '', $doc->saveHTML());
  }

  return $html;
});

remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20); 
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
add_action( 'woocommerce_before_shop_loop', function() {
  $classes = apply_filters('sitekick_product_result_count_ordering_wrapper_class', []);
  $class = implode(' ', array_unique(array_filter($classes)));

  ob_start();
  ?>
  <div class="<?= $class ?>">
    <?php woocommerce_result_count() ?>
    <?php woocommerce_catalog_ordering() ?>
  </div>
  <?php
  $html = ob_get_clean();

  echo $html;
});

add_action( 'template_redirect', function() {
  global $wp;

  if ( isset( $wp->query_vars['customer-logout'] ) ) {
    wp_redirect( str_replace( '&amp;', '&', wp_logout_url( home_url() ) ) );
    exit;
  }
} );