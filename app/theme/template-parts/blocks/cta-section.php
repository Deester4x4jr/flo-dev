<?php
/**
 *
 * Flo CTA Banner Template File
 *
 * @package air
 *
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

  $main_class = 'cta-section ' . ' cta-section-' . get_post_type();

  foreach (get_sub_field('section_cta_links') as $id) {
    $cta_data[$id] = array(
      'title' => ( ( get_post_type($id) == 'page' ) ? get_field('page_title',$id) : get_the_title($id) ),
      'meta' => get_post_meta($id, '_yoast_wpseo_metadesc', true),
      'image' => get_the_post_thumbnail_url($id,'medium'),
      'link' => get_permalink($id),
    );
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
<div class="container">
    <h3><?php the_sub_field('section_title'); ?></h3>
    <?php foreach ($cta_data as $id=>$data) : ?>

    <article class="cta-card" title="<?php echo $data['title']; ?>">
      <a href="<?php echo $data['link']; ?>" target="_blank" alt="<?php echo $data['meta']; ?>">
        <h4><?php echo $data['title']; ?></h4>
        <p class="clamp"><?php echo $data['meta']; ?></p>
        <div class="bug"><i class="fa fa-fw fa-arrow-right fa-lg"></i></div>
        <div class="card-bkg" style="background-image: url(<?php echo $data['image']; ?>);"></div>
      </a>
    </article>

  <?php endforeach; ?>
</div>

  <?php if (get_sub_field('film_grain')) : ?>
    <div class="hero-film" style="opacity: <?php the_field('film_grain_level'); ?>;"></div>
  <?php endif; ?>

  <?php if (get_sub_field('colorize')) : ?>
    <div class="hero-color <?php echo $color_class; ?>" style="<?php echo $color_style; ?>"></div>
  <?php endif; ?>

</section>
