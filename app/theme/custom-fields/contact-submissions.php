<?php

  $field_groups = array(
    'contacts' => array(
      'menu_order' => 0,
      'position' => 'acf_after_title',
      'style' => 'default',
      'label_placement' => 'top',
      'instruction_placement' => 'label',
      'active' => 1,
      'description' => 'Adds fields to the "Contacts" custom post type',
      'fields' => array(
        'contact_first_name' => array(
          'type' => 'text',
          'label' => 'First Name',
        ),
        'contact_last_name' => array(
          'type' => 'text',
          'label' => 'Last Name',
        ),
        'contact_email' => array(
          'type' => 'text',
          'label' => 'Email',
        ),
        'contact_message' => array(
          'type' => 'textarea',
          'label' => 'Message',
        ),
      ),
      'location' => array (
        'post_type' => array(
          'contacts' => '==',
        ),
      ),
    ),
  );

  $field_groups = construct_acf_array($field_groups);

  foreach ($field_groups as $field_group) {
    acf_add_local_field_group($field_group);
  }

?>
