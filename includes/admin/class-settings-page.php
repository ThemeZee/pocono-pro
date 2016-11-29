<?php
/**
 * Pocono Pro Settings Page Class
 *
 * Adds a new tab on the themezee plugins page and displays the settings page.
 *
 * @package Pocono Pro
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) { exit; }


/**
 * Settings Page Class
 */
class Pocono_Pro_Settings_Page {

	/**
	 * Setup the Settings Page class
	 *
	 * @return void
	 */
	static function setup() {

		// Add settings page to appearance menu.
		add_action( 'admin_menu', array( __CLASS__, 'add_settings_page' ), 12 );

		// Enqueue Settings CSS.
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'settings_page_css' ) );
	}

	/**
	 * Add Settings Page to Admin menu
	 *
	 * @return void
	 */
	static function add_settings_page() {

		// Return early if Pocono Theme is not active.
		if ( ! current_theme_supports( 'pocono-pro' ) ) {
			return;
		}

		add_theme_page(
			esc_html__( 'Pro Version', 'pocono-pro' ),
			esc_html__( 'Pro Version', 'pocono-pro' ),
			'edit_theme_options',
			'pocono-pro',
			array( __CLASS__, 'display_settings_page' )
		);

	}

	/**
	 * Display settings page
	 *
	 * @return void
	 */
	static function display_settings_page() {

		// Get Theme Details from style.css.
		$theme = wp_get_theme();

		ob_start();
		?>

		<div class="wrap pro-version-wrap">

			<h1><?php echo POCONO_PRO_NAME; ?> <?php echo POCONO_PRO_VERSION; ?></h1>

			<div id="pocono-pro-settings" class="pocono-pro-settings-wrap">

				<form class="pocono-pro-settings-form" method="post" action="options.php">
					<?php
						settings_fields( 'pocono_pro_settings' );
						do_settings_sections( 'pocono_pro_settings' );
					?>
				</form>

				<p><?php printf( __( 'You can find your license keys and manage your active sites on <a href="%s" target="_blank">themezee.com</a>.', 'pocono-pro' ), __( 'https://themezee.com/license-keys/', 'pocono-pro' ) . '?utm_source=plugin-settings&utm_medium=textlink&utm_campaign=pocono-pro&utm_content=license-keys' ); ?></p>

			</div>

		</div>

		<?php
		echo ob_get_clean();
	}

	/**
	 * Enqueues CSS for Settings page
	 *
	 * @param String $hook Slug of settings page.
	 * @return void
	 */
	static function settings_page_css( $hook ) {

		// Load styles and scripts only on theme info page.
		if ( 'appearance_page_pocono-pro' != $hook ) {
			return;
		}

		// Embed theme info css style.
		wp_enqueue_style( 'pocono-pro-settings-css', plugins_url( '/assets/css/settings.css', dirname( dirname( __FILE__ ) ) ), array(), POCONO_PRO_VERSION );

	}
}

// Run Pocono Pro Settings Page Class.
Pocono_Pro_Settings_Page::setup();
