<?php

  $field_groups = array(
    'page_content' => array(
      'menu_order' => 0,
      'position' => 'acf_after_title',
      'style' => 'default',
      'label_placement' => 'top',
      'instruction_placement' => 'label',
      'active' => 1,
      'description' => 'This is where all of the content for the page is entered',
      // ↓↓↓ This portion will need to be massaged as other scenarios surface
      'fields' => array(
          'page_layouts' => array(
              'type' => 'flexible_content',
              'button_label' => 'Add Section',
              'layouts' => array(
                  'hero_section' => array(
                      'section_image' => array(
                          'type' => 'image',
                          'return_format' => 'url',
                          'mime_types' => 'png,jpg,svg',
                          'wrapper' => array (
                              'width' => '50',
                          ),
                      ),
                      'section_icon' => array(
                          'type' => 'text',
                          'instructions' => 'use a <a href="http://fontawesome.io/cheatsheet" target="_blank">Font Awesome icon</a> instead of an image',
                          'placeholder' => 'Ex: fa-circle',
                          'wrapper' => array (
                            'width' => '50',
                          ),
                      ),
                      'section_alignment' => array(
                          'type' => 'radio',
                          'label' => 'Section Alignment',
                          'choices' => array (
                              'left' => 'Text Right',
                              'center' => 'Text Centered',
                              'right' => 'Text Left',
                          ),
                      ),
                      'section_content' => array(
                          'type' => 'code',
                          'label' => 'Content',
                          'theme' => 'monokai',
                          'language' => 'html',
                      ),
                      'section_modifiers' => array(
                          'type' => 'text',
                          'label' => 'Style Modifiers',
                          'instructions' => 'Add extra css classes, separated by spaces',
                          'placeholder' => 'Ex: extra-stuff special-class cool-modifier etc',
                      ),
                      'section_sold_in' => array(
                          'type' => 'true_false',
                          'label' => 'Include Badges?',
                          'instructions' => 'Toggle this to include "Available In" Badges',
                          'ui' => 1,
                      ),
                      'section_badges' => array(
                          'type' => 'select',
                          'label' => 'Badges',
                          'instructions' => 'Ctrl+Click (CMD+Option+Click on a Mac) to select more than one',
                          'multiple' => 1,
                          'choices' => array(
                            false => 'None',
                            'med' => 'Medicinal',
                            'rec' => 'Recreational',
                            'jar' => 'Jars',
                            'liquid' => 'Liquid',
                            'vape' => 'Cartridges',
                            'indica' => 'Indica',
                            'sativa' => 'Sativa',
                            'hybrid' => 'Hybrid',
                            'xact-xpose' => 'Xact & Xpose',
                          ),
                          'default_value' => array(
                            0 => false,
                          ),
                          'depends' => array('section_sold_in'),
                      ),
                      'film_grain' => array(
                          'type' => 'true_false',
                          'ui' => 1,
                    			'instructions' => 'Should there be a film grain effect?',
                          'wrapper' => array (
                            'width' => '30',
                          ),
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
                          'depends' => array('film_grain'),
                      ),
                      'colorize' => array(
                          'type' => 'true_false',
                          'ui' => 1,
                          'instructions' => 'Would you like to colorize this Hero Banner?',
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
                              'width' => '50',
                          ),
                          'depends' => array('colorize'),
                      ),
                      'colorize_options' => array(
                          'type' => 'select',
                          'label' => 'Color Pattern',
                          'return_format' => 'value',
                          'instructions' => 'Choose the color(s) you would like to use',
                          'choices' => array (
                              'hybrid' => 'Solid - Hybrid',
                              'sativa' => 'Solid - Sativa',
                              'indica' => 'Solid - Indica',
                              'darkblue' =>'Solid - Dark Blue',
                              'lightgreen' => 'Solid - Pastel Green',
                              'smoke' => 'Solid - Erie Black',
                              'hybridgradient' => 'Gradient - Hybrid',
                              'sativagradient' => 'Gradient - Sativa',
                              'indicagradient' => 'Gradient - Indica',
                              'heat' => 'Gradient - Miami Heat',
                              'midnight' => 'Gradient - Midnight',
                              'charcoal' => 'Gradient - Charcoal',
                              'custom' => 'Custom',
                          ),
                          'default_value' => array (
                              0 => 'custom',
                          ),
                          'wrapper' => array (
                              'width' => '50',
                          ),
                          'depends' => array('colorize'),
                      ),
                      'colorize_color_one' => array(
                          'label' => 'Color One',
                          'type' => 'color_picker',
                          'required' => 1,
                          'wrapper' => array (
                              'width' => '30',
                          ),
                          'depends' => array('colorize',array('colorize_options','==','custom')),
                      ),
                      'colorize_gradient' => array(
                          'label' => 'Two Colors ?',
                          'type' => 'true_false',
                          'ui' => 1,
                          'wrapper' => array (
                              'width' => '30',
                          ),
                          'depends' => array('colorize',array('colorize_options','==','custom')),
                      ),
                      'colorize_color_two' => array(
                          'label' => 'Color Two',
                          'type' => 'color_picker',
                          'required' => 1,
                          'wrapper' => array (
                              'width' => '30',
                          ),
                          'depends' => array('colorize',array('colorize_options','==','custom'),'colorize_gradient'),
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
                          'depends' => array('colorize',array('colorize_options','==','custom'),'colorize_gradient'),
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
                          'depends' => array('colorize',array('colorize_options','==','custom'),'colorize_gradient',array('colorize_gradient_type','!=','1')),
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
                          'depends' => array('colorize',array('colorize_options','==','custom'),'colorize_gradient',array('colorize_gradient_type','==','1')),
                      ),
                  ),
                  'cta_section' => array(
                      'section_title' => array(
                          'type' => 'text',
                          'placeholder' => '5 words MAX',
                      ),
                      'section_cta_links' => array(
                          'type' => 'relationship',
                          'label' => 'CTA Links',
                          'required' => 1,
                  				'min' => '3',
                  				'max' => '3',
                          'return_format' => 'id',
                          'post_type' => array(
                            0 => 'page',
                            1 => 'post',
                          ),
                          'filters' => array (
                  					0 => 'search',
                  					1 => 'post_type',
                          ),
                      ),
                      'section_modifiers' => array(
                          'type' => 'text',
                          'label' => 'Style Modifiers',
                          'instructions' => 'Add extra css classes, separated by spaces',
                          'placeholder' => 'Ex: extra-stuff special-class cool-modifier etc',
                      ),
                      'film_grain' => array(
                          'type' => 'true_false',
                          'ui' => 1,
                    			'instructions' => 'Should there be a film grain effect?',
                          'wrapper' => array (
                            'width' => '30',
                          ),
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
                          'depends' => array('film_grain'),
                      ),
                      'colorize' => array(
                          'type' => 'true_false',
                          'ui' => 1,
                          'instructions' => 'Would you like to colorize this Hero Banner?',
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
                              'width' => '50',
                          ),
                          'depends' => array('colorize'),
                      ),
                      'colorize_options' => array(
                          'type' => 'select',
                          'label' => 'Color Pattern',
                          'return_format' => 'value',
                          'instructions' => 'Choose the color(s) you would like to use',
                          'choices' => array (
                              'hybrid' => 'Solid - Hybrid',
                              'sativa' => 'Solid - Sativa',
                              'indica' => 'Solid - Indica',
                              'darkblue' =>'Solid - Dark Blue',
                              'lightgreen' => 'Solid - Pastel Green',
                              'smoke' => 'Solid - Erie Black',
                              'hybridgradient' => 'Gradient - Hybrid',
                              'sativagradient' => 'Gradient - Sativa',
                              'indicagradient' => 'Gradient - Indica',
                              'heat' => 'Gradient - Miami Heat',
                              'midnight' => 'Gradient - Midnight',
                              'charcoal' => 'Gradient - Charcoal',
                              'custom' => 'Custom',
                          ),
                          'default_value' => array (
                              0 => 'custom',
                          ),
                          'wrapper' => array (
                              'width' => '50',
                          ),
                          'depends' => array('colorize'),
                      ),
                      'colorize_color_one' => array(
                          'label' => 'Color One',
                          'type' => 'color_picker',
                          'required' => 1,
                          'wrapper' => array (
                              'width' => '30',
                          ),
                          'depends' => array('colorize',array('colorize_options','==','custom')),
                      ),
                      'colorize_gradient' => array(
                          'label' => 'Two Colors ?',
                          'type' => 'true_false',
                          'ui' => 1,
                          'wrapper' => array (
                              'width' => '30',
                          ),
                          'depends' => array('colorize',array('colorize_options','==','custom')),
                      ),
                      'colorize_color_two' => array(
                          'label' => 'Color Two',
                          'type' => 'color_picker',
                          'required' => 1,
                          'wrapper' => array (
                              'width' => '30',
                          ),
                          'depends' => array('colorize',array('colorize_options','==','custom'),'colorize_gradient'),
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
                          'depends' => array('colorize',array('colorize_options','==','custom'),'colorize_gradient'),
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
                          'depends' => array('colorize',array('colorize_options','==','custom'),'colorize_gradient',array('colorize_gradient_type','!=','1')),
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
                          'depends' => array('colorize',array('colorize_options','==','custom'),'colorize_gradient',array('colorize_gradient_type','==','1')),
                      ),
                  ),
              ),
          ),
      ),
      'location' => array (
        'post_type' => array(
          'page' => '==',
          // 'post' => '==',
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
