<?php

add_filter('clean_url', function( $url ) {
  $urlinfo = parse_url($url);
  $path = $urlinfo['path'];

  $eval = strpos($path, '/wp-admin') === 0;
  $eval = apply_filters('turbo_eval', $eval, $url, $path);

  if (!$eval) {
    return "$url' data-turbo-eval='false";
  }

  return $url;
}, 11, 1);

add_action('wp_head', function() {
  echo <<< EOT
    <meta name="turbo-cache-control" content="no-cache">
EOT;
});