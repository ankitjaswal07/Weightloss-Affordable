<?php
/** WLA-styled treatment details backed by the bundled NuestraRx catalog. */
get_header();
?>
<main id="main-content" class="wla-elementor-canvas-reset">
	<?php
	while ( have_posts() ) :
		the_post();
		if ( shortcode_exists( 'wla_treatment_detail' ) ) {
			echo do_shortcode( '[wla_treatment_detail]' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- the component escapes source fields.
		} else {
			the_content();
		}
	endwhile;
	?>
</main>
<?php get_footer();
