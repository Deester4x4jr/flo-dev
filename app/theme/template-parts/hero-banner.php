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

  $main_class = 'hero' . ( is_front_page() ? ' hero-front' : ( is_page() ? ' hero-page' : 'hero-' . get_post_type() ) );
  $url = get_field('hero_image');

  if (get_field('colorize')) {

    $color_style = "opacity: " . get_field('colorize_level') . ";";

    if (get_field('colorize_options') == 'custom') {

      $color_1 = get_field('colorize_color_one');

      if ( get_field('colorize_gradient') ) {

        $color_2 = get_field('colorize_color_two');
        $gradient_type = ( get_field('colorize_gradient_type') ? 'radial' : 'linear' );
        $gradient = str_replace('[color_2]', $color_2, str_replace('[color_1]', $color_1, $directions[get_field('gradient_' . $gradient_type . '_options')]));
        $color_style = $color_style . " background-image: " . $gradient;
        $color_class = ' hero-' . $gradient_type;
      } else {

        $color_style = $color_style . " background: " . $color_1;
      }
    } else {

      $color_class = 'hero-' . get_field('colorize_options');
    }
  }

?>
<div class="<?php echo $main_class; ?>">

  <div class="page-titles">
    <h1 id="page-title"><?php the_field('page_title'); ?></h1>
    <h2 id="sub-title"><?php the_field('page_sub_title'); ?></h2>
  </div>

  <?php if (get_field('custom_hero_banner')) : ?>

    <?php if (get_field('film_grain')) : ?>
      <div class="hero-film" style="opacity: <?php the_field('film_grain_level'); ?>;"></div>
    <?php endif; ?>

    <?php if (get_field('colorize')) : ?>
      <div class="hero-color <?php echo $color_class; ?>" style="<?php echo $color_style; ?>"></div>
    <?php endif; ?>

    <?php if ($url) : ?>
      <div class="hero-image" style="background-image: url(<?php echo $url; ?>);"></div>
    <?php endif; ?>

  <?php else : ?>
    <!-- Do Defaults here -->
  <?php endif; ?>
  <!-- <div class="shade"></div> -->
</div>
