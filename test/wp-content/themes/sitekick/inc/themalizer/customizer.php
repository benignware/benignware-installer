<?php

// TODO: parse function arguments, resolve variable references
// https://stackoverflow.com/questions/25822532/how-to-parse-function-name-with-arguments-in-php

// function rgba2hex($rgba) {
//   $match = preg_match('~rgba?\((\d+)\s*,\s*(\d+)\s*,\s*(\d)\s*(?:,\s*(\d+))?~', $rgba, $matches);

//   if ($match) {
//     list(, $r, $g, $b, $a) = $matches;

//     echo $r;
//   }
// }

function is_color($string) {
 return strpos($string, '#') === 0 || strpos($string, 'rgb') === 0 || strpos($string, 'hsl') === 0;
}

function is_font($value) {
  $fonts = get_theme_fonts();

  return in_array($value, $fonts);
}

add_filter( 'customize_dynamic_setting_args', function($args, $id) {
  global $wp_customize;

  $vars = get_theme_defaults();

  $name = str_replace('_', '-', $id);
  $default = $args['default'];

  if (is_color($default)) {
    if (isset($vars[$name]) && is_color($vars[$name])) {
      list ($r, $g, $b, $a) = rgba($vars[$name]);
    }
  
    $r = isset($vars[$name . '-r']) ? $vars[$name . '-r'] : $r;
    $g = isset($vars[$name . '-g']) ? $vars[$name . '-g'] : $g;
    $b = isset($vars[$name . '-b']) ? $vars[$name . '-b'] : $b;
    $a = isset($vars[$name . '-a']) ? $vars[$name . '-a'] : $a;
    
    if (isset($r) && isset($g) && isset($b)) {
      if (!is_numeric($a)) {
        $a = 1;
      }
      $value = rgba2hex($r, $g, $b, $a);

      if (
        $id === 'background_color'
        && current_theme_supports('custom-background')
      ) {
        $value = ltrim($value, '#');
      }

      $args['default'] = $value;
    }
  } else if (isset($vars[$name])) {
    $args['default'] = $vars[$name];
  }

  return $args;
}, 10, 2);
