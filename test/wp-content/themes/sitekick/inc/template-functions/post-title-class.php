<?php
namespace benignware\sitekick {
  function get_post_title_class( $class = '', $post_id = null ) {
    $post = get_post( $post_id );

    if ( $class ) {
      if ( ! is_array( $class ) ) {
          $class = preg_split( '#\s+#', $class );
      }
      $classes = array_map( 'esc_attr', $class );
    } else {
      // Ensure that we always coerce class to being an array.
      $class = array();
    }

    if ( ! $post ) {
        return $classes;
    }

    $classes[] = 'entry-title';

    $classes = array_map( 'esc_attr', $classes );
    $classes = apply_filters( 'sitekick_post_title_class', $classes, $class, $post->ID );

    return array_unique( $classes );
  }

  function post_title_class( $class = '', $post_id = null ) {
    echo 'class="' . esc_attr( implode( ' ', get_post_title_class( $class, $post_id ) ) ) . '"';
  }
}



