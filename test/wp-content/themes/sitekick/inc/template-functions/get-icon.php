<?php

namespace benignware\sitekick {
  function get_icon($name, $attrs = []) {
    $icon_class = sprintf('fa fa-%s', $name);

    $attrs['class'] = isset($attrs['class']) ? "$icon_class {$attrs['class']}" : $icon_class;

    $html = '<i';

    foreach ($attrs as $key => $value) {
      // echo 'ATTR: ' . $key . ' -> ' . $value;
      $html.= " $key=\"$value\"";
    }

    $html.= '></i>';

    return $html;
  } 
}
