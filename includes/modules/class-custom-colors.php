<?php
/**
 * Custom Colors
 *
 * Adds color settings to Customizer and generates color CSS code
 *
 * @package Pocono Pro
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Custom Colors Class
 */
class Pocono_Pro_Custom_Colors {

	/**
	 * Custom Colors Setup
	 *
	 * @return void
	 */
	static function setup() {

		// Return early if Pocono Theme is not active.
		if ( ! current_theme_supports( 'pocono-pro' ) ) {
			return;
		}

		// Add Custom Color CSS code to custom stylesheet output.
		add_filter( 'pocono_pro_custom_css_stylesheet', array( __CLASS__, 'custom_colors_css' ) );

		// Add Custom Color CSS code to the Gutenberg editor.
		add_action( 'enqueue_block_editor_assets', array( __CLASS__, 'custom_editor_colors_css' ) );

		// Add Custom Color Settings.
		add_action( 'customize_register', array( __CLASS__, 'color_settings' ) );
	}

	/**
	 * Adds Color CSS styles in the head area to override default colors
	 *
	 * @param String $custom_css Custom Styling CSS.
	 * @return string CSS code
	 */
	static function custom_colors_css( $custom_css ) {

		// Get Theme Options from Database.
		$theme_options = Pocono_Pro_Customizer::get_theme_options();

		// Get Default Fonts from settings.
		$default_options = Pocono_Pro_Customizer::get_default_options();

		// Set Header Color.
		if ( $theme_options['header_color'] != $default_options['header_color'] ) {

			$custom_css .= '
				.site-header {
					background: ' . $theme_options['header_color'] . ';
				}
			';

			// Check if a dark background color was chosen.
			if ( self::is_color_dark( $theme_options['header_color'] ) ) {
				$custom_css .= '
					.site-title,
					.site-title a:link,
					.site-title a:visited,
					.sidebar-navigation-toggle,
					.header-social-icons .social-icons-menu li a {
						color: #fff;
					}
					.site-title a:hover,
					.site-title a:active {
						color: #ff5555;
					}
				';
			}
		}

		// Set Navigation Color.
		if ( $theme_options['navigation_color'] != $default_options['navigation_color'] ) {

			$custom_css .= '
				.primary-navigation-wrap {
					background: ' . $theme_options['navigation_color'] . ';
				}
			';

			// Check if a dark background color was chosen.
			if ( self::is_color_dark( $theme_options['navigation_color'] ) ) {
				$custom_css .= '
					.main-navigation-menu a,
					.main-navigation-menu a:link,
					.main-navigation-menu a:visited,
					.main-navigation-menu > .menu-item-has-children > a:after {
						color: #ffffff;
					}
					.main-navigation-menu a:hover,
					.main-navigation-menu a:active {
						color: #ff5555;
					}
				';
			}
		}

		// Set Navigation Color.
		if ( $theme_options['footer_color'] != $default_options['footer_color'] ) {

			$custom_css .= '
				.footer-wrap {
					background: ' . $theme_options['footer_color'] . ';
				}
			';

			// Check if a dark background color was chosen.
			if ( self::is_color_dark( $theme_options['footer_color'] ) ) {
				$custom_css .= '
					.site-footer,
					.site-footer .site-info a:hover,
					.site-footer .site-info a:active,
					.footer-navigation-menu a:link,
					.footer-navigation-menu a:visited {
						color: #ffffff;
					}
					.footer-navigation-menu a:hover,
					.footer-navigation-menu a:active {
						color: #ff5555;
					}
				';
			}
		}

		// Set Title Color.
		if ( $theme_options['title_color'] != $default_options['title_color'] ) {

			$custom_css .= '
				.widget-title,
				.widget-title a:link,
				.widget-title a:visited,
				.page-title,
				.entry-title,
				.entry-title a:link,
				.entry-title a:visited {
					color: ' . $theme_options['title_color'] . ';
				}

				.widget-title a:hover,
				.widget-title a:active,
				.entry-title a:hover,
				.entry-title a:active {
					color: #ff5555;
				}
			';
		}

		// Set Primary Content Color.
		if ( $theme_options['link_color'] != $default_options['link_color'] ) {

			$custom_css .= '
				a,
				a:link,
				a:visited,
				.site-title a:hover,
				.site-title a:active,
				.sidebar-navigation-toggle:hover,
				.header-social-icons .social-icons-menu li a:hover,
				.main-navigation-menu a:hover,
				.main-navigation-menu a:active,
				.main-navigation-toggle:hover,
				.main-navigation-toggle:active,
				.main-navigation-menu .submenu-dropdown-toggle:hover:before,
				.main-navigation-menu .submenu-dropdown-toggle:active:before,
				.widget-title a:link,
				.widget-title a:visited,
				.widget-magazine-posts .widget-header .widget-title,
				.page-header .archive-title,
				.comments-header .comments-title,
				.comment-reply-title span,
				.related-posts-title,
				.entry-title a:hover,
				.entry-title a:active,
				.entry-categories .meta-category a:hover,
				.entry-categories .meta-category a:active,
				.footer-navigation-menu a:hover,
				.footer-navigation-menu a:active,
				.has-primary-color {
					color: ' . $theme_options['link_color'] . ';
				}

				a:hover,
				a:focus,
				a:active,
				.widget-title a:hover,
				.widget-title a:active {
					color: #373737;
				}

				.page-header .archive-title,
				.widget-magazine-posts .widget-header .widget-title,
				.comments-header .comments-title,
				.comment-reply-title span,
				.related-posts-title {
					border-color: ' . $theme_options['link_color'] . ';
				}

				button,
				input[type="button"],
				input[type="reset"],
				input[type="submit"],
				.main-navigation-menu ul,
				.more-link,
				.entry-categories .meta-category a,
				.widget_tag_cloud .tagcloud a,
				.entry-tags .meta-tags a,
				.post-navigation .nav-links a:hover,
				.post-navigation .nav-links a:active,
				.pagination a:hover,
				.pagination a:active,
				.pagination .current,
				.infinite-scroll #infinite-handle span:hover,
				.infinite-scroll #infinite-handle span:active,
				.reply .comment-reply-link:hover,
				.reply .comment-reply-link:active,
				.tzwb-tabbed-content .tzwb-tabnavi li a:hover,
				.tzwb-tabbed-content .tzwb-tabnavi li a:active,
				.tzwb-tabbed-content .tzwb-tabnavi li a.current-tab,
				.tzwb-social-icons .social-icons-menu li a:link,
				.tzwb-social-icons .social-icons-menu li a:visited,
				.scroll-to-top-button,
				.scroll-to-top-button:focus,
				.scroll-to-top-button:active,
				.has-primary-background-color {
					background-color: ' . $theme_options['link_color'] . ';
				}

				.tzwb-social-icons .social-icons-menu li a:hover,
				.tzwb-social-icons .social-icons-menu li a:active {
					background: #242424;
				}
			';
		}

		return $custom_css;
	}

	/**
	 * Adds Color CSS styles in the Gutenberg Editor to override default colors
	 *
	 * @return void
	 */
	static function custom_editor_colors_css() {

		// Get Theme Options from Database.
		$theme_options = Pocono_Pro_Customizer::get_theme_options();

		// Get Default Fonts from settings.
		$default_options = Pocono_Pro_Customizer::get_default_options();

		// Set Primary Color.
		if ( $theme_options['link_color'] !== $default_options['link_color'] ) {

			$custom_css = '
				.has-primary-color,
				.edit-post-visual-editor .editor-block-list__block a {
					color: ' . $theme_options['link_color'] . ';
				}
				.has-primary-background-color {
					background-color: ' . $theme_options['link_color'] . ';
				}
			';

			wp_add_inline_style( 'pocono-editor-styles', $custom_css );
		}
	}

	/**
	 * Change primary color in Gutenberg Editor.
	 *
	 * @return array $editor_settings
	 */
	static function change_primary_color( $color ) {
		// Get Theme Options from Database.
		$theme_options = Pocono_Pro_Customizer::get_theme_options();

		// Get Default Fonts from settings.
		$default_options = Pocono_Pro_Customizer::get_default_options();

		// Set Primary Color.
		if ( $theme_options['link_color'] !== $default_options['link_color'] ) {
			$color = $theme_options['link_color'];
		}

		return $color;
	}

	/**
	 * Adds all color settings in the Customizer
	 *
	 * @param object $wp_customize / Customizer Object.
	 */
	static function color_settings( $wp_customize ) {

		// Add Section for Theme Colors.
		$wp_customize->add_section( 'pocono_pro_section_colors', array(
			'title'    => __( 'Theme Colors', 'pocono-pro' ),
			'priority' => 60,
			'panel'    => 'pocono_options_panel',
		) );

		// Get Default Colors from settings.
		$default_options = Pocono_Pro_Customizer::get_default_options();

		// Add Navigation Primary Color setting.
		$wp_customize->add_setting( 'pocono_theme_options[header_color]', array(
			'default'           => $default_options['header_color'],
			'type'              => 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize, 'pocono_theme_options[header_color]', array(
				'label'    => _x( 'Header', 'color setting', 'pocono-pro' ),
				'section'  => 'pocono_pro_section_colors',
				'settings' => 'pocono_theme_options[header_color]',
				'priority' => 10,
			)
		) );

		// Add Navigation Color setting.
		$wp_customize->add_setting( 'pocono_theme_options[navigation_color]', array(
			'default'           => $default_options['navigation_color'],
			'type'              => 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize, 'pocono_theme_options[navigation_color]', array(
				'label'    => _x( 'Navigation', 'color setting', 'pocono-pro' ),
				'section'  => 'pocono_pro_section_colors',
				'settings' => 'pocono_theme_options[navigation_color]',
				'priority' => 20,
			)
		) );

		// Add Content Primary Color setting.
		$wp_customize->add_setting( 'pocono_theme_options[link_color]', array(
			'default'           => $default_options['link_color'],
			'type'              => 'option',
			'transport'         => 'refresh',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize, 'pocono_theme_options[link_color]', array(
				'label'    => _x( 'Links and Buttons', 'color setting', 'pocono-pro' ),
				'section'  => 'pocono_pro_section_colors',
				'settings' => 'pocono_theme_options[link_color]',
				'priority' => 30,
			)
		) );

		// Add Content Secondary Color setting.
		$wp_customize->add_setting( 'pocono_theme_options[title_color]', array(
			'default'           => $default_options['title_color'],
			'type'              => 'option',
			'transport'         => 'refresh',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize, 'pocono_theme_options[title_color]', array(
				'label'    => _x( 'Headings', 'color setting', 'pocono-pro' ),
				'section'  => 'pocono_pro_section_colors',
				'settings' => 'pocono_theme_options[title_color]',
				'priority' => 40,
			)
		) );

		// Add Footer Color setting.
		$wp_customize->add_setting( 'pocono_theme_options[footer_color]', array(
			'default'           => $default_options['footer_color'],
			'type'              => 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize, 'pocono_theme_options[footer_color]', array(
				'label'    => _x( 'Footer', 'color setting', 'pocono-pro' ),
				'section'  => 'pocono_pro_section_colors',
				'settings' => 'pocono_theme_options[footer_color]',
				'priority' => 50,
			)
		) );
	}

	/**
	 * Returns color brightness.
	 *
	 * @param int Number of brightness.
	 */
	static function get_color_brightness( $hex_color ) {

		// Remove # string.
		$hex_color = str_replace( '#', '', $hex_color );

		// Convert into RGB.
		$r = hexdec( substr( $hex_color, 0, 2 ) );
		$g = hexdec( substr( $hex_color, 2, 2 ) );
		$b = hexdec( substr( $hex_color, 4, 2 ) );

		return ( ( ( $r * 299 ) + ( $g * 587 ) + ( $b * 114 ) ) / 1000 );
	}

	/**
	 * Check if the color is light.
	 *
	 * @param bool True if color is light.
	 */
	static function is_color_light( $hex_color ) {
		return ( self::get_color_brightness( $hex_color ) > 130 );
	}

	/**
	 * Check if the color is dark.
	 *
	 * @param bool True if color is dark.
	 */
	static function is_color_dark( $hex_color ) {
		return ( self::get_color_brightness( $hex_color ) <= 130 );
	}
}

// Run Class.
add_action( 'init', array( 'Pocono_Pro_Custom_Colors', 'setup' ) );
add_filter( 'pocono_primary_color', array( 'Pocono_Pro_Custom_Colors', 'change_primary_color' ) );
