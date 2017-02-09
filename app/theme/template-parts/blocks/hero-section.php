<?php
/**
 * Flo Hero Banner Template File
 *
 * This is the default hero image for page templates, called
 * 'hero'. Strictly air specific.
 *
 * @package air
 */

  $directions = array(
      '↘' => 'linear-gradient(to bottom right, [color_1] 0%, [color_2] 100%)',
      '↙' => 'linear-gradient(to bottom left, [color_1] 0%, [color_2] 100%)',
      '↖' => 'linear-gradient(to bottom right, [color_2] 0%, [color_1] 100%)',
      '↗' => 'linear-gradient(to bottom left, [color_2] 0%, [color_1] 100%)',
      '→' => 'linear-gradient(to right, [color_1] 0%, [color_2] 100%)',
      '↓' => 'linear-gradient(to top, [color_2] 0%, [color_1] 100%)',
      '←' => 'linear-gradient(to right, [color_2] 0%, [color_1] 100%)',
      '↑' => 'linear-gradient(to top, [color_1] 0%, [color_2] 100%)',
      'normal' => 'radial-gradient([color_1] 0%, [color_2] 100%)',
      'reverse' => 'radial-gradient([color_2] 0%, [color_1] 100%)',
  );

  $badgeNames = array(
    'med' => 'Medicinal',
    'rec' => 'Recreational',
    'jar' => '1g Jars',
    'liquid' => 'Syringes',
    'vape' => 'Ceramic Vape Cartridges',
  );

  $main_class = 'hero-section hero-content-' . get_sub_field('section_alignment') . ' hero-section-' . get_post_type();
  $badges = get_sub_field('section_badges');
  $url = get_sub_field('section_image');
  if ( !$url ) {
    if ( get_sub_field('section_icon') ) {
      $icon = explode(' ',get_sub_field('section_icon'));
    } else {
      $url = 'https://placehold.it/1008x633.jpg/f0f8ff/020202?text=placeholder+image%0D1008px+x+633px';
    }
  }

  if (get_sub_field('colorize')) {

    $color_style = "opacity: " . get_sub_field('colorize_level') . ";";

    if (get_sub_field('colorize_options') == 'custom') {

      $color_1 = get_sub_field('colorize_color_one');

      if ( get_sub_field('colorize_gradient') ) {

        $color_2 = get_sub_field('colorize_color_two');
        $gradient_type = ( get_sub_field('colorize_gradient_type') ? 'radial' : 'linear' );
        $gradient = str_replace('[color_2]', $color_2, str_replace('[color_1]', $color_1, $directions[get_sub_field('gradient_' . $gradient_type . '_options')]));
        $color_style = $color_style . " background-image: " . $gradient;
        $color_class = ' hero-' . $gradient_type;
      } else {

        $color_style = $color_style . " background: " . $color_1;
      }
    } else {

      $color_class = 'hero-' . get_sub_field('colorize_options');
    }
  }

?>
<section class="<?php echo $main_class . ' ' . get_sub_field('section_modifiers'); ?>">
  <?php if ( (get_sub_field('section_sold_in')) && ($badges[0] != false) ) : ?>
    <div class="sold-in">
        <span><strong>Available in</strong></span>
        <?php foreach ($badges as $badge) : ?>
          <span class="<?php echo $badge; ?>" data-ot="<?php echo $badgeNames[$badge]; ?>" data-ot-style="glass" data-ot-target="true" data-ot-tip-joint="bottom" data-ot-delay="0" data-ot-group="sold-in"></span>
        <?php endforeach; ?>
    </div>
  <?php endif; ?>
  <div class="hero-image">

    <?php

      if ($url) {

        echo '<img src="'.$url.'" />';
      } elseif ($icon) {

        if ( count($icon) > 1 ) {

          $cnt = count($icon);

          echo '<span class="fa-stack">';

          foreach ($icon as $icn) {
            echo '<i class="fa fa-fw fa-stack-'.$cnt.' '.$icn.'"></i>';
            $cnt--;
          }

          echo '</span>';
        } else {

          echo '<i class="fa fa-fw '.$icon[0].'"></i>';
        }
      }
    ?>

  </div>

  <article class="section-content">
    <?php the_sub_field('section_content'); ?>
  </article>

  <?php if (get_sub_field('film_grain')) : ?>
    <div class="hero-film" style="opacity: <?php the_field('film_grain_level'); ?>;"></div>
  <?php endif; ?>

  <?php if (get_sub_field('colorize')) : ?>
    <div class="hero-color <?php echo $color_class; ?>" style="<?php echo $color_style; ?>"></div>
  <?php endif; ?>

</section>
