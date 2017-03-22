<?php
/**
 * The sidebar containing the main widget area.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package bay3
 */

if ( ! is_active_sidebar( 'sidebar-blog' ) ) {
	return;
}
?>

<aside id="secondary" class="widget-area <?php echo get_theme_mod( 'blog_layout_setting', 'sidebar-right' ); ?>"  role="complementary">
	<?php dynamic_sidebar( 'sidebar-blog' ); ?>
</aside><!-- #secondary -->




