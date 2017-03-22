<?php
/**
 * aberdeen Theme Customizer
 *
 * @package aberdeen
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function aberdeen_customize_register( $wp_customize ) {
    $wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
    $wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
    $wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
}
add_action( 'customize_register', 'aberdeen_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function aberdeen_customize_preview_js() {
    wp_enqueue_script( 'aberdeen_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'aberdeen_customize_preview_js' );

/**
 * Enqueue the kirki stylesheet.
 */
function aberdeen_customizer_stylesheet() {
    wp_enqueue_style( 'aberdeen-kirki-customizer-css', get_template_directory_uri() . '/inc/kirkiassets/css/kirki-styles.css');
}
add_action( 'customize_controls_print_styles', 'aberdeen_customizer_stylesheet' );


/**
 * Add the theme configuration
 */
aberdeen_Kirki::add_config( 'aberdeen_theme', array(
    'option_type' => 'theme_mod',
    'capability'  => 'edit_theme_options',
) );

/********************************************************************************************************************
 * Add section for Site Layout, settings and controls
 *******************************************************************************************************************/

aberdeen_kirki::add_section( 'site_layout', array(
    'title'      => esc_attr__( 'Site Layout', 'aberdeen' ),
    'priority'   => 3,
    'capability' => 'edit_theme_options',
    'description' => __( 'From this panel you control the site layout.', 'aberdeen' ),
) );

/**
 * Add a Field to change the blog layout
 */
aberdeen_kirki::add_field( 'aberdeen', array(
    'type'        => 'radio-image',
    'setting'     => 'blog_layout_setting',
    'label'       => __( 'Blog Post Layout', 'aberdeen' ),
    'description' => __( 'Choose from a left sidebar layout, fullwidth layout, or a right sidebar layout.  Blog Sidebar widgets require to be added for sidebars to be shown', 'aberdeen' ),
    'section'     => 'site_layout',
    'default'     => 'sidebar-right',
    'priority'    => 10,
    'choices'     => array(
        'sidebar-left' => trailingslashit( get_template_directory_uri() ) . 'inc/kirkiassets/images/2cl.png',
        'no-sidebar' => trailingslashit( get_template_directory_uri() ) . 'inc/kirkiassets/images/1c.png',
        'sidebar-right' => trailingslashit( get_template_directory_uri() ) . 'inc/kirkiassets/images/2cr.png',
    ),
    'transport'   => 'postMessage',

));

/**
 * Add a Field to change the page layout
 */
aberdeen_kirki::add_field( 'aberdeen', array(
    'type'        => 'radio-image',
    'setting'     => 'page_layout_setting',
    'label'       => __( 'Page Layout', 'aberdeen' ),
    'description' => __( 'Choose from a left sidebar layout, fullwidth layout, or a right sidebar layout.  Page Sidebar widgets require to be added for sidebars to be shown', 'aberdeen' ),
    'section'     => 'site_layout',
    'default'     => 'no-sidebar',
    'priority'    => 10,
    'choices'     => array(
        'sidebar-left' => trailingslashit( get_template_directory_uri() ) . 'inc/kirkiassets/images/2cl.png',
        'no-sidebar' => trailingslashit( get_template_directory_uri() ) . 'inc/kirkiassets/images/1c.png',
        'sidebar-right' => trailingslashit( get_template_directory_uri() ) . 'inc/kirkiassets/images/2cr.png',
    ),
    'transport'   => 'postMessage',

));
