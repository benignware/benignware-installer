<?php
if( function_exists('acf_add_local_field_group') ):
  acf_add_local_field_group(array(
    'key' => 'group_62116eaab978b',
    'title' => 'Membership Details',
    'fields' => array(
      array(
        'key' => 'field_62116f09ebf73',
        'label' => 'Membership Description',
        'name' => 'membership_description',
        'type' => 'textarea',
        'instructions' => 'Enter a short description for this membership plan',
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => array(
          'width' => '',
          'class' => '',
          'id' => '',
        ),
        'default_value' => '',
        'placeholder' => '',
        'maxlength' => '',
        'rows' => '',
        'new_lines' => '',
      ),
      array(
        'key' => 'field_621186652517a',
        'label' => 'Membership Features',
        'name' => 'membership_features',
        'type' => 'textarea',
        'instructions' => 'Separate features by line-break. Used to setup membership comparison table.',
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => array(
          'width' => '',
          'class' => '',
          'id' => '',
        ),
        'default_value' => '',
        'placeholder' => '',
        'maxlength' => '',
        'rows' => '',
        'new_lines' => '',
      ),
    ),
    'location' => array(
      array(
        array(
          'param' => 'post_type',
          'operator' => '==',
          'value' => 'wc_membership_plan',
        ),
      ),
    ),
    'menu_order' => 0,
    'position' => 'normal',
    'style' => 'default',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'hide_on_screen' => '',
    'active' => true,
    'description' => '',
    'show_in_rest' => 0,
  ));
endif;
