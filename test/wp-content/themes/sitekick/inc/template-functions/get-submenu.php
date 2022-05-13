<?php

namespace benignware\sitekick {
  function is_in_menu( $menu_id = null, $object_id = null ) {
    if ( !$object_id ) {
      global $post;

      $object_id = get_queried_object_id();
    }

    $object_url = get_permalink($object_id);
    
    // get menu object
    $menu_items = wp_get_nav_menu_items( $menu_id );

    // stop if there isn't a menu
    if ( ! $menu_items ) {
      return false;
    }

    $menu_items = array_filter($menu_items, function($menu_item) use ($object_id, $object_url) {
      if (strpos($menu_item->url, $object_url) === 0) {
        return true;
      }

      return false;
    } );
    
    if (count($menu_items) > 0) {
      return true;
    }

    return false;
  }

  function get_submenu($location_id = null) {
    global $post;

    $theme_locations = get_nav_menu_locations();
    $object_id = get_queried_object_id();
  
    $locations = is_array($location_id)
      ? $location_id
      : (
        $location_id !== null
          ? [$location_id]
          : array_keys($theme_locations)
      );

    $locations = array_values(array_filter($locations, function($location) use ($object_id, $theme_locations) {
      return is_in_menu($theme_locations[$location], $object_id);
    }));

    if (count($locations) > 0) {
      $location = $locations[0];

      wp_nav_menu(
        array(
          'theme_location' => $location,
          'start_depth' => 1
        )
      );
    }
  }

  function has_submenu($location_id = null) {
    ob_start();
    get_submenu($location_id);
    $content = ob_get_clean();

    return strlen(trim($content)) > 0;
  }
}
