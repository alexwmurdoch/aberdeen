/**
 * File customizer.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {

	// Site title and description.
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a' ).text( to );
		} );
	} );
	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).text( to );
		} );
	} );

	// Header text color.
	wp.customize( 'header_textcolor', function( value ) {
		value.bind( function( to ) {
			if ( 'blank' === to ) {
				$( '.site-title a, .site-description' ).css( {
					'clip': 'rect(1px, 1px, 1px, 1px)',
					'position': 'absolute'
				} );
			} else {
				$( '.site-title a, .site-description' ).css( {
					'clip': 'auto',
					'position': 'relative'
				} );
				$( '.site-title a, .site-description' ).css( {
					'color': to
				} );
			}
		} );
	} );

    // Custom Logo.
    // wp.customize( 'logo_image', function( value ) {
    //     value.bind( function( to ) {
    //         if( to == '' ) {
    //             $(' #logo ').hide();
    //         } else {
    //             $(' #logo ').show();
    //             $(' #logo img').attr( 'src', to );
    //         }
    //     } );
    // });

    /**************************************************************************************************************
     * Site Layout
     *************************************************************************************************************/

    // Custom blog post Layout Options
    wp.customize( 'blog_layout_setting', function( value ) {
        value.bind( function( to ) {
            $( '#primary' ).removeClass( 'no-sidebar sidebar-left sidebar-right' );
            $( '#secondary' ).removeClass( 'no-sidebar sidebar-left sidebar-right' );
            $( '#primary' ).addClass( to );
            $( '#secondary' ).addClass( to );
        } );
    } );
    // Custom page Layout Options
    wp.customize( 'page_layout_setting', function( value ) {
        value.bind( function( to ) {
            $( '#primary' ).removeClass( 'no-sidebar sidebar-left sidebar-right' );
            $( '#secondary' ).removeClass( 'no-sidebar sidebar-left sidebar-right' );
            $( '#primary' ).addClass( to );
            $( '#secondary' ).addClass( to );
        } );
    } );


} )( jQuery );
