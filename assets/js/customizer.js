/**
 * Customizer JS
 *
 * Reloads changes on Theme Customizer Preview asynchronously for better usability
 *
 * @package Pocono Pro
 */

( function( $ ) {

	// Add Empty CSS area.
	var colors = $( '#pocono-pro-custom-colors-css' );

	if ( ! colors.length ) {
		colors = $( 'body' ).append( '<style type="text/css" id="pocono-pro-custom-colors-css"></style>' ).find( '#pocono-pro-custom-colors-css' );
	}

	/* Top Navigation Color Option */
	wp.customize( 'pocono_theme_options[top_navi_color]', function( value ) {
		value.bind( function( newval ) {
			$( '.top-navigation-menu ul' )
				.css( 'background', newval );
			$( '.top-navigation-menu > a, .top-navigation-toggle:after, .top-navigation-menu .submenu-dropdown-toggle:before' )
				.hover( function() { $( this ).css( 'color', newval ); },
					function() { $( this ).css( 'color',  '#222222' ); }
				);
		} );
	} );

	/* Main Navigation Primary Color Option */
	wp.customize( 'pocono_theme_options[navi_primary_color]', function( value ) {
		value.bind( function( newval ) {
			$( '.primary-navigation-wrap, .main-navigation-toggle' )
				.css( 'background', newval );
		} );
	} );

	/* Main Navigation Secondary Color Option */
	wp.customize( 'pocono_theme_options[navi_secondary_color]', function( value ) {
		value.bind( function( newval ) {
			$( '.main-navigation-menu ul' )
				.css( 'background', newval );
			$( '.main-navigation-toggle' )
				.hover( function() { $( this ).css( 'background', newval ); },
					function() { $( this ).css( 'background',  '#222222' ); }
				);
		} );
	} );

	/* Widgt Title Color Option */
	wp.customize( 'pocono_theme_options[widget_title_color]', function( value ) {
		value.bind( function( newval ) {
			$( '.page-header .archive-title, .comments-header .comments-title, .comment-reply-title span, .widget-title, .widget-title a' )
				.not( $( '.footer-widgets .widget-title' ) )
				.css( 'color', newval );
		} );
	} );

	/* Footer Color Option */
	wp.customize( 'pocono_theme_options[footer_color]', function( value ) {
		value.bind( function( newval ) {
			$( '.footer-wrap, .footer-widgets-background' )
				.css( 'background', newval );
		} );
	} );

	/* Theme Fonts */
	wp.customize( 'pocono_theme_options[text_font]', function( value ) {
		value.bind( function( newval ) {

			// Embed Font.
			var fontFamilyUrl = newval.split( " " ).join( "+" );
			var googleFontPath = "http://fonts.googleapis.com/css?family=" + fontFamilyUrl + ":400,700";
			var googleFontSource = "<link id='pocono-pro-custom-text-font' href='" + googleFontPath + "' rel='stylesheet' type='text/css'>";
			var checkLink = $( "head" ).find( "#pocono-pro-custom-text-font" ).length;

			if (checkLink > 0) {
				$( "head" ).find( "#pocono-pro-custom-text-font" ).remove();
			}
			$( "head" ).append( googleFontSource );

			// Set CSS.
			$( 'body, input, select, textarea' )
				.css( 'font-family', newval );

		} );
	} );

	wp.customize( 'pocono_theme_options[title_font]', function( value ) {
		value.bind( function( newval ) {

			// Embed Font.
			var fontFamilyUrl = newval.split( " " ).join( "+" );
			var googleFontPath = "http://fonts.googleapis.com/css?family=" + fontFamilyUrl + ":400,700";
			var googleFontSource = "<link id='pocono-pro-custom-title-font' href='" + googleFontPath + "' rel='stylesheet' type='text/css'>";
			var checkLink = $( "head" ).find( "#pocono-pro-custom-title-font" ).length;

			if (checkLink > 0) {
				$( "head" ).find( "#pocono-pro-custom-title-font" ).remove();
			}
			$( "head" ).append( googleFontSource );

			// Set CSS.
			$( '.site-title, .page-title, .entry-title, .more-link, .infinite-scroll #infinite-handle span, button, input[type="button"], input[type="reset"], input[type="submit"]' )
				.css( 'font-family', newval );

		} );
	} );

	wp.customize( 'pocono_theme_options[navi_font]', function( value ) {
		value.bind( function( newval ) {

			// Embed Font.
			var fontFamilyUrl = newval.split( " " ).join( "+" );
			var googleFontPath = "http://fonts.googleapis.com/css?family=" + fontFamilyUrl + ":400,700";
			var googleFontSource = "<link id='pocono-pro-custom-navi-font' href='" + googleFontPath + "' rel='stylesheet' type='text/css'>";
			var checkLink = $( "head" ).find( "#pocono-pro-custom-navi-font" ).length;

			if (checkLink > 0) {
				$( "head" ).find( "#pocono-pro-custom-navi-font" ).remove();
			}
			$( "head" ).append( googleFontSource );

			// Set CSS.
			$( '.main-navigation-menu a, .main-navigation-toggle, .header-bar-text, .top-navigation-menu a, .footer-navigation-menu a' )
				.css( 'font-family', newval );

		} );
	} );

	wp.customize( 'pocono_theme_options[widget_title_font]', function( value ) {
		value.bind( function( newval ) {

			// Embed Font.
			var fontFamilyUrl = newval.split( " " ).join( "+" );
			var googleFontPath = "http://fonts.googleapis.com/css?family=" + fontFamilyUrl + ":400,700";
			var googleFontSource = "<link id='pocono-pro-custom-widget-title-font' href='" + googleFontPath + "' rel='stylesheet' type='text/css'>";
			var checkLink = $( "head" ).find( "#pocono-pro-custom-widget-title-font" ).length;

			if (checkLink > 0) {
				$( "head" ).find( "#pocono-pro-custom-widget-title-font" ).remove();
			}
			$( "head" ).append( googleFontSource );

			// Set CSS.
			$( '.page-header .archive-title, .comments-header .comments-title, .comment-reply-title span,.widget-title' )
				.css( 'font-family', newval );

		} );
	} );

} )( jQuery );
