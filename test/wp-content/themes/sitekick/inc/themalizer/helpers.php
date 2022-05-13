<?php

function hex2rgba($hex) {
	$hex = str_replace("#", "", $hex);
	
	switch (strlen($hex)) {
		case 3 : 
			$r = hexdec(substr($hex, 0, 1).substr($hex, 0, 1));
			$g = hexdec(substr($hex, 1, 1).substr($hex, 1, 1));
			$b = hexdec(substr($hex, 2, 1).substr($hex, 2, 1));
			$a = 1;
			break;
		case 6 :
			$r = hexdec(substr($hex, 0, 2));
			$g = hexdec(substr($hex, 2, 2));
			$b = hexdec(substr($hex, 4, 2));
			$a = 1;
			break;
		case 8 :
			$a = hexdec(substr($hex, 0, 2)) / 255;
			$r = hexdec(substr($hex, 2, 2));
			$g = hexdec(substr($hex, 4, 2));
			$b = hexdec(substr($hex, 6, 2));
			break;
	}
	$rgba = array($r, $g, $b, $a);

  return 'rgba('.implode(', ', $rgba).')';
}

function rgba2hex($r, $g, $b, $a = 1) {
  if (!is_numeric($r)) {
    $string = $r;
    $rgba  = array();
    $hex   = '';
    $regex = '#\((([^()]+|(?R))*)\)#';

    if (preg_match_all($regex, $string ,$matches)) {
      $rgba = explode(',', implode(' ', $matches[1]));
    } else {
      $rgba = explode(',', $string);
    }
  } else {
    $rgba = [$r, $g, $b, $a];
  }
	
	$rr = sprintf('%02s', dechex($rgba[0]));
	$gg = sprintf('%02s', dechex($rgba[1]));
	$bb = sprintf('%02s', dechex($rgba[2]));

  if (isset($rgba[3]) && is_numeric($a) && floatval($a) != 1) {
    $aa = dechex($rgba[3] * 255);
	
    return strtoupper("#$rr$gg$bb$aa");
  }
	
	return strtoupper("#$rr$gg$bb");
}

function rgba($string, $alpha=1.0) {
  if (strpos(trim($string), 'rgb') === 0) {
    $match = preg_match('/rgba?\(\s?([0-9]{1,3}),\s?([0-9]{1,3}),\s?([0-9]{1,3})(?:,\s?([0-9.]+))?/i', $string, $rgba);

    if ($match) {
      list(,$r, $g, $b, $a) = $rgba;

      if (!is_numeric($a)) {
        $a = 1;
      }

      return [$r, $g, $b, $a];
    }
  }

  $string = trim($string, "\t\n\r\0\x0B#");

  $rgb = [];
  switch(strlen($string)) {
      case 3:
      for ($i = 0; $i < 3; $i++) {
          $rgb[] = hexdec($string[$i] . $string[$i]);
      }
      break;
      case 6:
      for($i = 0; $i < 6; $i += 2) {
          $rgb[] = hexdec(substr($string, $i, 2));
      }
      break;
      default:
      throw new Exception("Invalid format");
  }

  if (is_string($alpha)) {
    $alpha = floatval($alpha);
  }

  $alpha = min([1.0, $alpha]);
  $alpha = strval($alpha);
  $alpha = trim($alpha, '0');
  $alpha = rtrim($alpha, '.');

  if (!is_numeric($a)) {
    $a = 1;
  }

  return [ $rgb[0], $rgb[1], $rgb[2], $alpha ];
}