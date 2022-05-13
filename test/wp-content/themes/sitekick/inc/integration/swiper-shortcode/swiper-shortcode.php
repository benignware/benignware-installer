<?php

add_filter('swiper_options', function($options) {
  $slides_per_view = $options['slides_per_view'];
  $breakpoints = $options['breakpoints'] ?: [];

  if ($slides_per_view > 4) {
    $breakpoints = $breakpoints + [
      '576' => [
        'slides_per_view' => 1.5,
        'centered_slides' => true,
        'slides_per_column' => 1
      ]
    ];
    $breakpoints = $breakpoints + [
      '768' => [
        'slides_per_view' => 2,
        'centered_slides' => !! $options['centered_slides']
      ],
      '992' => [
        'slides_per_view' => 4,
        'slides_per_column' => $options['slides_per_column'] ?: 1
      ]
    ];
  } else if ($slides_per_view > 1) {
    $breakpoints = $breakpoints + [
      '576' => [
        'slides_per_view' => 1,
        'slides_per_column' => 1
      ]
    ];
    $breakpoints = $breakpoints + [
      '768' => [
        'slides_per_view' => 2
      ],
      '992' => [
        'slides_per_view' => 4,
        'slides_per_column' => $options['slides_per_column'] ?: 1
      ]
    ];
  }

	$options = array_merge(array(
    'watch_overflow' => true,
    'theme' => 'gray-500',
    'breakpoints' => $breakpoints
  ), $options);

  return $options;
});