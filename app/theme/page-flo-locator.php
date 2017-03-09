<?php
/**
 *
 * Template Name: Flo Locator Template
 *
 * The template for displaying the Dispensary Locator Page.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package air
 */

get_header('flo-locator'); ?>

	<div id="primary" class="content-area">

		<main id="main" class="site-main google-maps">
			<?php get_template_part('template-parts/maps','form'); ?>
			<div id="map-box" class="hide">
				<?php get_template_part('template-parts/maps','block'); ?>
			</div>
			<div id="results-box"></div>
		</main><!-- #main -->

	</div><!-- #primary -->

<?php
get_sidebar();
get_footer('flo-locator');
