<?php

namespace benignware\sitekick {
  function is_active_link($url) {
    global $wp;
  
    $candidates = [
      home_url( $wp->request ),
      add_query_arg( $wp->query_vars, home_url( $wp->request ) ),
    ];
  
    $url = rtrim($url, '/');
  
    $item = current(array_filter($candidates, function($candidate) use ($url) {
      return $candidate === $url;
    }));
  
    return !!$item;
  }
}
