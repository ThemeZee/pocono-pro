<?php
/**
 * Header Settings
 *
 * Adds extra settings to handle spacings in the header area
 *
 * @package WorldStar Pro
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Header Settings Class
 */
class WorldStar_Pro_Header_Settings {

	/**
	 * Site Logo Setup
	 *
	 * @return void
	 */
	static function setup() {

		// Return early if WorldStar Theme is not active.
		if ( ! current_theme_supports( 'worldstar-pro' ) ) {
			return;
		}

		// Add Custom Spacing CSS code to custom stylesheet output.
		add_filter( 'worldstar_pro_custom_css_stylesheet', array( __CLASS__, 'custom_spacing_css' ) );

		// Add Header Settings Settings.
		add_action( 'customize_register', array( __CLASS__, 'header_settings' ) );
	}

	/**
	 * Adds custom Margin CSS styling for the logo and navigation spacing
	 *
	 * @param String $custom_css Custom Styling CSS.
	 * @return string CSS code
	 */
	static function custom_spacing_css( $custom_css ) {

		// Get Theme Options from Database.
		$theme_options = WorldStar_Pro_Customizer::get_theme_options();

		// Set Logo Spacing.
		if ( 0 !== $theme_options['logo_spacing'] ) {

			$margin = $theme_options['logo_spacing'] / 10;

			$custom_css .= '
				.site-branding {
					margin: ' . $margin . 'em 0;
				}
				';

		}

		// Set Navigation Spacing.
		if ( 20 !== $theme_options['header_spacing'] ) {

			$margin = $theme_options['header_spacing'] / 10;

			$custom_css .= '
				@media only screen and (min-width: 60em) {

			    .header-main {
						padding-top: ' . $margin . 'em;
						padding-bottom: ' . $margin . 'em;
			    }

				}
				';

		}

		return $custom_css;

	}

	/**
	 * Adds header spacing settings
	 *
	 * @param object $wp_customize / Customizer Object.
	 */
	static function header_settings( $wp_customize ) {

		// Add Sections for Site Logo.
		$wp_customize->add_section( 'worldstar_pro_section_header', array(
			'title'    => __( 'Header Settings', 'worldstar-pro' ),
			'priority' => 20,
			'panel' => 'worldstar_options_panel',
			)
		);

		// Add Header Bar Text setting.
		$wp_customize->add_setting( 'worldstar_theme_options[header_bar_text]', array(
			'default'           => '',
			'type'            	=> 'option',
			'transport'         => 'refresh',
			'sanitize_callback' => 'wp_kses_post',
			)
		);
		$wp_customize->add_control( 'worldstar_theme_options[header_bar_text]', array(
			'label'    => esc_html__( 'Header Bar Text', 'worldstar-pro' ),
			'section'  => 'worldstar_pro_section_header',
			'settings' => 'worldstar_theme_options[header_bar_text]',
			'type'     => 'text',
			'priority' => 10,
			)
		);

		// Add Logo Spacing setting.
		$wp_customize->add_setting( 'worldstar_theme_options[logo_spacing]', array(
			'default'           => 0,
			'type'           	=> 'option',
			'transport'         => 'refresh',
			'sanitize_callback' => 'absint',
			)
		);
		$wp_customize->add_control( 'worldstar_theme_options[logo_spacing]', array(
			'label'    => __( 'Logo Spacing (default: 0)', 'worldstar-pro' ),
			'section'  => 'worldstar_pro_section_header',
			'settings' => 'worldstar_theme_options[logo_spacing]',
			'type'     => 'text',
			'priority' => 20,
			)
		);

		// Add Header Settings setting.
		$wp_customize->add_setting( 'worldstar_theme_options[header_spacing]', array(
			'default'           => 20,
			'type'           	=> 'option',
			'transport'         => 'refresh',
			'sanitize_callback' => 'absint',
			)
		);
		$wp_customize->add_control( 'worldstar_theme_options[header_spacing]', array(
			'label'    => __( 'Header Spacing (default: 20)', 'worldstar-pro' ),
			'section'  => 'worldstar_pro_section_header',
			'settings' => 'worldstar_theme_options[header_spacing]',
			'type'     => 'text',
			'priority' => 30,
			)
		);

	}
}

// Run Class.
add_action( 'init', array( 'WorldStar_Pro_Header_Settings', 'setup' ) );
