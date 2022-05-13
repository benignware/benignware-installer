<?php
use function benignware\sitekick\get_asset;

// Filter the avatar html
add_filter( 'get_avatar', function($avatar, $id_or_email, $size, $default) {
	$doc = new DOMDocument();
  @$doc->loadHTML('<?xml encoding="utf-8" ?>' . $avatar );

  $doc_xpath = new DOMXpath($doc);
  $img = $doc_xpath->query('//img')->item(0);
  
  if ($img) {
		$class = $img->getAttribute('class');
		$classes = array_unique(array_filter(explode(' ', $class)));
		$classes = apply_filters('sitekick_avatar_class', $classes, $class);
		$class = implode(' ', array_unique(array_filter($classes)));
    $img->setAttribute('class', $class);

		$src = $img->getAttribute('src');

		$file = preg_replace('~^' . preg_quote(site_url(), '~') . '/~', ABSPATH, preg_replace('~[?#].*$~', '', $src));
		$ext = pathinfo($file, PATHINFO_EXTENSION);

    if ($ext === 'svg' && file_exists($file)) {
      $svg = file_get_contents($file);

      if ($svg) {
				$svg = preg_replace('~^\s*<?xml[^>]*>\s*~', '', $svg);

				$svg_doc = new DOMDocument();
				@$svg_doc->loadXML($svg);

				$svg = $svg_doc->documentElement;
				$svg = $doc->importNode($svg, true);

				$svg->setAttribute('class', $img->getAttribute('class'));
				$svg->setAttribute('style', sprintf('width: %spx; height: %spx', $size, $size));

        $img->parentNode->insertBefore($svg, $img);
        $img->parentNode->removeChild($img);
      }
    }
	}

  $avatar = preg_replace('~(?:<\?[^>]*>|<(?:!DOCTYPE|/?(?:html|head|body))[^>]*>)\s*~i', '', $doc->saveHTML());

	return $avatar;
}, 10, 4);

add_filter( 'get_avatar_data', function($args) {
	return !$args['found_avatar'] ? array_merge($args, [
		'url'	=> get_asset('img/avatar.{jpg,png,gif,svg}')
	]) : $args;
});
