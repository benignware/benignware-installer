<?php

function sitekick_from_camel_case($input) {
  $pattern = '!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!';
  preg_match_all($pattern, $input, $matches);
  $ret = $matches[0];
  foreach ($ret as &$match) {
    $match = $match == strtoupper($match) ?
      	strtolower($match) :
    	lcfirst($match);
  }
  return implode('_', $ret);
}

add_filter('render_block', function($content, $block)  {
  global $wp_query;

  $name = $block['blockName'];
  $attrs = $block['attrs'];

  if ($name === 'core/query') {
    $query_args = array_reduce(array_keys($attrs['query']), function($result, $camel_key) use ($attrs) {
      $key = sitekick_from_camel_case($camel_key);

      return array_merge($result, [
        $key => $attrs['query'][$camel_key]
      ]);
    }, []);

    $wp_query = new WP_QUERY($query_args);

    $layout = isset($attrs['displayLayout']) ? $attrs['displayLayout'] : [
      'columns' => 1
    ];
    $columns = $layout['columns'];

    ob_start();

    echo '<div class="row g-4">';

    while ( have_posts() ) {
      the_post();
      echo sprintf('<div class="col-lg-%s">', intval(12 / $columns));

      get_template_part( 'template-parts/content/content', 'excerpt' );

      echo '</div>';
    }

    echo '</div>';

    $content = ob_get_clean();

    wp_reset_query();
  }

  return $content;
}, 10, 2);