<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package aberdeen
 */

?>
</div><!-- .row -->
</div><!-- .container -->
	</div><!-- #content -->

<footer id="colophon" class="site-footer" role="contentinfo">
    <!-- #top-footer -->
    <?php get_sidebar('footer'); ?>


    <div id="bottom-footer">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-lg-6">
                    <?php if (has_nav_menu('footer-menu', 'aberdeen')) { ?>
                        <nav role="navigation">
                            <?php wp_nav_menu(array(
                                    'container' => '',
                                    'menu_class' => 'footer-menu',
                                    'theme_location' => 'footer-menu')
                            );
                            ?>
                        </nav>
                    <?php } ?>
                </div>
                <div class="col-md-6 col-lg-6">
                    <p class="pull-right">&copy; <?php _e('Copyright', 'aberdeen'); ?> <?php echo date('Y'); ?> - <a
                                href="<?php echo home_url(); ?>/" title="<?php bloginfo('name'); ?>"
                                rel="home"><?php bloginfo('name'); ?></a></p>
                </div>
            </div><!-- .row -->
        </div><!-- .container -->


        <div class="container">
            <div class="row">
                <div class="col-md-12 text-right">
				    <?php $args = array(
					    'theme_location' => 'social',
					    'container' => 'div',
					    'container_id' => 'menu-social',
					    'container_class' => 'menu-social',
					    'menu_id' => 'menu-social-items',
					    'menu_class' => 'menu-items',
					    'depth' => 1,
					    'link_before' => '<span class="screen-reader-text">',
					    'link_after' => '</span>',
					    'fallback_cb' => '',
				    );
				    if (has_nav_menu('social')) {
					    wp_nav_menu($args);
				    }
				    ?>
                </div>
            </div><!-- .row -->
        </div><!-- .container -->

    </div><!-- #bottom-footer -->

</footer><!-- #colophon -->
</div><!-- #page -->
<div class="scroll-to-top"><i class="fa fa-angle-up"></i></div>
<?php wp_footer(); ?>

</body>
</html>