<?php
/**
 * The header for our flo page template (Probably more too).
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

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site do-scroll-magic">
	<!-- <a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'air' ); ?></a> -->

	<!-- Omnipresent contact bubble -->
	<div id="contact-bubble" class="fa-stack fa-lg">
		<i id="fa-bg" class="fa fa-fw fa-circle fa-stack-4x"></i>
  	<i id="fa-fg" class="fa fa-fw fa-paper-plane fa-stack-1x"></i>
	</div>

	<div id="contact-form" class="contact-form">
		<form id="inner-form"	method="post">
			<div class="container">
				<input name="first" placeholder="First Name" class="half form-listener" />
				<input name="last" placeholder="Last Name" class="half form-listener" />
			</div>
			<div class="container">
				<input name="email" placeholder="Email" class="form-listener" />
			</div>
			<div class="container">
				<textarea name="message" placeholder="What's on your mind?" class="form-listener"></textarea>
			</div>
		</form>
	</div>

	<?php get_template_part( 'template-parts/nav', 'header' ); ?>

	<div id="content" class="site-content">
		<?php get_template_part( 'template-parts/hero', 'banner' ); ?>
