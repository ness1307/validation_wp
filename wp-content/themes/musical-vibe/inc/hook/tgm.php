<?php
/**
 * Recommended plugins.
 *
 * @package Musical_Vibe
 */

if ( ! function_exists( 'musical_vibe_recommended_plugins' ) ) :

	/**
	 * Recommend plugins.
	 *
	 * @since 1.0.0
	 */
	function musical_vibe_recommended_plugins() {

		$plugins = array(
			array(
				'name'     => esc_html__( 'Team View', 'musical-vibe' ),
				'slug'     => 'team-view',
				'required' => false,
			),
			array(
				'name'     => esc_html__( 'Newsletter', 'musical-vibe' ),
				'slug'     => 'newsletter',
				'required' => false,
			),
		);

		$config = array();

		tgmpa( $plugins, $config );

	}

endif;

add_filter( 'tgmpa_register', 'musical_vibe_recommended_plugins' );
