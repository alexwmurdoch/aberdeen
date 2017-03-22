<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Aberdeen
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="http://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
    <a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'aberdeen' ); ?></a>

    <header id="masthead" class="site-header" role="banner">
		<?php if ( get_header_image() ) { ?>
            <div class="site-branding" style="background-image: url(<?php header_image(); ?>)">
        <?php } else { ?>
            <div class="site-branding">
		<?php } ?>
                <?php aberdeen_display_logo(); ?>
				<?php
				if ( is_front_page() && is_home() ) : ?>
                    <h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"
                                              rel="home"><?php bloginfo( 'name' ); ?></a></h1>
				<?php else : ?>
                    <p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"
                                             rel="home"><?php bloginfo( 'name' ); ?></a></p>
					<?php
				endif;

				$description = get_bloginfo( 'description', 'display' );
				if ( $description || is_customize_preview() ) : ?>
                    <p class="site-description"><?php echo $description; /* WPCS: xss ok. */ ?></p>
					<?php
				endif; ?>
            </div><!-- .site-branding -->

            <nav class="navbar navbar-default" role=navigation" id="site-navigation">
                <div class="container">
                    <!-- note: when we use custom logo in navbar having a row pulls the logo too far left.  Lines up perfect without logo
						 Brand and toggle get grouped for better mobile display -->
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                                data-target="#main-menu"
                                aria-expanded="false" aria-controls="primary-menu">
                            <span class="sr-only">Toggle navigation</span><?php esc_html_e( 'Menu', 'eiene' ); ?> <i
                                    class="fa fa-bars"></i>
                        </button>
                        <a class="navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>"
                           rel="home">custom logo</a>
                    </div>
                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse" id="main-menu">
						<?php
						$args = array(
							'theme_location' => 'primary',
							'menu_id'        => 'primary-menu',
							'depth'          => 2,
							'container'      => false,
							'menu_class'     => 'nav navbar-nav navbar-right',
							'walker'         => new wp_bootstrap_navwalker()
						);
						if ( has_nav_menu( 'primary' ) ) {
							wp_nav_menu( $args );
						}
						?>
                    </div><!-- /.navbar-collapse -->
                </div><!-- /.container -->
            </nav><!-- #site-navigation -->
    </header><!-- #masthead -->

    <div id="content" class="site-content">
