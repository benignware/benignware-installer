<?php

function sitekick_asset($file) {
  return array_reduce(
    array(get_stylesheet_directory(), get_template_directory()),
    function($result, $item) use ($file) {
      if (!$result) {
        $file = array_shift(
          array_values(
            glob($item . '/' . $file, GLOB_BRACE)
          )
        );

        if ($file) {
          $url = str_replace(
            wp_normalize_path( untrailingslashit( ABSPATH ) ),
            site_url(),
            wp_normalize_path( $file )
          );
          $url = esc_url_raw( $url );
          return $url;
        }
      }

      return $result;
    }, ''
  );
}