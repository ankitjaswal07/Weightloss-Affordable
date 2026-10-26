<?php
/**
 * Default settings and sanitization.
 *
 * Content defaults mirror the reference site (nuestrarx.com). Every value
 * is editable in wp-admin and values that make a compliance claim are
 * tracked by the compliance register.
 *
 * @package NuestraRx_Core
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Default option values.
 *
 * @return array
 */
function nrx_default_settings() {
	return array(
		// Brand and legal identity.
		'brand_name'          => 'NuestraRx',
		'brand_tagline_es'    => 'Salud en tu idioma',
		'brand_tagline_en'    => 'Healthcare in your language',
		'legal_name'          => 'NuestraRx LLC',
		'address'             => '5935 NE 2nd Ave, Miami, FL 33137, Estados Unidos',
		'phone_display'       => '+1 (786) 882-3367',
		'phone_e164'          => '+17868823367',
		'whatsapp'            => '17868823367',
		'contact_email'       => 'hola@nuestrarx.com',
		'privacy_email'       => 'privacidad@nuestrarx.com',
		'safety_email'        => 'seguridad@nuestrarx.com',
		'support_email'       => 'soporte@nuestrarx.com',
		'instagram_url'       => 'https://instagram.com/nuestra.rx',
		'facebook_url'        => 'https://facebook.com/NuestraRx',
		'legitscript_url'     => 'https://www.legitscript.com/websites/?checker_keywords=nuestrarx.com',

		// Clinical operating model (published facts from the reference site).
		'clinical_partner'    => 'Beluga Health',
		'clinical_partner_url' => 'https://www.belugahealth.com/',
		'clinical_partner_about' => 'https://www.belugahealth.com/about',
		'processing_partner'  => 'NMI',
		'processing_partner_url' => 'https://www.nmi.com/',
		'pharmacy_model'      => 'Farmacias 503A / 503B con licencia en EE. UU.',
		'service_states_note' => '50 estados, Washington D.C. y Puerto Rico',

		// Conversion links.
		'intake_slug'         => 'evaluacion',
		'patient_portal_url'  => 'https://patient.nuestrarx.com/login',
		'checkout_url'        => '',
		'payment_page_slug'   => 'pago-semanal',
		'blog_url'            => '/blog/',
		'reschedule_url'      => '',
		'header_cta_label_es' => '¿Califico?',
		'header_cta_label_en' => 'Do I qualify?',
		'header_cta_url'      => '/evaluacion/',

		// Global disclosures.
		'footer_disclaimer'   => 'NuestraRx es una plataforma de telemedicina que conecta pacientes con médicos licenciados independientes y farmacias 503A/503B autorizadas. NuestraRx no practica medicina; todas las decisiones clínicas las toman médicos independientes. Los medicamentos compuestos (semaglutida y tirzepatida compuestas) son preparados por farmacias 503A/503B autorizadas y no son medicamentos aprobados directamente por la FDA ni bioequivalentes a los medicamentos de marca. Los resultados individuales varían y no están garantizados. NuestraRx no es una farmacia ni un proveedor de salud. Los servicios clínicos son provistos por Beluga Health, un grupo médico de telemedicina con licencia. Las prescripciones son surtidas y enviadas por farmacias con licencia en EE. UU. La elegibilidad varía por estado. Debes tener 18 años o más para usar este servicio. Este sitio es solo informativo y no sustituye el consejo médico profesional.',
		'results_disclaimer'  => 'Los resultados individuales varían y no están garantizados. La elegibilidad clínica y la receta las determina un médico con licencia.',
		'testimonials_disclaimer' => 'Testimonios de pacientes reales, compensados solo por tiempo de entrevista. Los resultados individuales varían y no están garantizados.',
		'compounding_disclaimer' => 'Los medicamentos compuestos GLP-1 no están aprobados directamente por la FDA ni son bioequivalentes a los medicamentos de marca. Son preparados por farmacias 503A/503B con licencia estatal bajo supervisión médica.',

		// Quiz configuration (editable through the builder as well).
		// Public intake submissions stay disabled until compliance, privacy and handoff are verified.
		'quiz_submissions_enabled' => 0,
		'quiz_min_bmi'        => 25,
		'quiz_require_state'  => 1,
		'states_unavailable'  => array(),
		'quiz_notify_email'   => '',
		'quiz_webhook_url'    => '',
		'quiz_webhook_secret' => '',
		'store_clinical_answers' => 0,
		'intake_retention_days'  => 90,
		'quiz_analytics_events'  => 0,

		// Inquiry form.
		'inquiry_notify_email' => '',
		'inquiry_webhook_url'  => '',

		// Privacy / analytics. All tags are only loaded after consent.
		'analytics_enabled'   => 0,
		'ga_measurement_id'   => '',
		'meta_pixel_id'       => '',
		'tiktok_pixel_id'     => '',
		'privacy_page_url'    => '/politica-de-privacidad/',
		'hipaa_page_url'      => '/aviso-hipaa/',
		'terms_page_url'      => '/terminos-de-servicio/',
		'refund_page_url'     => '/politica-de-reembolso/',
		'safety_page_url'     => '/informacion-de-seguridad/',
		'compliance_page_url' => '/cumplimiento/',
		'do_not_sell_url'     => '/politica-de-privacidad/#no-vender',

		// Presentation.
		'default_lang'        => 'es',
		'google_fonts'        => 1,
		'load_parent_motion'  => 0,
		'brand_accent'        => '#d19a67',
		'compliance_approved' => 0,
		'claims_reviewed_at'  => '',
	);
}

/**
 * Sanitize a settings patch coming from the settings screen.
 *
 * @param array $input Raw input.
 * @return array
 */
function nrx_sanitize_settings( $input ) {
	$input    = is_array( $input ) ? $input : array();
	$defaults = nrx_default_settings();
	$out      = array();

	$text_keys = array(
		'brand_name', 'brand_tagline_es', 'brand_tagline_en', 'legal_name', 'address',
		'phone_display', 'phone_e164', 'whatsapp', 'contact_email', 'privacy_email',
		'safety_email', 'support_email', 'clinical_partner', 'processing_partner',
		'pharmacy_model', 'service_states_note', 'intake_slug', 'payment_page_slug',
		'header_cta_label_es', 'header_cta_label_en', 'quiz_notify_email',
		'inquiry_notify_email', 'ga_measurement_id', 'meta_pixel_id', 'tiktok_pixel_id',
		'default_lang', 'brand_accent', 'claims_reviewed_at',
	);
	foreach ( $text_keys as $key ) {
		if ( array_key_exists( $key, $input ) ) {
			$value        = 'default_lang' === $key ? sanitize_key( $input[ $key ] ) : sanitize_text_field( $input[ $key ] );
			$out[ $key ]  = $value;
		}
	}

	$email_keys = array( 'contact_email', 'privacy_email', 'safety_email', 'support_email', 'quiz_notify_email', 'inquiry_notify_email' );
	foreach ( $email_keys as $key ) {
		if ( isset( $out[ $key ] ) ) {
			$out[ $key ] = sanitize_email( $out[ $key ] );
		}
	}

	$url_keys = array(
		'instagram_url', 'facebook_url', 'legitscript_url', 'clinical_partner_url',
		'clinical_partner_about', 'processing_partner_url', 'patient_portal_url',
		'checkout_url', 'reschedule_url', 'quiz_webhook_url', 'inquiry_webhook_url',
		'privacy_page_url', 'hipaa_page_url', 'terms_page_url', 'refund_page_url',
		'safety_page_url', 'compliance_page_url', 'do_not_sell_url', 'blog_url',
	);
	foreach ( $url_keys as $key ) {
		if ( array_key_exists( $key, $input ) ) {
			$value       = trim( (string) $input[ $key ] );
			$out[ $key ] = ( 0 === strpos( $value, '/' ) ) ? sanitize_text_field( $value ) : esc_url_raw( $value );
		}
	}

	$html_keys = array( 'footer_disclaimer', 'results_disclaimer', 'testimonials_disclaimer', 'compounding_disclaimer' );
	foreach ( $html_keys as $key ) {
		if ( array_key_exists( $key, $input ) ) {
			$out[ $key ] = wp_kses_post( $input[ $key ] );
		}
	}

	$bool_keys = array( 'quiz_require_state', 'store_clinical_answers', 'quiz_analytics_events', 'analytics_enabled', 'google_fonts', 'load_parent_motion', 'compliance_approved' );
	foreach ( $bool_keys as $key ) {
		$out[ $key ] = ! empty( $input[ $key ] ) ? 1 : 0;
	}

	$int_keys = array( 'quiz_min_bmi', 'intake_retention_days' );
	foreach ( $int_keys as $key ) {
		if ( array_key_exists( $key, $input ) ) {
			$out[ $key ] = max( 0, (int) $input[ $key ] );
		}
	}

	if ( isset( $input['states_unavailable'] ) ) {
		$states = is_array( $input['states_unavailable'] ) ? $input['states_unavailable'] : array();
		$valid  = array_keys( nrx_states() );
		$out['states_unavailable'] = array_values( array_intersect( array_map( 'strtoupper', array_map( 'sanitize_text_field', $states ) ), $valid ) );
	}

	// Preserve secret without re-echoing it in the form.
	if ( isset( $input['quiz_webhook_secret'] ) && '' !== trim( (string) $input['quiz_webhook_secret'] ) ) {
		$out['quiz_webhook_secret'] = sanitize_text_field( $input['quiz_webhook_secret'] );
	}

	foreach ( $defaults as $key => $default ) {
		if ( ! array_key_exists( $key, $out ) ) {
			$existing     = nrx_settings();
			$out[ $key ]  = array_key_exists( $key, $existing ) ? $existing[ $key ] : $default;
		}
	}

	return $out;
}
