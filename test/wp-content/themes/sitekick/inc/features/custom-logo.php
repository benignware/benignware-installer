<?php

use function benignware\sitekick\get_asset;

add_filter( 'get_custom_logo', function($html) {
  if (!has_custom_logo()) {
    $default = get_asset('img/logo.{jpg,png,gif,svg}');
    $extension = pathinfo($path, PATHINFO_EXTENSION);

    if ($default) {
      $html = sprintf('<a href="%s" class="custom-logo-link"><img class="custom-logo" src="%s"/></a>', home_url(), $default);
    }
  }

  // Parse DOM
  $doc = new DOMDocument();
  @$doc->loadHTML('<?xml encoding="utf-8" ?>' . $html );
  $xpath = new DOMXpath($doc);

  $img = $doc->getElementsByTagName('img')->item(0);

  if ($img) {
    $src = $img->getAttribute('src');
    $file = preg_replace('~^' . preg_quote(site_url(), '~') . '/~', ABSPATH, preg_replace('~[?#].*$~', '', $src));
		$ext = pathinfo($file, PATHINFO_EXTENSION);

    if ($ext === 'svg' && file_exists($file)) {
      $svg = file_get_contents($file);

      if ($svg) {
        $svg = preg_replace('~^\s*<?xml[^>]*>\s*~', '', $svg);
        $placeholder = uniqid();
        $img->parentNode->insertBefore($doc->createTextNode($placeholder), $img);
        $img->parentNode->removeChild($img);

        $html = preg_replace('~(?:<\?[^>]*>|<(?:!DOCTYPE|/?(?:html|head|body))[^>]*>)\s*~i', '', $doc->saveHTML());
        $html = str_replace($placeholder, $svg, $html);
      }
    }
  }

  return $html;
});

// add_filter( 'wp_get_attachment_image_src', function($image, $attachment_id, $size, $icon ) {
//   return $image;
// }, 10, 4);