<?php
// Customize Basic Contact Form
add_filter('shortcode_atts_basic_contact_form', function($out, $pairs, $atts, $shortcode) {
  return array_merge($out, array(
    'template' => get_theme_file_path() . '/contact-form.php',
    'theme' => array(
      'classes' => array(
        'bcf-form' => 'needs-validation',
        'is-invalid' => 'was-validated',
        'bcf-field' => 'mb-3',
        'bcf-field-checkbox' => 'form-check',
        'bcf-input' => 'form-control',
        'bcf-textarea' => 'form-control',
        'bcf-submit-button' => 'btn btn-primary',
        'bcf-message' => 'invalid-feedback',
        'bcf-checkbox-label' => 'form-check-label',
        'bcf-checkbox' => 'form-check-input'
      )
    )
  ), $atts);
}, 10, 4);