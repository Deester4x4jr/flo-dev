<?php

  $field_groups = array(
    'some_widget' => array(
      'menu_order' => 2,
      'position' => 'acf_after_title',
      'style' => 'default',
      'label_placement' => 'top',
      'instruction_placement' => 'label',
      'active' => 1,
      'description' => 'Add This to display an Instagram Feed',
      // ↓↓↓ This portion will need to be massaged as other scenarios surface
      'fields' => array(
        'display_feed' => array(
          'type' => 'true_false',
          'label' => 'Display the feed?',
          'ui' => 1,
        ),
        'feed_settings' => array(
          'type' => 'select',
          'return_format' => 'value',
          'choices' => array (
    				'default' => 'Default settings',
    			),
    			'default_value' => array (
    				0 => 'default',
      		),
          'depends' => array('display_feed'),
        ),
      ),
      'location' => array (
        'post_type' => array(
          'page' => '==',
        ),
      ),
      // ↑↑↑ This portion will need to be massaged as other scenarios surface
    ),
  );

  $field_groups = construct_acf_array($field_groups);

  foreach ($field_groups as $field_group) {
    acf_add_local_field_group($field_group);
  }

?>
