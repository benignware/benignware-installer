<?php

namespace benignware\sitekick {
  function get_asset($file) {
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

  function get_asset_url($file) {
    $file = get_asset($file);

    if (strpos($file, get_stylesheet_directory()) >= 0) {
      return str_replace(get_stylesheet_directory(), get_stylesheet_directory_uri(), $file);
    }

    if (strpos($file, get_template_directory()) >= 0) {
      return str_replace(get_template_directory(), get_template_directory_uri(), $file);
    }

    return null;
  }
}