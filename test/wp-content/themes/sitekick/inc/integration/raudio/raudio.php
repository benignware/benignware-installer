<?php

// if ( !is_plugin_active('raudio')) {
//   return;
// }

add_action('wp_enqueue_scripts', function() {
  $script = <<< EOT
  document.addEventListener('turbo:load', () => {
    console.log('LOAD');
    if (window.raudio) {
      window.raudio.render();
    }
  });

EOT;
  wp_register_script( 'sitekick-raudio', '', [], true);
  wp_enqueue_script( 'sitekick-raudio' );
  wp_add_inline_script( 'sitekick-raudio', $script);
});
