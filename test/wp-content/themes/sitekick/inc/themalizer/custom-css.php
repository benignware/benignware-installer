<?php

add_action( 'wp_enqueue_scripts', function() {
  $theme_mods = get_theme_mods();
  $vars = array_reduce(
    array_keys($theme_mods),
    function($result, $key) use ($theme_mods) {
      $value = $theme_mods[$key];

      if (!is_string($value) && !is_numeric($value)) {
        return $result;
      }

      if (
        $key === 'background_color'
        && current_theme_supports('custom-background')
        && strpos($value, '#') !== 0
      ) {
        $value = '#' . $value;
      }

      $name = str_replace('_', '-', $key);
      
      $vars = [];
      $vars[$name] = $value;

      // TODO: Support hsl
      if (strpos($value, '#') === 0 || strpos($value, 'rgb') === 0) {
        list($r, $g, $b, $a) = rgba($value);

        $vars[$name . '-r'] = $r;
        $vars[$name . '-g'] = $g;
        $vars[$name . '-b'] = $b;
        $vars[$name . '-a'] = $a;
      }

      return array_merge($result, $vars);
    },
    []
  );

  $custom_css = sprintf(":root {\n%s\n}", implode("\n", array_map(function($key, $value) {
		return sprintf("\t--%s: %s;", str_replace('_', '-', $key), $value);
	}, array_keys($vars), array_values($vars))));

  // echo $custom_css;
  // exit;

  wp_register_style('sitekick-custom-css', false );
  wp_enqueue_style('sitekick-custom-css');
  wp_add_inline_style('sitekick-custom-css', $custom_css );
}, 100);
