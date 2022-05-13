<?php

function sitekick_gallery_render($template, $data = array()) {
  foreach($data as $key => $value) {
    $$key = $data[$key];
  }

  ob_start();
  include $template;
  $output = ob_get_contents();
  ob_end_clean();

  return $output;
}

function sitekick_gallery_shortcode($params, $content) {
	global $wp, $wp_query, $post;

  if ( !can_user_access_content() ) {
    return $content;
  }

	$params = shortcode_atts(array(
		'template' => 'gallery',
		'format' => '',
    'id' => null,
    'title' => '',
    'columns' => 4,
		// Query params
		'ids' => null,
		// 'order' => 'ASC',
    // 'orderby' => 'menu_order ID',
		'order' => '',
    'orderby' => '',
    'post_status' => 'publish',
    'nopaging' => true,
    'post_type' => 'any',
    'post_mime_type' => null,
    'include' => '',
    'exclude' => '',
    // Gallery
    'post_type' => 'attachment',
    'post_status' => 'inherit',
    'post_mime_type' => 'image',
    'ids' => is_array($params['ids']) ? implode(',', $params['ids']) : $params['ids'],
    'size' => 'large',
    'fit' => 'cover'
	), $params, 'sitekick_gallery');

  // Parse booleans
  $params = array_map(function($value) {
		return $value === 'false' ? false : ($value === 'true' ? true : $value);
	}, $params);

  if (empty($params['title']) && $post) {
    $params['title'] = get_the_title();
  }

  if (empty($params['id'])) {
    $params['id'] = sanitize_title(
      sprintf(
        'sitekick-gallery-%s-%s',
        $post ? $post->ID : '0',
        base64_encode(str_replace(',', '-', $params['ids']))
      )
    );
  }

  // Transform ids to query params
	if ( ! empty( $params['ids'] ) ) {
    // 'ids' is explicitly ordered, unless you specify otherwise.
    if ( empty( $params['orderby'] ) ) {
      $params['orderby'] = 'post__in';
    }

    $params['include'] = $params['ids'];
  }

  $query_params = array_merge(
    array_intersect_key($params, array_flip([
      'order',
      'orderby',
      'include',
      'exclude',
      'post_type',
      'post_mime_type',
      'post_status',
      'nopaging'
    ])),
    array(
      'post__in' => is_array($params['include']) ? $params['include'] : explode(',', $params['include']),
      'orderby' => $params['order'] === 'RAND' ? 'none' : $params['orderby']
    )
  );

  $template = get_template_directory() . '/inc/features/gallery/template/gallery-lightbox.php';

	$wp_query = new WP_QUERY($query_params);

  $data = [
    'id' => $params['id'],
    'columns' => $params['columns'],
    'title' => $params['title'],
    'wp_query' => $wp_query 
  ];

	$output = sitekick_gallery_render($template, $data);

	wp_reset_query();

	return $output;
}

add_shortcode('sitekick_gallery', 'sitekick_gallery_shortcode');

add_filter('render_block', function($html, $block) {
  // if (!is_single()) {
  //   return $html;
  // }

  if ($block['blockName'] === 'core/gallery') {
    $doc = new DOMDocument();
    @$doc->loadHTML('<?xml encoding="utf-8" ?>' . $html);
    $doc_xpath = new DOMXpath($doc);

    $gallery_caption_class = 'blocks-gallery-caption';
    $gallery_caption = $doc_xpath->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' $gallery_caption_class ')]")->item(0);

    $title = '';

    if ($gallery_caption) {
      $title = $gallery_caption->textContent;
    }

    // echo '<textarea>';
    // print_r($block);
    // echo '</textarea>';

    $columns = isset($attrs['columns']) && !empty($attrs['columns']) ? $attrs['columns'] : 4;
    $ids = implode(',', $block['attrs']['ids']);
    $shortcode = sprintf('[sitekick_gallery ids="%s" columns="%s" title="%s"]', $ids, $columns, $title);
    $html = do_shortcode($shortcode);
  }

  return $html;
}, 10, 2);