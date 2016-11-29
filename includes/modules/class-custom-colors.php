<?php
/**
 * Custom Colors
 *
 * Adds color settings to Customizer and generates color CSS code
 *
 * @package Pocono Pro
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) { exit; }

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

		// Add Custom Color Settings.
		add_action( 'customize_register', array( __CLASS__, 'color_settings' ) );

	}

	/**
	 * Builds all custom color CSS styles.
	 *
	 * @param String $custom_css Custom Styling CSS.
	 * @return string CSS code
	 */
	static function custom_colors_css( $custom_css = '' ) {

		// Get Theme Options from Database.
		$theme_options = Pocono_Pro_Customizer::get_theme_options();

		// Get Default Fonts from settings.
		$default_options = Pocono_Pro_Customizer::get_default_options();

		// Check if we are in Customizer Preview.
		$is_customize_preview = is_customize_preview();

		// Set Top Navigation Color.
		if ( $theme_options['top_navi_color'] !== $default_options['top_navi_color'] || $is_customize_preview ) {

			$custom_css .= '
				/* Top Navigation Color Setting */
				.top-navigation-menu a:hover,
				.top-navigation-menu a:active,
				.top-navigation-toggle:hover:after,
				.top-navigation-menu .submenu-dropdown-toggle:hover:before {
					color: ' . $theme_options['top_navi_color'] . ';
				}
				.top-navigation-menu ul {
					background: ' . $theme_options['top_navi_color'] . ';
				}
				';

		}

		// Set Primary Navigation Color.
		if ( $theme_options['navi_primary_color'] !== $default_options['navi_primary_color'] || $is_customize_preview ) {

			$custom_css .= '
				/* Main Navigation Color Setting */
				.primary-navigation-wrap,
				.main-navigation-toggle {
					background: ' . $theme_options['navi_primary_color'] . ';
				}
				';

		}

		// Set Secondary Navigation Color.
		if ( $theme_options['navi_secondary_color'] !== $default_options['navi_secondary_color'] || $is_customize_preview ) {

			$custom_css .= '

				/* Secondary Navigation Color Setting */
				.main-navigation-menu ul,
				.main-navigation-toggle:hover,
				.main-navigation-toggle:active {
					background: ' . $theme_options['navi_secondary_color'] . ';
				}
				';

		}

		// Set Primary Content Color.
		if ( $theme_options['content_primary_color'] !== $default_options['content_primary_color'] || $is_customize_preview ) {

			$custom_css .= '
				/* Content Primary Color Setting */
				.site-title,
				.site-title a:link,
				.site-title a:visited,
				.page-title,
				.entry-title,
				.entry-title a:link,
				.entry-title a:visited {
					color: ' . $theme_options['content_primary_color'] . ';
				}

				.site-title a:hover,
				.site-title a:active,
				.entry-title a:hover,
				.entry-title a:active {
					color: #33bbdd;
				}
				';

		}

		// Set Link Color.
		if ( $theme_options['content_secondary_color'] !== $default_options['content_secondary_color'] || $is_customize_preview ) {

			$custom_css .= '
				/* Content Secondary Color Setting */
				a,
				a:link,
				a:visited,
				.site-title a:hover,
				.site-title a:active,
				.entry-title a:hover,
				.entry-title a:active {
					color: ' . $theme_options['content_secondary_color'] . ';
				}

				a:hover,
				a:focus,
				a:active {
					color: #222;
				}

				button,
				input[type="button"],
				input[type="reset"],
				input[type="submit"],
				.more-link:link,
				.more-link:visited,
				.entry-categories .meta-category a,
				.widget_tag_cloud .tagcloud a,
				.entry-tags .meta-tags a,
				.pagination a:hover,
				.pagination .current,
				.infinite-scroll #infinite-handle span,
				.footer-social-icons .social-icons-menu li a,
				.tzwb-tabbed-content .tzwb-tabnavi li a:hover,
				.tzwb-tabbed-content .tzwb-tabnavi li a:active,
				.tzwb-tabbed-content .tzwb-tabnavi li a.current-tab,
				.tzwb-social-icons .social-icons-menu li a {
					background: ' . $theme_options['content_secondary_color'] . ';
				}

				button:hover,
				input[type="button"]:hover,
				input[type="reset"]:hover,
				input[type="submit"]:hover,
				.more-link:hover,
				.more-link:active,
				.entry-categories .meta-category a:hover,
				.entry-categories .meta-category a:active,
				.widget_tag_cloud .tagcloud a:hover,
				.widget_tag_cloud .tagcloud a:active,
				.entry-tags .meta-tags a:hover,
				.entry-tags .meta-tags a:active,
				.pagination a,
				.infinite-scroll #infinite-handle span:hover,
				.footer-social-icons .social-icons-menu li a:hover,
				.tzwb-social-icons .social-icons-menu li a:hover {
					background: #222;
				}
				';

		}

		// Set Primary Hover Content Color.
		if ( $theme_options['content_primary_color'] !== $default_options['content_primary_color'] || $is_customize_preview ) {

			$custom_css .= '
				/* Content Primary Hover Color Setting */
				button:hover,
				input[type="button"]:hover,
				input[type="reset"]:hover,
				input[type="submit"]:hover,
				.more-link:hover,
				.more-link:active,
				.entry-categories .meta-category a:hover,
				.entry-categories .meta-category a:active,
				.widget_tag_cloud .tagcloud a:hover,
				.widget_tag_cloud .tagcloud a:active,
				.entry-tags .meta-tags a:hover,
				.entry-tags .meta-tags a:active,
				.pagination a,
				.infinite-scroll #infinite-handle span:hover,
				.footer-social-icons .social-icons-menu li a:hover,
				.tzwb-tabbed-content .tzwb-tabnavi li a,
				.tzwb-social-icons .social-icons-menu li a:hover {
					background: ' . $theme_options['content_primary_color'] . ';
				}
				';

		}

		// Set Widget Title Color.
		if ( $theme_options['widget_title_color'] !== $default_options['widget_title_color'] || $is_customize_preview ) {

			$custom_css .= '
				/* Widget Title Color Setting */
				.page-header .archive-title,
				.comments-header .comments-title,
				.comment-reply-title span,
				.widget-title,
				.widget-title a:link,
				.widget-title a:visited,
				.widget-title a:hover,
				.widget-title a:active  {
					color: ' . $theme_options['widget_title_color'] . ';
				}
				';

		}

		// Set Footer Color.
		if ( $theme_options['footer_color'] !== $default_options['footer_color'] || $is_customize_preview ) {

			$custom_css .= '
				/* Footer Color Setting */
				.footer-wrap,
				.footer-widgets-background {
					background: ' . $theme_options['footer_color'] . ';
				}
				';

		}

		return $custom_css;

	}

	/**
	 * Adds all color settings in the Customizer
	 *
	 * @param object $wp_customize / Customizer Object.
	 */
	static function color_settings( $wp_customize ) {

		// Set Transport method. Only use postMessage if selective refresh is supported.
		$transport = isset( $wp_customize->selective_refresh ) ? 'postMessage' : 'refresh';

		// Add Section for Theme Colors.
		$wp_customize->add_section( 'pocono_pro_section_colors', array(
			'title'    => __( 'Theme Colors', 'pocono-pro' ),
			'priority' => 60,
			'panel' => 'pocono_options_panel',
			)
		);

		// Get Default Colors from settings.
		$default_options = Pocono_Pro_Customizer::get_default_options();

		// Add Widget Title Color setting.
		$wp_customize->add_setting( 'pocono_theme_options[top_navi_color]', array(
			'default'           => $default_options['top_navi_color'],
			'type'           	=> 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
			)
		);
		$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize, 'pocono_theme_options[top_navi_color]', array(
				'label'      => _x( 'Top Navigation', 'color setting', 'pocono-pro' ),
				'section'    => 'pocono_pro_section_colors',
				'settings'   => 'pocono_theme_options[top_navi_color]',
				'priority' => 1,
			)
		) );

		// Add Navigation Primary Color setting.
		$wp_customize->add_setting( 'pocono_theme_options[navi_primary_color]', array(
			'default'           => $default_options['navi_primary_color'],
			'type'           	=> 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
			)
		);
		$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize, 'pocono_theme_options[navi_primary_color]', array(
				'label'      => _x( 'Navigation (primary)', 'color setting', 'pocono-pro' ),
				'section'    => 'pocono_pro_section_colors',
				'settings'   => 'pocono_theme_options[navi_primary_color]',
				'priority' => 2,
			)
		) );

		// Add Navigation Secondary Color setting.
		$wp_customize->add_setting( 'pocono_theme_options[navi_secondary_color]', array(
			'default'           => $default_options['navi_secondary_color'],
			'type'           	=> 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
			)
		);
		$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize, 'pocono_theme_options[navi_secondary_color]', array(
				'label'      => _x( 'Navigation (secondary)', 'color setting', 'pocono-pro' ),
				'section'    => 'pocono_pro_section_colors',
				'settings'   => 'pocono_theme_options[navi_secondary_color]',
				'priority' => 3,
			)
		) );

		// Add Post Primary Color setting.
		$wp_customize->add_setting( 'pocono_theme_options[content_primary_color]', array(
			'default'           => $default_options['content_primary_color'],
			'type'           	=> 'option',
			'transport'         => $transport,
			'sanitize_callback' => 'sanitize_hex_color',
			)
		);
		$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize, 'pocono_theme_options[content_primary_color]', array(
				'label'      => _x( 'Content (primary)', 'color setting', 'pocono-pro' ),
				'section'    => 'pocono_pro_section_colors',
				'settings'   => 'pocono_theme_options[content_primary_color]',
				'priority' => 4,
			)
		) );

		// Add Link and Button Color setting.
		$wp_customize->add_setting( 'pocono_theme_options[content_secondary_color]', array(
			'default'           => $default_options['content_secondary_color'],
			'type'           	=> 'option',
			'transport'         => $transport,
			'sanitize_callback' => 'sanitize_hex_color',
			)
		);
		$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize, 'pocono_theme_options[content_secondary_color]', array(
				'label'      => _x( 'Content (secondary)', 'color setting', 'pocono-pro' ),
				'section'    => 'pocono_pro_section_colors',
				'settings'   => 'pocono_theme_options[content_secondary_color]',
				'priority' => 5,
			)
		) );

		// Add Widget Title Color setting.
		$wp_customize->add_setting( 'pocono_theme_options[widget_title_color]', array(
			'default'           => $default_options['widget_title_color'],
			'type'           	=> 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
			)
		);
		$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize, 'pocono_theme_options[widget_title_color]', array(
				'label'      => _x( 'Widget Titles', 'color setting', 'pocono-pro' ),
				'section'    => 'pocono_pro_section_colors',
				'settings'   => 'pocono_theme_options[widget_title_color]',
				'priority' => 6,
			)
		) );

		// Add Footer Color setting.
		$wp_customize->add_setting( 'pocono_theme_options[footer_color]', array(
			'default'           => $default_options['footer_color'],
			'type'           	=> 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
			)
		);
		$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize, 'pocono_theme_options[footer_color]', array(
				'label'      => _x( 'Footer', 'color setting', 'pocono-pro' ),
				'section'    => 'pocono_pro_section_colors',
				'settings'   => 'pocono_theme_options[footer_color]',
				'priority' => 7,
			)
		) );

		// Add support for selective refresh.
		if ( isset( $wp_customize->selective_refresh ) ) {

			$wp_customize->selective_refresh->add_partial( 'pocono_pro_custom_colors', array(
				'selector' => '#pocono-pro-custom-colors-css',
				'settings' => array(
					'pocono_theme_options[top_navi_color]',
					'pocono_theme_options[navi_primary_color]',
					'pocono_theme_options[navi_secondary_color]',
					'pocono_theme_options[content_primary_color]',
					'pocono_theme_options[content_secondary_color]',
					'pocono_theme_options[widget_title_color]',
					'pocono_theme_options[footer_color]',
				),
				'container_inclusive' => false,
				'render_callback' => array( __CLASS__, 'custom_colors_css' ),
			) );

		}

	}
}

// Run Class.
add_action( 'init', array( 'Pocono_Pro_Custom_Colors', 'setup' ) );
