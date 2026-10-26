<?php
/** Safe, idempotent seed of the original NRX quiz draft and held treatment records. */
if ( ! defined( 'ABSPATH' ) ) { exit; }

function wla_core_seed_nuestra_demo_data( &$report = null ) {
	if ( function_exists( 'nrx_quiz_default_config' ) && false === get_option( 'nrx_quiz_draft', false ) ) {
		$draft = nrx_quiz_default_config();
		$draft['version'] = 1;
		update_option( 'nrx_quiz_draft', nrx_quiz_normalize( $draft ), false );
	}
	if ( function_exists( 'nrx_seed_treatment' ) && defined( 'NRX_CORE_DIR' ) ) {
		$records = require NRX_CORE_DIR . 'content/treatments.php';
		foreach ( $records as $slug => $record ) {
			if ( get_page_by_path( $slug, OBJECT, 'nrx_treatment' ) ) { continue; }
			$record['fields']['require_approval'] = 1;
			$id = nrx_seed_treatment( $slug, $record );
			if ( $id ) {
				wp_update_post( array( 'ID' => $id, 'post_status' => 'draft' ) );
				if ( is_array( $report ) ) { $report['drafts'] = ( $report['drafts'] ?? 0 ) + 1; }
			}
		}
	}
	if ( is_array( $report ) ) {
		$report['warnings'][] = __( 'The original NuestraRx quiz is included; public submissions are disabled by default. Treatment seed records remain drafts pending clinical, pharmacy, price and legal review.', 'weightloss-affordable-core' );
	}
}
