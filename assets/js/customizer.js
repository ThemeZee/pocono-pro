/**
 * Customizer JS
 *
 * Reloads changes on Theme Customizer Preview asynchronously for better usability
 *
 * @package Pocono Pro
 */

( function( $ ) {

	/* Header Color Option */
	wp.customize( 'pocono_theme_options[top_navi_color]', function( value ) {
		value.bind( function( newval ) {
			$( '.header-bar-wrap, .top-navigation-menu ul' )
				.css( 'background', newval );

			var textcolor, hovercolor;

			if( isColorLight( newval ) ) {
				textcolor = '#000000';
				hovercolor = 'rgba(0,0,0,0.4)';
			} else {
				textcolor = '#ffffff';
				hovercolor = 'rgba(255,255,255,0.5)';
			}

			$( '.top-navigation-menu a, .top-navigation-toggle, .top-navigation-menu .submenu-dropdown-toggle, .header-bar .social-icons-menu li a' )
				.css( 'color', textcolor );
			$('.top-navigation-menu a, .top-navigation-toggle, .top-navigation-menu .submenu-dropdown-toggle, .header-bar .social-icons-menu li a')
				.hover( function() { $( this ).css( 'color', hovercolor ); },
						function() { $( this ).css( 'color', textcolor ); }
				);
		} );
	} );

	/* Header Color Option */
	wp.customize( 'pocono_theme_options[header_color]', function( value ) {
		value.bind( function( newval ) {
			$( '.site-header, .main-navigation-menu ul' )
				.css( 'background', newval );

			var textcolor, hovercolor;

			if( isColorDark( newval ) ) {
				textcolor = '#ffffff';
				hovercolor = 'rgba(255,255,255,0.5)';
			} else {
				textcolor = '#000000';
				hovercolor = 'rgba(0,0,0,0.4)';
			}

			$( '.site-title a, .main-navigation-menu a, .main-navigation-toggle, .main-navigation-menu .submenu-dropdown-toggle' )
				.css( 'color', textcolor );
			$('.site-title a, .main-navigation-menu a, .main-navigation-toggle, .main-navigation-menu .submenu-dropdown-toggle')
				.hover( function() { $( this ).css( 'color', hovercolor ); },
						function() { $( this ).css( 'color', textcolor ); }
				);
		} );
	} );

	/* Footer Widgets Color Option */
	wp.customize( 'pocono_theme_options[footer_widgets_color]', function( value ) {
		value.bind( function( newval ) {
			$( '.footer-widgets-background' )
				.css( 'background', newval );

			var titlecolor, textcolor, hovercolor;

			if( isColorLight( newval ) ) {
				titlecolor ='rgba(0,0,0,0.75)';
				textcolor = 'rgba(0,0,0,0.75)';
				hovercolor = 'rgba(0,0,0,0.5)';
			} else {
				titlecolor = '#ffffff';
				textcolor = 'rgba(255,255,255,0.75)';
				hovercolor = 'rgba(255,255,255,0.5)';
			}

			$( '.footer-widgets-background' )
				.css( 'border-top', '1px solid rgba(0,0,0,0.1)' );
			$( '.footer-widgets .widget, .footer-widgets .widget-title' )
				.css( 'color', titlecolor );
			$('.footer-widgets .widget a')
				.not( $( '.footer-widgets .widget_tag_cloud .tagcloud a' ) )
				.css( 'color', textcolor )
				.hover( function() { $( this ).css( 'color', hovercolor ); },
						function() { $( this ).css( 'color', textcolor ); }
				);
		} );
	} );

	/* Footer Color Option */
	wp.customize( 'pocono_theme_options[footer_color]', function( value ) {
		value.bind( function( newval ) {
			$( '.footer-wrap' )
				.css( 'background', newval )
				.css( 'border-top', '1px solid rgba(0,0,0,0.1)' );

			var textcolor, linkcolor, hovercolor;

			if( isColorDark( newval ) ) {
				textcolor = '#ffffff';
				linkcolor = 'rgba(255,255,255,0.5)';
				hovercolor = 'rgba(255,255,255,0.75)';
			} else {
				textcolor = '#000000';
				linkcolor = 'rgba(0,0,0,0.5)';
				hovercolor = 'rgba(0,0,0,0.75)';
			}

			$( '.site-footer' )
				.css( 'color', textcolor );
			$( '.site-footer .site-info a, .footer-navigation-menu a' )
				.css( 'color', linkcolor );
			$('.site-footer .site-info a, .footer-navigation-menu a')
				.hover( function() { $( this ).css( 'color', hovercolor ); },
						function() { $( this ).css( 'color', linkcolor ); }
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
