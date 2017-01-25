<?php
/**
 *
 * Template Name: Flo Page Template
 *
 * The primary template for displaying any post of type 'page'.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package air
 */

get_header('flo'); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

      <?php // get_template_part( 'template-parts/content', 'page' ); ?>
			<?php get_template_part('template-parts/page','blocks'); ?>
			<?php // get_template_part('template-parts/page','blocks'); ?>

			<?php
				// If comments are open or we have at least one comment, load up the comment template.
				// if ( comments_open() || get_comments_number() ) :
				// 	comments_template();
				// endif;
			?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer('flo');
