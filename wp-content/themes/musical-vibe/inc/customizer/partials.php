<?php
/**
 * Customizer partials.
 *
 * @package Musical_Vibe
 */

/**
 * Render the site title for the selective refresh partial.
 *
 * @since 1.0.0
 *
 * @return void
 */
function musical_vibe_customize_partial_blogname() {

	bloginfo( 'name' );

}

/**
 * Render the site description for the selective refresh partial.
 *
 * @since 1.0.0
 *
 * @return void
 */
function musical_vibe_customize_partial_blogdescription() {

	bloginfo( 'description' );

}

/**
 * Partial for copyright text.
 *
 * @since 1.0.0
 *
 * @return void
 */
function musical_vibe_render_partial_copyright_text() {

	$copyright_text = musical_vibe_get_option( 'copyright_text' );
	$copyright_text = apply_filters( 'musical_vibe_filter_copyright_text', $copyright_text );
	if ( ! empty( $copyright_text ) ) {
		$copyright_text = wp_kses_data( $copyright_text );
	}
	echo $copyright_text;

}
