<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package air
 */

?>

</div>

<footer class="site-footer">

	<div class="container">

		<!-- Left Side Footer Menu -->
		<?php include_menu('footer_left', 1, 'underliner', 'footer-nav-left', 'nav-collapse'); ?>
		<!-- End Left Side Footer Menu -->

		<div class="site-info text-center">

			<!-- Company Logo -->
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><img class="logo" src="http://flo.dev/wp-content/themes/flo-theme-2017/svg/logo.svg"></a>
			<!-- End Company Logo -->

			<!-- Made in Colorado -->
			<div class="colorado">
				<img src="<?php echo get_template_directory_uri() . '/svg/produced-in-colorado-1.svg'; ?>" />
			</div>
			<!-- End Made in Colorado -->

			<!-- SoMe Icons -->
			<ul class="some-list">
				<li>
					<a href="http://www.twitter.com" target="blank">
						<span class="fa-stack fa-lg">
							<i class="fa fa-twitter fa-stack-1x fa-inverse"></i>
						</span>
					</a>
				</li>
				<li>
					<a href="http://www.instagram.com" target="blank">
						<span class="fa-stack fa-lg">
							<i class="fa fa-instagram fa-stack-1x fa-inverse"></i>
						</span>
					</a>
				</li>
				<li>
					<a href="http://www.facebook.com" target="blank">
						<span class="fa-stack fa-lg">
							<i class="fa fa-facebook fa-stack-1x fa-inverse"></i>
						</span>
					</a>
				</li>
			</ul>
			<!-- End SoMe Icons -->

		</div><!-- .site-info -->

		<!-- Right Side Footer Menu -->
		<?php include_menu('footer_right', 1, 'underliner', 'footer-nav-left', 'nav-collapse text-right'); ?>
		<!-- End Right Side Footer Menu -->

		<div class="shoutout">
			<i class="fa fa-code color-red"></i> with <i class="fa fa-laptop color-off-white"></i> by <a class="underliner" href="mailto:josh@thaw.io">thaw.io</a>
		</div>

	</div>

	<div class="divider"></div>

</footer><!-- #colophon -->

</div><!-- #page -->

<?php wp_footer(); ?>

<a href="#page" class="top"><span class="screen-reader-text"><?php echo esc_html_e('Back to top', 'air'); ?></span><?php echo file_get_contents( esc_url( get_theme_file_uri( '/svg/chevron-up.svg' ) ) ); ?></a>

</body>
</html>
