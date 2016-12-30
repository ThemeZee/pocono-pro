/**
 * Customizer JS
 *
 * Reloads changes on Theme Customizer Preview asynchronously for better usability
 *
 * @package Pocono Pro
 */

( function( $ ) {

	/* Header Color Option */
	wp.customize( 'pocono_theme_options[header_color]', function( value ) {
		value.bind( function( newval ) {
			$( '.site-header' )
				.css( 'background', newval );

			var textcolor;

			if( isColorDark( newval ) ) {
				textcolor = '#ffffff';
			} else {
				textcolor = '#000000';
			}

			$( '.site-title, .site-title a, .sidebar-navigation-toggle, .header-social-icons .social-icons-menu li a' )
				.css( 'color', textcolor );
			$('.site-title a, .sidebar-navigation-toggle, .header-social-icons .social-icons-menu li a')
				.hover( function() { $( this ).css( 'color', textcolor ); },
						function() { $( this ).css( 'color', textcolor ); }
				);
		} );
	} );

	/* Navigation Color Option */
	wp.customize( 'pocono_theme_options[navigation_color]', function( value ) {
		value.bind( function( newval ) {
			$( '.primary-navigation-wrap' )
				.css( 'background', newval );

			var textcolor;

			if( isColorDark( newval ) ) {
				textcolor = '#ffffff';
			} else {
				textcolor = '#000000';
			}

			$( '.main-navigation-menu > a' )
				.css( 'color', textcolor );
			$('.main-navigation-menu > a')
				.hover( function() { $( this ).css( 'color', textcolor ); },
						function() { $( this ).css( 'color', textcolor ); }
				);
		} );
	} );

	/* Footer Color Option */
	wp.customize( 'pocono_theme_options[footer_color]', function( value ) {
		value.bind( function( newval ) {
			$( '.footer-wrap' )
				.css( 'background', newval );

			var textcolor;

			if( isColorDark( newval ) ) {
				textcolor = '#ffffff';
			} else {
				textcolor = '#000000';
			}

			$( '.site-footer, .site-footer .site-info a, .footer-navigation-menu a' )
				.css( 'color', textcolor );
			$('.site-footer, .site-footer .site-info a, .footer-navigation-menu a')
				.hover( function() { $( this ).css( 'color', textcolor ); },
						function() { $( this ).css( 'color', textcolor ); }
				);
		} );
	} );

	/* Theme Fonts */
	wp.customize( 'pocono_theme_options[text_font]', function( value ) {
		value.bind( function( newval ) {

			// Embed Font.
			var fontFamilyUrl = newval.split( " " ).join( "+" );
			var googleFontPath = "https://fonts.googleapis.com/css?family=" + fontFamilyUrl + ":400,700";
			var googleFontSource = "<link id='palm-beach-pro-custom-text-font' href='" + googleFontPath + "' rel='stylesheet' type='text/css'>";
			var checkLink = $( "head" ).find( "#palm-beach-pro-custom-text-font" ).length;

			if (checkLink > 0) {
				$( "head" ).find( "#palm-beach-pro-custom-text-font" ).remove();
			}
			$( "head" ).append( googleFontSource );

			// Set CSS.
			$( 'body, button, input, select, textarea' )
				.css( 'font-family', newval );

		} );
	} );

	wp.customize( 'pocono_theme_options[title_font]', function( value ) {
		value.bind( function( newval ) {

			// Embed Font.
			var fontFamilyUrl = newval.split( " " ).join( "+" );
			var googleFontPath = "https://fonts.googleapis.com/css?family=" + fontFamilyUrl + ":400,700";
			var googleFontSource = "<link id='palm-beach-pro-custom-title-font' href='" + googleFontPath + "' rel='stylesheet' type='text/css'>";
			var checkLink = $( "head" ).find( "#palm-beach-pro-custom-title-font" ).length;

			if (checkLink > 0) {
				$( "head" ).find( "#palm-beach-pro-custom-title-font" ).remove();
			}
			$( "head" ).append( googleFontSource );

			// Set CSS.
			$( '.site-title, .page-header .archive-title, .page-title, .entry-title, .comments-header .comments-title, .comment-reply-title span, .widget-title, .widget-magazine-posts .widget-header .widget-title' )
				.css( 'font-family', newval );

		} );
	} );

	wp.customize( 'pocono_theme_options[navi_font]', function( value ) {
		value.bind( function( newval ) {

			// Embed Font.
			var fontFamilyUrl = newval.split( " " ).join( "+" );
			var googleFontPath = "https://fonts.googleapis.com/css?family=" + fontFamilyUrl + ":400,700";
			var googleFontSource = "<link id='palm-beach-pro-custom-navi-font' href='" + googleFontPath + "' rel='stylesheet' type='text/css'>";
			var checkLink = $( "head" ).find( "#palm-beach-pro-custom-navi-font" ).length;

			if (checkLink > 0) {
				$( "head" ).find( "#palm-beach-pro-custom-navi-font" ).remove();
			}
			$( "head" ).append( googleFontSource );

			// Set CSS.
			$( '.main-navigation-menu a, .footer-navigation-menu a' )
				.css( 'font-family', newval );

		} );
	} );

	function hexdec( hexString ) {
		hexString = ( hexString + '' ).replace( /[^a-f0-9]/gi, '' );
		return parseInt( hexString, 16 );
	}

	function getColorBrightness( hexColor ) {

		// Remove # string.
		hexColor = hexColor.replace( '#', '' );

		// Convert into RGB.
		var r = hexdec( hexColor.substring( 0, 2 ) );
		var g = hexdec( hexColor.substring( 2, 4 ) );
		var b = hexdec( hexColor.substring( 4, 6 ) );

		return ( ( ( r * 299 ) + ( g * 587 ) + ( b * 114 ) ) / 1000 );
	}

	function isColorLight( hexColor ) {
		return ( getColorBrightness( hexColor ) > 130 );
	}

	function isColorDark( hexColor ) {
		return ( getColorBrightness( hexColor ) <= 130 );
	}

} )( jQuery );
