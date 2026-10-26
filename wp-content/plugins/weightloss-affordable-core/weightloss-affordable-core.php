<?php
/**
 * Plugin Name: WeightLossAffordable Core
 * Plugin URI: https://weightlossaffordable.com/
 * Description: The single WeightLossAffordable plugin: WLA Elementor sections and demo importer, bundled NuestraRx quiz/intake/treatment workflows, and WLA-styled treatment, story, video and calculator sections.
 * Version: 2.1.0
 * Requires at least: 6.6
 * Requires PHP: 7.4
 * Author: WeightLossAffordable
 * Text Domain: weightloss-affordable-core
 * Domain Path: /languages
 * License: GPL-2.0-or-later
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'WLA_CORE_VERSION', '2.1.0' );
define( 'WLA_CORE_FILE', __FILE__ );
define( 'WLA_CORE_DIR', plugin_dir_path( __FILE__ ) );
define( 'WLA_CORE_URL', plugin_dir_url( __FILE__ ) );

// The public installer is one plugin. Avoid redeclaring NuestraRx when an
// existing separate installation is still active during a migration.
$wla_nrx_active_plugins = (array) get_option( 'active_plugins', array() );
$wla_nrx_network_plugins = array_keys( (array) get_site_option( 'active_sitewide_plugins', array() ) );
$wla_external_nrx_active = (bool) array_filter(
	array_merge( $wla_nrx_active_plugins, $wla_nrx_network_plugins ),
	static function ( $plugin ) { return false !== strpos( strtolower( (string) $plugin ), 'nuestrarx' ); }
);
if ( ! $wla_external_nrx_active && ! function_exists( 'nrx_quiz_render' ) ) {
	define( 'NRX_CORE_VERSION', '1.1.0' );
	define( 'NRX_CORE_FILE', WLA_CORE_DIR . 'modules/nuestrarx/nuestrarx-core.php' );
	define( 'NRX_CORE_DIR', WLA_CORE_DIR . 'modules/nuestrarx/' );
	define( 'NRX_CORE_URL', plugins_url( 'modules/nuestrarx/', __FILE__ ) );
	define( 'NRX_CORE_BASENAME', plugin_basename( NRX_CORE_FILE ) );
}
define( 'WLA_EXPERIENCE_VERSION', '1.1.0' );
define( 'WLA_EXPERIENCE_FILE', __FILE__ );
define( 'WLA_EXPERIENCE_DIR', WLA_CORE_DIR . 'modules/experience/' );
define( 'WLA_EXPERIENCE_URL', plugins_url( 'modules/experience/', __FILE__ ) );

require_once WLA_CORE_DIR . 'includes/post-types.php';
require_once WLA_CORE_DIR . 'includes/elementor.php';
require_once WLA_CORE_DIR . 'includes/contact-form.php';
require_once WLA_CORE_DIR . 'includes/translator.php';
require_once WLA_CORE_DIR . 'includes/demo-import.php';
require_once WLA_CORE_DIR . 'includes/demo-seed.php';

// Bundle NuestraRx clinical workflow + quiz when no separate NRX plugin is active.
if ( ! $wla_external_nrx_active && defined( 'NRX_CORE_DIR' ) && ! function_exists( 'nrx_quiz_render' ) ) {
	require_once NRX_CORE_DIR . 'nuestrarx-core.php';
}
require_once WLA_EXPERIENCE_DIR . 'includes/content.php';
require_once WLA_EXPERIENCE_DIR . 'includes/shortcodes.php';
require_once WLA_EXPERIENCE_DIR . 'includes/treatment-detail.php';
require_once WLA_EXPERIENCE_DIR . 'includes/elementor.php';
require_once WLA_EXPERIENCE_DIR . 'includes/nuestra-quiz-bridge.php';
require_once WLA_CORE_DIR . 'includes/experience-loader.php';
require_once WLA_CORE_DIR . 'includes/story-approvals.php';

function wla_core_load_textdomain() {
	load_plugin_textdomain( 'weightloss-affordable-core', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
	if ( defined( 'NRX_CORE_BASENAME' ) ) {
		load_plugin_textdomain( 'nuestrarx-core', false, dirname( NRX_CORE_BASENAME ) . '/languages' );
	}
	load_plugin_textdomain( 'wla-experience', false, dirname( plugin_basename( WLA_EXPERIENCE_DIR . 'weightloss-affordable-experience.php' ) ) . '/languages' );
}
add_action( 'plugins_loaded', 'wla_core_load_textdomain' );

function wla_core_activate() {
	wla_register_content_types();
	if ( function_exists( 'nrx_register_post_types' ) ) { nrx_register_post_types(); }
	if ( function_exists( 'nrx_grant_capabilities' ) ) { nrx_grant_capabilities(); }
	wla_experience_register_video_type();
	flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'wla_core_activate' );

function wla_core_deactivate() {
	flush_rewrite_rules();
}
register_deactivation_hook( __FILE__, 'wla_core_deactivate' );
