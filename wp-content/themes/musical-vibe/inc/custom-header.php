<?php
/**
 * Custom Header feature.
 *
 * @link http://codex.wordpress.org/Custom_Headers
 *
 * @package Musical_Vibe
 */

/**
 * Set up the WordPress core custom header feature.
 *
 * @since 1.0.0
 */
function musical_vibe_custom_header_setup() {
	add_theme_support( 'custom-header', apply_filters( 'musical_vibe_custom_header_args', array(
			'default-image' => get_template_directory_uri() . '/images/header-banner.jpg',
			'width'         => 1920,
			'height'        => 500,
			'flex-height'   => true,
			'header-text'   => false,
	) ) );

	// Register default headers.
	register_default_headers( array(
		'main-banner' => array(
			'url'           => '%s/images/header-banner.jpg',
			'thumbnail_url' => '%s/images/header-banner.jpg',
			'description'   => __( 'Main Banner', 'musical-vibe' ),
		),

	) );

}

add_action( 'after_setup_theme', 'musical_vibe_custom_header_setup' );
