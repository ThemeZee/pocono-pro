<?php
/**
 * Customizer
 *
 * Setup the Customizer and theme options for the Pro plugin
 *
 * @package Pocono Pro
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Customizer Class
 */
class Pocono_Pro_Customizer {

	/**
	 * Customizer Setup
	 *
	 * @return void
	 */
	static function setup() {

		// Return early if Pocono Theme is not active.
		if ( ! current_theme_supports( 'pocono-pro' ) ) {
			return;
		}

		// Enqueue scripts and styles in the Customizer.
		add_action( 'customize_preview_init', array( __CLASS__, 'customize_preview_js' ) );
		add_action( 'customize_controls_print_styles', array( __CLASS__, 'customize_preview_css' ) );

		// Remove Upgrade section.
		remove_action( 'customize_register', 'pocono_customize_register_upgrade_settings' );
	}

	/**
	 * Get saved user settings from database or plugin defaults
	 *
	 * @return array
	 */
	static function get_theme_options() {

		// Merge Theme Options Array from Database with Default Options Array.
		$theme_options = wp_parse_args( get_option( 'pocono_theme_options', array() ), self::get_default_options() );

		// Return theme options.
		return $theme_options;

	}


	/**
	 * Returns the default settings of the plugin
	 *
	 * @return array
	 */
	static function get_default_options() {

		$default_options = array(
			'header_bar_text'             => '',
			'logo_spacing'                => 0,
			'header_spacing'              => 20,
			'footer_social_icons_text'    => __( 'Stay in Touch', 'pocono-pro' ),
			'footer_text'                 => '',
			'credit_link'                 => true,
			'top_navi_color'              => '#33bbdd',
			'navi_primary_color'          => '#222222',
			'navi_secondary_color'        => '#33bbdd',
			'content_primary_color'       => '#222222',
			'content_secondary_color'     => '#33bbdd',
			'widget_title_color'          => '#222222',
			'footer_color'                => '#222222',
			'text_font'                   => 'Open Sans',
			'title_font'                  => 'Oswald',
			'navi_font'                   => 'Open Sans',
			'widget_title_font'           => 'Oswald',
			'available_fonts'             => 'favorites',
		);

		return $default_options;

	}

	/**
	 * Embed JS file to make Theme Customizer preview reload changes asynchronously.
	 *
	 * @return void
	 */
	static function customize_preview_js() {

		wp_enqueue_script( 'pocono-pro-customizer-js', POCONO_PRO_PLUGIN_URL . 'assets/js/customizer.js', array( 'customize-preview' ), POCONO_PRO_VERSION, true );

	}

	/**
	 * Embed CSS styles for the theme options in the Customizer
	 *
	 * @return void
	 */
	static function customize_preview_css() {

		wp_enqueue_style( 'pocono-pro-customizer-css', POCONO_PRO_PLUGIN_URL . 'assets/css/customizer.css', array(), POCONO_PRO_VERSION );

	}
}

// Run Class.
add_action( 'init', array( 'Pocono_Pro_Customizer', 'setup' ) );
