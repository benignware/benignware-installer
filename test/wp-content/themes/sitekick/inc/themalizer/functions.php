<?php

function _load_theme_resource($url) {
  global $theme_resources;

  $local_directory_uris = array(
    [ get_stylesheet_directory_uri(), get_stylesheet_directory() ],
    [ get_template_directory_uri(), get_template_directory() ]
  );

  $local_files = array_map(
    function($item) use($url) {
      return $item[1] . substr($url, strlen($item[0]));
    },
    array_values(
        array_filter($local_directory_uris, function($item) use ($url) {
        return (substr($url, 0, strlen($item[0])) === $item[0]);
      })
    )
  );
  $local_file = $local_files[0];

  if ($local_file) {
    ob_start();
    include $local_file;
    $content = ob_get_contents();
    ob_end_clean();

    if ($content) {
      return $content;
    }
  }

  $response = wp_remote_get($url, [
    'timeout' => 10
  ]);
 
  if ( is_array( $response ) && ! is_wp_error( $response ) ) {
    $content = $response['body']; // use the content

    return $content;
  }

  return null;
}

function _parse_theme_resource($content) {
  $result = array(
    'variable' => array(),
    'font-family' => array()
  );

  // Parse vars
  preg_match_all("~\s:root\s*\{([^}]*)\s*\}~", $content, $root_decl_matches, PREG_SET_ORDER);

  foreach($root_decl_matches as $root_decl_match) {
    $decl = $root_decl_match[1];
    preg_match_all("~\s*--([a-zA-Z_-]*):\s*([^;]*)\s*~", $decl, $var_matches, PREG_SET_ORDER);

    foreach($var_matches as $var_match) {
      $name = $var_match[1];
      $value = $var_match[2];

      $result['variable'][$name] = $value;
    }
  }

  // Parse fonts
  preg_match_all("~\s*@font-face\s*\{([^}]*)\s*\}~", $content, $font_face_matches, PREG_SET_ORDER);

  if (count($font_face_matches) > 0) {
    foreach($font_face_matches as $font_face_match) {
      preg_match_all("~\s*font-family:\s*([^;]*)\s*~", $font_face_match[1], $font_family_matches, PREG_SET_ORDER);

      foreach($font_family_matches as $font_family_match) {
        $font_family = trim($font_family_match[1], ' \'"');

        $result['font-family'] = array_unique(array_merge($result['font-family'], array($font_family)));
      }
    }
  }

  return $result;
}

function _get_dependent_handles($handles) {
  global $wp_styles;

  return array_unique(
    array_reduce($handles, function($result, $handle) use ($wp_styles) {
      $item = $wp_styles->registered[$handle];

      $pattern = '~\/(wp-admin|wp-includes)~';

      $match = preg_match($pattern, $item->src);

      if ($match) {
        return $result;
      }

      if (isset($item->extra)) {
        $match = preg_match($pattern, $item->extra['path']);

        if ($match) {
          return $result;
        }
      }

      $handles = _get_dependent_handles($item->deps);

      return array_merge($result, [$handle], $handles);
    }, [])
  );
}

function _load_theme_resources() {
  global $wp_styles;

  $handles = _get_dependent_handles($wp_styles->queue);

  $fonts = [];
  $variables = [];

  foreach ($handles as $handle) {
    $item = $wp_styles->registered[$handle];
    $content = _load_theme_resource($item->src);
    $data = _parse_theme_resource($content);

    $fonts = array_unique(array_merge($data['font-family'], $fonts));
    $variables = array_merge($data['variable'], $variables);
  }

  return [
    'fonts' => $fonts,
    'variables' => $variables
  ];
}

function get_theme_resources() {
  global $theme_resources;

  if (isset($theme_resources)) {
    return $theme_resources;
  }

  $url = admin_url( 'admin-ajax.php' ) . '?action=theme_resources';
  $url = preg_replace("~(https?)://localhost(\:\d*)?~", "$1://127.0.0.1", $url);

  // $url = 'http://127.0.0.1/wp-admin/admin-ajax.php?action=theme_resources';

  $response = wp_remote_get($url, [
    'timeout' => 35
  ]);
 
  if ( is_array( $response ) && ! is_wp_error( $response ) ) {
    $content = $response['body']; // use the content
  } else {
    echo 'ERROR ' . $url;
    exit;
  }

  if ($content) {
    $theme_resources = json_decode($content, true);
  } else {
    $theme_resources = array();
  }

  return $theme_resources;
}


function get_theme_fonts() {
  $theme_resources = get_theme_resources();

  return array_merge(
    $theme_resources['fonts'],
    [
      'Times New Roman',
      'Arial',
      'Courier New'
    ]
  );
}

function get_theme_defaults() {
  $theme_resources = get_theme_resources();

  return $theme_resources['variables'];
}

function get_theme_vars() {
  $theme_defaults = get_theme_defaults();

  $theme_variables = apply_filters('theme_variables', $theme_defaults);

  $result = [];

  foreach ($theme_variables as $key => $value) {
    $var = new stdClass();
    $var->name = $key;
    $var->value = $value;
    $var->default = $theme_defaults[$key];

    $result[$key] = $var;
  }

  return $result;
}

function get_theme_custom_css() {
  $theme_vars = array_filter(get_theme_vars(), function($var) {
    return $var->value !== $var->default;
  });

  $css = <<<EOT
:root {

EOT;
  foreach ($theme_vars as $var) {
    if ($var->value) {
      $css.= <<<EOT
  --$var->name: $var->value;

EOT;
    }
  }

  $css.= <<<EOT
}

EOT;

  return $css;
}


function get_theme_palette() {
  $theme_palette = get_theme_support('editor-color-palette');

  return apply_filters('theme_palette', $theme_palette);
}

