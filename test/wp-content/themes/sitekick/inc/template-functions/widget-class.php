<?php
namespace benignware\sitekick {
  function get_widget_class( $class = '', $widget_id = null ) {
    $classes = $class ? array_unique(array_filter(explode(' ', $class))) : [];
    $classes = array_map( 'esc_attr', $classes );
    $classes = apply_filters( 'sitekick_widget_class', $classes, $class, $widget_id );

    $class = implode(' ', array_unique(array_filter($classes)));

    return $class;
  }

  function widget_class( $class = '', $widget_id = null ) {
    echo 'class="' . esc_attr( implode( ' ', get_widget_class( $class, $widget_id ) ) ) . '"';
  }
}