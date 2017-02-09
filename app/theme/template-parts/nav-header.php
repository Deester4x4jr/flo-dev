<header id="masthead" class="site-header">

  <div class="container">

    <?php include_menu('header_left', 2, 'underliner', 'header-nav-left', 'nav-collapse'); ?>

    <div class="site-branding">
      <p class="site-title" title="<?php bloginfo( 'name' ); ?>"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><img class="logo" src="<?php echo get_template_directory_uri() . '/svg/logo.svg'; ?>" /></a></p>
    </div>

    <?php include_menu('header_right', 2, 'underliner', 'header-nav-right', 'nav-collapse'); ?>

    <button id="nav-toggle" class="nav-toggle" aria-controls="nav" aria-expanded="false"><span class="burger-icon"></span> <span id="nav-toggle-label"><?php esc_html_e( 'Menu', 'air' ); ?></span></button>

  </div><!-- .container -->

</header><!-- #masthead -->
