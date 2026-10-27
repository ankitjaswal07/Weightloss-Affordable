<?php
/** WLA-styled treatment details backed by NRX records or labeled client-demo copy. */
if ( ! defined( 'ABSPATH' ) ) { exit; }

function wla_experience_render_demo_treatment_detail( $slug ) {
	foreach ( wla_experience_demo_treatments() as $demo ) {
		if ( ! in_array( $slug, array( $demo['slug'], $demo['nrx_slug'] ), true ) ) { continue; }
		$out = '<section class="wla-exp-section wla-exp-treatment-detail wla-exp-demo-card"><div class="wla-exp-detail-hero"><div class="wla-exp-detail-copy"><p class="wla-exp-demo-label">' . esc_html__( 'DEMO CONTENT · verify before publication', 'wla-experience' ) . '</p><p class="wla-exp-eyebrow">' . esc_html( $demo['class'] ) . '</p><h1 id="wla-treatment-detail-title">' . esc_html( $demo['title'] ) . '</h1><p class="wla-exp-treatment-type">' . esc_html( $demo['type'] ) . '</p><p class="wla-exp-intro">' . esc_html( $demo['description'] ) . '</p><p class="wla-exp-demo-price"><span>' . esc_html__( 'from', 'wla-experience' ) . '</span> <s>$' . esc_html( number_format_i18n( $demo['compare'], 0 ) ) . '</s> <strong>$' . esc_html( number_format_i18n( $demo['price'], 0 ) ) . '</strong><small>/' . esc_html__( 'mo', 'wla-experience' ) . '</small></p><a class="wla-exp-button" href="' . esc_url( home_url( '/consultation-eligibility/' ) ) . '">' . esc_html__( 'Check if you qualify', 'wla-experience' ) . '<span aria-hidden="true"> →</span></a></div></div><div class="wla-exp-detail-section"><ul class="wla-exp-detail-list">';
		foreach ( $demo['bullets'] as $bullet ) { $out .= '<li>' . esc_html( $bullet ) . '</li>'; }
		$out .= '</ul></div><p class="wla-exp-detail-disclaimer">' . esc_html__( 'Demo copy and client-supplied prices are not verified live terms. Confirm product, pharmacy, clinical, pricing, billing and legal details before publication. Individual results vary.', 'wla-experience' ) . '</p></section>';
		return $out;
	}
	return '';
}

function wla_experience_render_treatment_detail( $atts ) {
	$atts = shortcode_atts( array( 'slug' => '', 'title' => '', 'demo' => 'no' ), $atts, 'wla_treatment_detail' );
	$slug = sanitize_title( $atts['slug'] );
	$show_demo = 'yes' === sanitize_key( $atts['demo'] );
	if ( ! function_exists( 'nrx_treatment_data' ) || ! post_type_exists( 'nrx_treatment' ) ) {
		return $show_demo ? wla_experience_render_demo_treatment_detail( $slug ) : ( current_user_can( 'edit_posts' ) ? '<p class="wla-exp-empty">' . esc_html__( 'A published NuestraRx treatment record is required; no sample product is substituted.', 'wla-experience' ) . '</p>' : '' );
	}
	$post = $slug ? get_page_by_path( $slug, OBJECT, 'nrx_treatment' ) : get_post();
	if ( ! $post || 'nrx_treatment' !== $post->post_type ) { return $show_demo ? wla_experience_render_demo_treatment_detail( $slug ) : ''; }
	$data = nrx_treatment_data( $post );
	if ( empty( $data ) || ! empty( $data['require_approval'] ) ) { return $show_demo ? wla_experience_render_demo_treatment_detail( $slug ) : ''; }
	$name = sanitize_text_field( $atts['title'] ?: ( $data['name'] ?? get_the_title( $post ) ) );
	$tagline = sanitize_text_field( $data['tagline'] ?? '' );
	$description = isset( $data['description'] ) ? wp_kses_post( $data['description'] ) : '';
	$image = ! empty( $data['image'] ) && is_string( $data['image'] ) ? $data['image'] : '';
	if ( ! $image && has_post_thumbnail( $post ) ) { $image = get_the_post_thumbnail_url( $post, 'large' ); }
	$plans = is_array( $data['plans'] ?? null ) ? $data['plans'] : array();
	$woo_source = 'woocommerce' === ( $data['source'] ?? '' );
	$out = '<section class="wla-exp-section wla-exp-treatment-detail" aria-labelledby="wla-treatment-detail-title"><div class="wla-exp-detail-hero">';
	if ( $image ) { $out .= '<img class="wla-exp-detail-image" src="' . esc_url( $image ) . '" alt="' . esc_attr( $data['image_alt'] ?? $name ) . '" loading="eager" decoding="async">'; }
	$out .= '<div class="wla-exp-detail-copy"><p class="wla-exp-eyebrow">' . esc_html( $data['eyebrow'] ?? __( 'Treatment information', 'wla-experience' ) ) . '</p><h1 id="wla-treatment-detail-title">' . esc_html( $name ) . '</h1>';
	if ( $tagline ) { $out .= '<p class="wla-exp-intro">' . esc_html( $tagline ) . '</p>'; }
	if ( $description ) { $out .= '<div class="wla-exp-detail-description">' . $description . '</div>'; }
	$price = ! empty( $data['from_price'] ) && function_exists( 'nrx_treatment_price_label' ) ? nrx_treatment_price_label( $data ) : '';
	if ( $price ) { $out .= '<p class="wla-exp-detail-price">' . esc_html( $price ) . '<small>' . esc_html__( 'per month, from the configured product record', 'wla-experience' ) . '</small></p>'; }
	$out .= '<a class="wla-exp-button" href="' . esc_url( wla_experience_quote_url() ?: home_url( '/consultation-eligibility/' ) ) . '">' . esc_html__( 'Check if you qualify', 'wla-experience' ) . '<span aria-hidden="true"> →</span></a></div></div>';
	if ( ! $woo_source && $plans ) {
		$out .= '<div class="wla-exp-detail-section"><div class="wla-exp-heading"><p class="wla-exp-eyebrow">' . esc_html__( 'Available plans', 'wla-experience' ) . '</p><h2>' . esc_html__( 'Plans and prices', 'wla-experience' ) . '</h2></div><div class="wla-exp-grid wla-exp-plan-grid">';
		foreach ( $plans as $plan ) {
			$monthly = isset( $plan['monthly'] ) ? (float) $plan['monthly'] : 0;
			$total = isset( $plan['total'] ) ? (float) $plan['total'] : 0;
			$months = isset( $plan['months'] ) ? absint( $plan['months'] ) : 0;
			$out .= '<article class="wla-exp-card wla-exp-plan-card">';
			if ( ! empty( $plan['badge'] ) ) { $out .= '<p class="wla-exp-eyebrow">' . esc_html( $plan['badge'] ) . '</p>'; }
			$out .= '<h3>' . esc_html( $plan['name'] ?? '' ) . '</h3>';
			if ( $monthly > 0 ) { $out .= '<p class="wla-exp-price">$' . esc_html( number_format_i18n( $monthly, 0 ) ) . '<small>' . esc_html__( 'per month', 'wla-experience' ) . '</small></p>'; }
			if ( $total > 0 && $months > 1 ) { $out .= '<p>' . esc_html( sprintf( __( '$%1$s total for %2$d months', 'wla-experience' ), number_format_i18n( $total, 0 ), $months ) ) . '</p>'; }
			if ( ! empty( $plan['doses'] ) ) { $out .= '<p>' . esc_html( $plan['doses'] ) . '</p>'; }
			if ( ! empty( $plan['note'] ) ) { $out .= '<p class="wla-exp-disclaimer">' . esc_html( $plan['note'] ) . '</p>'; }
			$out .= '</article>';
		}
		$out .= '</div></div>';
	}
	$bullets = is_array( $data['bullets'] ?? null ) ? $data['bullets'] : array();
	if ( $bullets ) {
		$out .= '<div class="wla-exp-detail-section"><div class="wla-exp-heading"><h2>' . esc_html__( 'About this treatment', 'wla-experience' ) . '</h2></div><ul class="wla-exp-detail-list">';
		foreach ( $bullets as $bullet ) { if ( ! empty( $bullet['label'] ) ) { $out .= '<li>' . esc_html( $bullet['label'] ) . '</li>'; } }
		$out .= '</ul></div>';
	}
	if ( ! empty( $data['disclaimer'] ) ) { $out .= '<p class="wla-exp-detail-disclaimer">' . esc_html( $data['disclaimer'] ) . '</p>'; }
	return $out . '<div class="wla-exp-detail-cta"><a class="wla-exp-button" href="' . esc_url( wla_experience_quote_url() ?: home_url( '/consultation-eligibility/' ) ) . '">' . esc_html__( 'Continue to eligibility questions', 'wla-experience' ) . '<span aria-hidden="true"> →</span></a></div></section>';
}
add_shortcode( 'wla_treatment_detail', 'wla_experience_render_treatment_detail' );
