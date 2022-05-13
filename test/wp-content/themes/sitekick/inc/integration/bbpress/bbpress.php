<?php

require_once 'functions.php';

// add_filter('bbp_get_topic_tag_description', function($retval, $r) {
//   return $retval . '*TEST*';
// });

add_filter('bbp_before_get_single_forum_description_parse_args', function($r) {
  return array_merge($r, [
    'before'    => '<div class="bbp-template-notice info alert alert-info"><ul class="list-unstyled m-0"><li class="bbp-forum-description">',
		'after'     => '</li></ul></div>',
  ]);
});

add_filter('bbp_before_get_single_forum_description_parse_args', function($r) {
  return array_merge($r, [
    'before'    => '<div class="bbp-template-notice info alert alert-info"><ul class="list-unstyled m-0"><li class="bbp-forum-description">',
		'after'     => '</li></ul></div>',
  ]);
});


add_filter('bbp_get_breadcrumb', function($trail) {
  // Parse DOM
  $doc = new DOMDocument();
  @$doc->loadHTML('<?xml encoding="utf-8" ?>' . $trail );
  $doc_xpath = new DOMXpath($doc);

  // Remove empty items
  $bootstrap_breadcrumb_item_class = 'breadcrumb-item';
  $items = $doc_xpath->query('//*[contains(concat(" ", normalize-space(@class), " "), " ' . $bootstrap_breadcrumb_item_class . ' ")]');
  
  foreach ($items as $item) {
    if (strlen(trim($item->textContent)) === 0) {
      $item->parentNode->removeChild($item);
    }
  }

  // Handle separators
  $bbp_separator_class = 'bbp-breadcrumb-sep';
  $separators = $doc_xpath->query('//*[contains(concat(" ", normalize-space(@class), " "), " ' . $bbp_separator_class . ' ")]');
  
  if ($separators->length > 0) {
    // Extract separator
    $separator_text = $separators->item(0)->textContent;

    // Remove separator elements
    foreach ($separators as $separator) {
      $separator->parentNode->removeChild($separator);
    }
  }

  // Apply separator to breadcrumb wrapper
  if ($separator) {
    $bootstrap_breadcrumb_class = 'breadcrumb';
    $wrapper = $doc_xpath->query('//*[contains(concat(" ", normalize-space(@class), " "), " ' . $bootstrap_breadcrumb_class . ' ")]')->item(0);
  
    if ($wrapper) {
      $style = $wrapper->getAttribute('style');
      $style = ($style ? $style . '; ' : '') . "--bs-breadcrumb-divider: '$separator_text'";
      $wrapper->setAttribute('style', $style);
    }
  }

  $trail = preg_replace('~(?:<\?[^>]*>|<(?:!DOCTYPE|/?(?:html|head|body))[^>]*>)\s*~i', '', $doc->saveHTML());

  return $trail;
});

add_filter('bbp_get_reply_author_link', function($author_link) {
  // Parse DOM
  $doc = new DOMDocument();
  @$doc->loadHTML('<?xml encoding="utf-8" ?>' . $author_link );
  $doc_xpath = new DOMXpath($doc);

  $img = $doc_xpath->query('//img')->item(0);

  if ($img) {
    $img->setAttribute('class', 'rounded-circle');
  }

  $bbp_author_link_class = 'bbp-author-link';
  $container = $doc_xpath->query('//*[contains(concat(" ", normalize-space(@class), " "), " ' . $bbp_author_link_class . ' ")]')->item(0);

  if ($container) {
    $container->setAttribute('class', $container->getAttribute('class') . ' d-flex flex-column align-items-center text-decoration-none');
  }

  $bbp_author_name_class = 'bbp-author-name';
  $author_name = $doc_xpath->query('//*[contains(concat(" ", normalize-space(@class), " "), " ' . $bbp_author_name_class . ' ")]')->item(0);

  // if ($author_name) {
  //   $heading = $doc->createElement('h5');
  //   $author_name->parentNode->insertBefore($heading, $author_name);
  //   $heading->appendChild($author_name);
  // }

  $bbp_author_role_class = 'bbp-author-role';
  $author_role = $doc_xpath->query('//*[contains(concat(" ", normalize-space(@class), " "), " ' . $bbp_author_role_class . ' ")]')->item(0);

  if ($author_role) {
    $author_role->setAttribute('class', $author_role->getAttribute('class') . ' text-muted text-center');
  }

  $author_link = preg_replace('~(?:<\?[^>]*>|<(?:!DOCTYPE|/?(?:html|head|body))[^>]*>)\s*~i', '', $doc->saveHTML());

  return $author_link;
});

add_filter('bbp_before_get_breadcrumb_parse_args', function($args) {
  return array_merge($args, [
    'before' => '<nav class="bbp-breadcrumb"><ul class="breadcrumb">',  
    'after' => '</ul></nav>',
    'sep_before' => '<span class="bbp-breadcrumb-sep">',  
    'sep_after' => '</span>',  
    'crumb_before' => '<li class="breadcrumb-item">',
    'crumb_after' => '</li>',
    'current_before' => '<li class="breadcrumb-item active" aria-current="page">',
    'current_after' => '</li>'
  ]);
});

add_filter('bbp_before_list_forums_parse_args', function($args) {
  // return array_merge($args, [
  //   'before'              => '<div class="bbp-forums-list">',
  //   'after'               => '</div>',
  //   'link_before'         => '<span class="bbp-forum">',
  //   'link_after'          => '</span>',
  //   'count_before'        => ' (',
  //   'count_after'         => ')',
  //   'count_sep'           => ', ',
  //   'separator'           => ', ',
  //   'forum_id'            => '',
  //   'show_topic_count'    => true,
  //   'show_reply_count'    => true,
  // ]);
  return array_merge($args, [
    'before' => '<div class="bbp-forums-list">',
    'after'  => '</div>',
    'link_before' => '<span class="bbp-forum">',
    'link_after' => '</span>',
    'show_topic_count' => false,
    'show_reply_count' => false,
    'separator' => ', ',
  ]);
});


add_filter( 'bbp_default_styles', function($defaults) {
  unset ($defaults['bbp-default']);

  return $defaults ;
});

add_filter( 'bbp_get_user_edit_profile_url', function($url) {
  if (function_exists( 'wc_get_account_endpoint_url' )) {
    $url = wc_get_account_endpoint_url('dashboard');
  }

  return $url;
});



