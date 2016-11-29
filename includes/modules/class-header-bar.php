<?php
/**
 * Footer Widgets
 *
 * Registers footer widget areas and hooks into the WorldStar theme to display widgets
 *
 * @package WorldStar Pro
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Header Bar Class
 */
class WorldStar_Pro_Header_Bar {

	/**
	 * Footer Widgets Setup
	 *
	 * @return void
	 */
	static function setup() {

		// Return early if WorldStar Theme is not active.
		if ( ! current_theme_supports( 'worldstar-pro' ) ) {
			return;
		}

		// Display Header Bar.
		add_action( 'worldstar_header_bar', array( __CLASS__, 'display_header_bar' ) );

	}

	/**
	 * Displays top navigation and social menu on header bar
	 *
	 * @return void
	 */
	static function display_header_bar() {

		// Get Theme Options from Database.
		$theme_options = WorldStar_Pro_Customizer::get_theme_options();

		echo '<div id="header-bar" class="header-bar container clearfix">';

		// Check if there is header bar text.
		if ( '' !== $theme_options['header_bar_text'] ) {

			echo '<div id="header-bar-text" class="header-bar-text clearfix">';

			echo wp_kses_post( $theme_options['header_bar_text'] );

			echo '</div>';

		}

		// Check if there is a top navigation menu.
		if ( has_nav_menu( 'secondary' ) ) {

			echo '<nav id="top-navigation" class="secondary-navigation navigation clearfix" role="navigation">';

			// Display Top Navigation.
			wp_nav_menu( array(
				'theme_location' => 'secondary',
				'container' => false,
				'menu_class' => 'top-navigation-menu',
				'echo' => true,
				'fallback_cb' => '',
				)
			);

			echo '</nav>';

		}

		echo '</div>';

	}

	/**
	 * Register navigation menus
	 *
	 * @return void
	 */
	static function register_nav_menus() {

		// Return early if WorldStar Theme is not active.
		if ( ! current_theme_supports( 'worldstar-pro' ) ) {
			return;
		}

		register_nav_menus( array(
			'secondary' => esc_html__( 'Top Navigation', 'worldstar-pro' ),
		) );

	}
}

// Run Class.
add_action( 'init', array( 'WorldStar_Pro_Header_Bar', 'setup' ) );

// Register navigation menus in backend.
add_action( 'after_setup_theme', array( 'WorldStar_Pro_Header_Bar', 'register_nav_menus' ), 20 );
