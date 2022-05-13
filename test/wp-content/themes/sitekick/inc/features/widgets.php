<?php
  // Adds widget-classes filter
  add_filter( 'dynamic_sidebar_params', function($params) {
    global $wp_registered_widgets;

    $widget_id = $params[0]['widget_id'];

    // The filter is called *after* WordPress sets the before_widget value, so easiest solution to str_replace to add in our classes
    $before_widget = $params[0]['before_widget'];
    $match = preg_match_all('~class=[\'"]([^"\']*)~', $before_widget, $matches, PREG_SET_ORDER | PREG_OFFSET_CAPTURE);
    $last_match = end($matches);
    $index = $last_match[1][1];
    $class = $last_match[1][0];
    $classes = $match ? array_filter(explode(' ', $class)) : [];

    // Apply filter
    $classes = apply_filters('sitekick_widget_class', $classes, $class, $widget_id, $params);
    $before_widget = substr($before_widget, 0, $index)
     . implode(' ', $classes)
     . substr($before_widget, $index + strlen($class));

    $params[0]['before_widget'] = $before_widget;
    
    return $params;
  }, 10);