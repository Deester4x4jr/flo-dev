<?php
/**
 * The header for our flo locator page template (Probably more too).
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package air
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">

<!-- Generate favicons: http://realfavicongenerator.net/ -->
<link rel="icon" type="image/png" href="<?php echo esc_url( get_template_directory_uri() ); ?>/images/favicons/favicon.png" sizes="192x192">

<!-- Enqueu our script for doing the map locator -->
<?php
  wp_enqueue_script('custom-maps', get_template_directory_uri() . '/js/alt.js', array('jquery', 'simple-locator'),false,true);
?>

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page-loader" class="loader"></div>
<div id="page" class="site">
	<!-- <a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'air' ); ?></a> -->

  <!-- Omnipresent contact bubble -->
	<!-- <div class="contact-button fa-stack fa-lg">
		<i class="fa fa-fw fa-circle fa-stack-2x"></i>
  	<i class="fa fa-fw fa-paper-plane fa-stack-1x"></i>
	</div> -->

	<?php get_template_part( 'template-parts/nav', 'header' ); ?>

	<div id="content" class="site-content">
		<?php // get_template_part( 'template-parts/hero', 'banner' ); ?>
