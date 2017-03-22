<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package aberdeen
 */

get_header(); ?>
    <div class="container">
    <div class="row">
    <div id="primary" class="content-area <?php echo (is_active_sidebar( 'sidebar-blog') ? get_theme_mod('blog_layout_setting', 'sidebar-right'):'no-sidebar' ); ?>">
		<main id="main" class="site-main" role="main">

		<?php
		while ( have_posts() ) : the_post();

			get_template_part( 'template-parts/content', get_post_format() );

            bootstrap_the_post_navigation();

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		endwhile; // End of the loop.
		?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar('blog');
get_footer();