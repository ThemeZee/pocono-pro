<?php
/**
 * Footer Line
 *
 * Displays credit link and footer text based on theme options
 * Registers and displays footer navigation
 *
 * @package WorldStar Pro
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Footer Line Class
 */
class WorldStar_Pro_Footer_Line {

	/**
	 * Footer Line Setup
	 *
	 * @return void
	 */
	static function setup() {

		// Return early if WorldStar Theme is not active.
		if ( ! current_theme_supports( 'worldstar-pro' ) ) {
			return;
		}

		// Display footer navigation.
		add_action( 'worldstar_before_footer', array( __CLASS__, 'display_footer_social_menu' ), 10 );

		// Remove default footer text function and replace it with new one.
		remove_action( 'worldstar_footer_text', 'worldstar_footer_text' );
		add_action( 'worldstar_footer_text', array( __CLASS__, 'display_footer_text' ) );

		// Display social icons in footer.
		add_action( 'worldstar_footer_menu', array( __CLASS__, 'display_footer_navigation' ) );

		// Add Footer Settings in Customizer.
		add_action( 'customize_register', array( __CLASS__, 'footer_settings' ) );

	}

	/**
	 * Display footer navigation menu
	 *
	 * @return void
	 */
	static function display_footer_navigation() {

		// Check if there is a footer menu.
		if ( has_nav_menu( 'footer' ) ) {

			echo '<nav id="footer-navigation" class="footer-navigation navigation clearfix" role="navigation">';

				wp_nav_menu( array(
					'theme_location' => 'footer',
					'container' => false,
					'menu_class' => 'footer-navigation-menu',
					'echo' => true,
					'fallback_cb' => '',
					'depth' => 1,
					)
				);

			echo '</nav>';

		}

	}

	/**
	 * Displays Credit Link and user defined Footer Text based on theme settings.
	 *
	 * @return void
	 */
	static function display_footer_text() {

		// Get Theme Options from Database.
		$theme_options = WorldStar_Pro_Customizer::get_theme_options();

		// Display Footer Text.
		if ( '' !== $theme_options['footer_text'] ) :

			echo do_shortcode( wp_kses_post( $theme_options['footer_text'] ) );

		endif;

		// Call Credit Link function of theme if credit link is activated.
		if ( true == $theme_options['credit_link'] ) :

			if ( function_exists( 'worldstar_footer_text' ) ) :

				worldstar_footer_text();

			endif;

		endif;

	}

	/**
	 * Display social icons in footer
	 *
	 * @return void
	 */
	static function display_footer_social_menu() {

		// Check if there is a social menu.
		if ( has_nav_menu( 'footer-social' ) ) {

			// Get Theme Options from Database.
			$theme_options = WorldStar_Pro_Customizer::get_theme_options();

			echo '<div class="footer-social-icons-wrap">';

			echo '<div id="footer-social-icons" class="footer-social-icons social-icons-navigation container clearfix">';

			// Check if there is header bar text.
			if ( '' !== $theme_options['footer_social_icons_text'] ) {

				printf( '<h3 class="footer-social-icons-title">%s</h3>', wp_kses_post( $theme_options['footer_social_icons_text'] ) );

			}

			// Display Social Icons Menu.
			wp_nav_menu( array(
				'theme_location' => 'footer-social',
				'container' => false,
				'menu_class' => 'social-icons-menu',
				'echo' => true,
				'fallback_cb' => '',
				'link_before' => '<span class="screen-reader-text">',
				'link_after' => '</span>',
				'depth' => 1,
				)
			);

			echo '</div>';

			echo '</div>';

		}

	}

	/**
	 * Adds footer text and credit link setting
	 *
	 * @param object $wp_customize / Customizer Object.
	 */
	static function footer_settings( $wp_customize ) {

		// Add Sections for Footer Settings.
		$wp_customize->add_section( 'worldstar_pro_section_footer', array(
			'title'    => __( 'Footer Settings', 'worldstar-pro' ),
			'priority' => 90,
			'panel' => 'worldstar_options_panel',
			)
		);

		// Add Footer Social Icons Text setting.
		$wp_customize->add_setting( 'worldstar_theme_options[footer_social_icons_text]', array(
			'default'           => __( 'Stay in Touch', 'worldstar-pro' ),
			'type'           	=> 'option',
			'transport'         => 'refresh',
			'sanitize_callback' => array( __CLASS__, 'sanitize_footer_text' ),
			)
		);
		$wp_customize->add_control( 'worldstar_theme_options[footer_social_icons_text]', array(
			'label'    => __( 'Social Icons Text', 'worldstar-pro' ),
			'section'  => 'worldstar_pro_section_footer',
			'settings' => 'worldstar_theme_options[footer_social_icons_text]',
			'type'     => 'text',
			'active_callback' => array( __CLASS__, 'has_social_menu' ),
			'priority' => 10,
			)
		);

		// Add Footer Text setting.
		$wp_customize->add_setting( 'worldstar_theme_options[footer_text]', array(
			'default'           => '',
			'type'           	=> 'option',
			'transport'         => 'refresh',
			'sanitize_callback' => array( __CLASS__, 'sanitize_footer_text' ),
			)
		);
		$wp_customize->add_control( 'worldstar_theme_options[footer_text]', array(
			'label'    => __( 'Footer Text', 'worldstar-pro' ),
			'section'  => 'worldstar_pro_section_footer',
			'settings' => 'worldstar_theme_options[footer_text]',
			'type'     => 'textarea',
			'priority' => 20,
			)
		);

		// Add Credit Link setting.
		$wp_customize->add_setting( 'worldstar_theme_options[credit_link]', array(
			'default'           => true,
			'type'           	=> 'option',
			'transport'         => 'refresh',
			'sanitize_callback' => 'worldstar_sanitize_checkbox',
			)
		);
		$wp_customize->add_control( 'worldstar_theme_options[credit_link]', array(
			'label'    => __( 'Display Credit Link to ThemeZee on footer line', 'worldstar-pro' ),
			'section'  => 'worldstar_pro_section_footer',
			'settings' => 'worldstar_theme_options[credit_link]',
			'type'     => 'checkbox',
			'priority' => 30,
			)
		);

	}

	/**
	 *  Sanitize footer content textarea
	 *
	 * @param String $value / Value of the setting.
	 * @return string
	 */
	static function sanitize_footer_text( $value ) {

		if ( current_user_can( 'unfiltered_html' ) ) :
			return $value;
		else :
			return stripslashes( wp_filter_post_kses( addslashes( $value ) ) );
		endif;
	}

	/**
	 * Adds a callback function to retrieve wether a footer social icons menu was set or not.
	 *
	 * @param object $control / Instance of the Customizer Control.
	 * @return bool
	 */
	static function has_social_menu( $control ) {

		// Check if social icons menu exists.
		if ( has_nav_menu( 'footer-social' ) ) {
			return true;
		}

		return false;
	}

	/**
	 * Register footer navigation menu
	 *
	 * @return void
	 */
	static function register_footer_menu() {

		// Return early if WorldStar Theme is not active.
		if ( ! current_theme_supports( 'worldstar-pro' ) ) {
			return;
		}

		register_nav_menus( array(
			'footer' => esc_html__( 'Footer Navigation', 'worldstar-pro' ),
			'footer-social' => esc_html__( 'Footer Social Icons', 'worldstar-pro' ),
		) );

	}
}

// Run Class.
add_action( 'init', array( 'WorldStar_Pro_Footer_Line', 'setup' ) );

// Register footer navigation in backend.
add_action( 'after_setup_theme', array( 'WorldStar_Pro_Footer_Line', 'register_footer_menu' ), 30 );
