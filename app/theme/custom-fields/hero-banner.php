<?php

  $field_groups = array(
    'hero_banner' => array(
      'menu_order' => 0,
      'position' => 'acf_after_title',
      'style' => 'default',
      'label_placement' => 'top',
      'instruction_placement' => 'label',
      'active' => 1,
      'description' => 'This will allow customizations to the Hero Banner at the top of the page',
      // ↓↓↓ This portion will need to be massaged as other scenarios surface
      'fields' => array(
          'page_title' => array(
              'type' => 'text',
              'required' => 1,
              'placeholder' => '5 words MAX',
          ),
          'page_sub_title' => array(
              'type' => 'text',
              'placeholder' => '8 words MAX',
          ),
          'custom_hero_banner' => array(
              'label' => 'Customize the Hero Banner?',
              'type' => 'true_false',
              'ui' => 1,
              'wrapper' => array (
                'width' => '30',
              ),
          ),
          'hero_image' => array(
              'type' => 'image',
              'return_format' => 'url',
        			'mime_types' => 'png,jpg,svg',
              'wrapper' => array (
                'width' => '60',
              ),
              'depends' => array('custom_hero_banner'),
          ),
          'film_grain' => array(
              'type' => 'true_false',
              'ui' => 1,
        			'instructions' => 'Should there be a film grain effect?',
              'wrapper' => array (
                'width' => '30',
              ),
              'depends' => array('custom_hero_banner'),
          ),
          'film_grain_level' => array(
              'type' => 'select',
              'return_format' => 'value',
              'instructions' => 'Please select how heavy of a grain effect you would like',
              'choices' => array (
        				'0.25' => 'Light',
        				'0.50' => 'Medium',
        				'0.75' => 'Heavy',
        				'1.00' => 'Strong',
        			),
        			'default_value' => array (
        				0 => '0.25',
        			),
              'wrapper' => array (
                'width' => '60',
              ),
              'depends' => array('custom_hero_banner','film_grain'),
          ),
          'colorize' => array(
              'type' => 'true_false',
              'ui' => 1,
              'instructions' => 'Would you like to colorize this Hero Banner?',
              'wrapper' => array (
                'width' => '30',
              ),
              'depends' => array('custom_hero_banner'),
          ),
          'colorize_level' => array(
              'type' => 'select',
              'return_format' => 'value',
              'instructions' => 'Please select how heavy the effect should be',
              'choices' => array (
                '0.25' => 'Light',
                '0.50' => 'Medium',
                '0.75' => 'Heavy',
                '1.00' => 'Strong',
              ),
              'default_value' => array (
                0 => '0.25',
              ),
              'wrapper' => array (
                'width' => '60',
              ),
              'depends' => array('custom_hero_banner','colorize'),
          ),
          'colorize_options' => array(
            'type' => 'select',
            'return_format' => 'value',
            'instructions' => 'Choose the color(s) you would like to use',
            'choices' => array (
                // Need to customize these with color combo options
                'green' => 'Solid - Green',
                'blue' => 'Solid - Blue',
                'aqua' => 'Gradient - Aqua',
                'heat' => 'Gradient - Heat',
                'midnight' => 'Gradient - Midnight',
                'charcoal' => 'Gradient - Charcoal',
                'custom' => 'Custom',
              ),
              'default_value' => array (
                0 => 'custom',
              ),
              'depends' => array('custom_hero_banner','colorize'),
          ),
          'colorize_color_one' => array(
              'label' => 'Color One',
              'type' => 'color_picker',
              'required' => 1,
              'wrapper' => array (
                'width' => '30',
              ),
              'depends' => array('custom_hero_banner','colorize',array('colorize_options','==','custom')),
          ),
          'colorize_gradient' => array(
              'label' => 'Two Colors ?',
              'type' => 'true_false',
              'ui' => 1,
              'wrapper' => array (
                'width' => '30',
              ),
              'depends' => array('custom_hero_banner','colorize',array('colorize_options','==','custom')),
          ),
          'colorize_gradient_type' => array(
              'label' => 'Gradient Type',
              'type' => 'true_false',
              'ui' => 1,
              'ui_on_text' => 'Radial',
              'ui_off_text' => 'Linear',
              'wrapper' => array (
                'width' => '30',
              ),
              'depends' => array('custom_hero_banner','colorize',array('colorize_options','==','custom'),'colorize_gradient'),
          ),
          'colorize_color_two' => array(
              'label' => 'Color Two',
              'type' => 'color_picker',
              'required' => 1,
              'wrapper' => array (
                'width' => '30',
              ),
              'depends' => array('custom_hero_banner','colorize',array('colorize_options','==','custom'),'colorize_gradient'),
          ),
          'gradient_linear_options' => array(
              'label' => 'Gradient Direction',
              'type' => 'select',
              'return_format' => 'value',
              'instructions' => 'Which direction should it go?',
              'choices' => array (
                '↘' => '↘ - Top-Left to Bottom-Right',
                '↙' => '↙ - Top-Right to Bottom-Left',
                '↖' => '↖ - Bottom-Right to Top-Left',
                '↗' => '↗ - Bottom-Left to Top-Right',
                '→' => '→ - Left to Right',
                '↓' => '↓ - Top to Bottom',
                '←' => '← - Right to Left',
                '↑' => '↑ - Bottom to Top',
              ),
              'default_value' => array (
                0 => '↘',
              ),
              'wrapper' => array (
                'width' => '60',
              ),
              'depends' => array('custom_hero_banner','colorize',array('colorize_options','==','custom'),'colorize_gradient',array('colorize_gradient_type','!=','1')),
          ),
          'gradient_radial_options' => array(
              'label' => 'Gradient Direction',
              'type' => 'select',
              'return_format' => 'value',
              'instructions' => 'From the center out, what order should the colors be in?',
              'choices' => array (
                'normal' => 'Color 1 to Color 2',
                'reverse' => 'Color 2 to Color 1',
              ),
              'default_value' => array (
                0 => 'normal',
              ),
              'wrapper' => array (
                'width' => '60',
              ),
              'depends' => array('custom_hero_banner','colorize',array('colorize_options','==','custom'),'colorize_gradient','colorize_gradient_type'),
          ),
      ),
      'location' => array (
        'post_type' => array(
          'page' => '==',
          'post' => '==',
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
