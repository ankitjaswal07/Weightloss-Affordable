<?php
/**
 * Plugin Name: WeightLossAffordable Experience
 * Description: Native WeightLossAffordable treatment, quote, result, video and calculator components for the existing theme and Elementor.
 * Version: 1.0.0
 * Requires at least: 6.6
 * Requires PHP: 7.4
 * License: GPL-2.0-or-later
 * Text Domain: wla-experience
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

define( 'WLA_EXPERIENCE_VERSION', '1.0.0' );
define( 'WLA_EXPERIENCE_FILE', __FILE__ );
define( 'WLA_EXPERIENCE_DIR', plugin_dir_path( __FILE__ ) );
define( 'WLA_EXPERIENCE_URL', plugin_dir_url( __FILE__ ) );

require_once WLA_EXPERIENCE_DIR . 'includes/content.php';
require_once WLA_EXPERIENCE_DIR . 'includes/shortcodes.php';
require_once WLA_EXPERIENCE_DIR . 'includes/elementor.php';
require_once WLA_EXPERIENCE_DIR . 'includes/nuestra-quiz-bridge.php';

function wla_experience_page_has_components() {
	$post = get_post();
	if ( ! $post ) { return false; }
	$content = (string) $post->post_content . ' ' . (string) get_post_meta( $post->ID, '_elementor_data', true );
	foreach ( array( '[wla_treatment_plans', '[wla_get_quote', '[wla_results', '[wla_video_testimonials', '[wla_calculators', 'wla-experience-component' ) as $marker ) {
		if ( false !== strpos( $content, $marker ) ) { return true; }
	}
	return false;
}
function wla_experience_assets() {
	if ( ! wla_experience_page_has_components() ) { return; }
	wp_enqueue_style( 'wla-experience', WLA_EXPERIENCE_URL . 'assets/experience.css', array(), WLA_EXPERIENCE_VERSION );
	wp_enqueue_script( 'wla-calculators', WLA_EXPERIENCE_URL . 'assets/calculators.js', array(), WLA_EXPERIENCE_VERSION, true );
	wp_enqueue_script( 'wla-videos', WLA_EXPERIENCE_URL . 'assets/videos.js', array(), WLA_EXPERIENCE_VERSION, true );
}
add_action( 'wp_enqueue_scripts', 'wla_experience_assets' );

register_activation_hook( __FILE__, function() { wla_experience_register_video_type(); flush_rewrite_rules(); } );
register_deactivation_hook( __FILE__, 'flush_rewrite_rules' );
