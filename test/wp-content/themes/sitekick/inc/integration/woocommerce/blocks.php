<?php

add_filter('render_block', function($content, $block)  {
  global $wp_query;

  $name = $block['blockName'];
  $attrs = $block['attrs'];

  if ($name === 'woocommerce/product-category') {
    $args = array(
      'post_type' => 'product',
      'tax_query' => array(
        array(
            'taxonomy'  => 'product_cat', // Woocommerce product category taxonomy
            'field'     => 'term_id', // can be: 'name', 'slug' or 'term_id'
            'terms'     => $attrs['categories']
        )
      ),
    );

    $columns = $attrs['columns'];
    
    $loop = new WP_Query( $args );

    ob_start();

    global $post;

    echo '<div class="row g-4">';

    while ( $loop->have_posts() ) {
      $loop->the_post();
      echo sprintf('<div class="col-%s">', intval(12 / $columns));
      wc_get_template_part( 'content', 'product' );
      echo '</div>';
    }

    echo '</div>';

    $output = ob_get_clean();

    return $output;
    
    wp_reset_postdata();
  }

  return $content;
}, 10, 2);
