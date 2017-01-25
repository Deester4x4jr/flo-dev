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
<div id="page" class="site">
	<!-- <a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'air' ); ?></a> -->

	<header id="masthead" class="site-header">

		<div class="container">

			<div class="nav-left">
				<nav id="nav-left" class="nav-collapse">
					<!--  -->
				</nav>
			</div>

			<div class="site-branding">
				<p class="site-title" title="<?php bloginfo( 'name' ); ?>"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><img class="logo" src="<?php echo get_template_directory_uri() . '/svg/logo.svg'; ?>" /></a></p>
			</div>

			<div class="nav-right">
				<nav id="nav-right" class="nav-collapse">
					<!--  -->
				</nav>
			</div>

			<!-- <button id="nav-toggle" class="nav-toggle" aria-controls="nav" aria-expanded="false"><span class="burger-icon"></span> <span id="nav-toggle-label"><?php esc_html_e( 'Menu', 'air' ); ?></span></button> -->

			<!-- <nav id="nav" class="nav-collapse"> -->

				<?php
					// wp_nav_menu( array(
					// 	'theme_location'    => 'primary',
					// 	'container'       	=> false,
					// 	'depth'             => 4,
					// 	'menu_class'        => 'menu-items',
					// 	'menu_id' 					=> 'menu',
					// 	'echo'            	=> true,
					// 	'fallback_cb'       => 'wp_page_menu',
					// 	'items_wrap'      	=> '<ul class="%2$s" id="%1$s">%3$s</ul>',
					// 	'walker'            => new Air_Walker(),
					// 	)
					// );
				?>

			<!-- </nav> -->

		</div><!-- .container -->
	</header><!-- #masthead -->

	<div id="content" class="site-content">
    <?php //get_template_part( 'template-parts/hero', get_post_type() ); ?>
		<?php get_template_part( 'template-parts/blocks/hero', 'banner' ); ?>
