<?php
/**
 * Helper functions related to customizer and options.
 *
 * @package Musical_Vibe
 */

if ( ! function_exists( 'musical_vibe_get_global_layout_options' ) ) :

	/**
	 * Returns global layout options.
	 *
	 * @since 1.0.0
	 *
	 * @return array Options array.
	 */
	function musical_vibe_get_global_layout_options() {

		$choices = array(
			'left-sidebar'  => esc_html__( 'Primary Sidebar - Content', 'musical-vibe' ),
			'right-sidebar' => esc_html__( 'Content - Primary Sidebar', 'musical-vibe' ),
			'three-columns' => esc_html__( 'Three Columns', 'musical-vibe' ),
			'no-sidebar'    => esc_html__( 'No Sidebar', 'musical-vibe' ),
		);
		$output = apply_filters( 'musical_vibe_filter_layout_options', $choices );
		return $output;

	}

endif;

if ( ! function_exists( 'musical_vibe_get_breadcrumb_type_options' ) ) :

	/**
	 * Returns breadcrumb type options.
	 *
	 * @since 1.0.0
	 *
	 * @return array Options array.
	 */
	function musical_vibe_get_breadcrumb_type_options() {

		$choices = array(
			'disabled' => esc_html__( 'Disabled', 'musical-vibe' ),
			'simple'   => esc_html__( 'Enabled', 'musical-vibe' ),
		);
		return $choices;

	}

endif;


if ( ! function_exists( 'musical_vibe_get_archive_layout_options' ) ) :

	/**
	 * Returns archive layout options.
	 *
	 * @since 1.0.0
	 *
	 * @return array Options array.
	 */
	function musical_vibe_get_archive_layout_options() {

		$choices = array(
			'full'    => esc_html__( 'Full Post', 'musical-vibe' ),
			'excerpt' => esc_html__( 'Post Excerpt', 'musical-vibe' ),
		);
		$output = apply_filters( 'musical_vibe_filter_archive_layout_options', $choices );
		if ( ! empty( $output ) ) {
			ksort( $output );
		}
		return $output;

	}

endif;

if ( ! function_exists( 'musical_vibe_get_image_sizes_options' ) ) :

	/**
	 * Returns image sizes options.
	 *
	 * @since 1.0.0
	 *
	 * @param bool  $add_disable True for adding No Image option.
	 * @param array $allowed Allowed image size options.
	 * @return array Image size options.
	 */
	function musical_vibe_get_image_sizes_options( $add_disable = true, $allowed = array(), $show_dimension = true ) {

		global $_wp_additional_image_sizes;
		$get_intermediate_image_sizes = get_intermediate_image_sizes();
		$choices = array();
		if ( true === $add_disable ) {
			$choices['disable'] = esc_html__( 'No Image', 'musical-vibe' );
		}
		$choices['thumbnail'] = esc_html__( 'Thumbnail', 'musical-vibe' );
		$choices['medium']    = esc_html__( 'Medium', 'musical-vibe' );
		$choices['large']     = esc_html__( 'Large', 'musical-vibe' );
		$choices['full']      = esc_html__( 'Full (original)', 'musical-vibe' );

		if ( true === $show_dimension ) {
			foreach ( array( 'thumbnail', 'medium', 'large' ) as $key => $_size ) {
				$choices[ $_size ] = $choices[ $_size ] . ' (' . get_option( $_size . '_size_w' ) . 'x' . get_option( $_size . '_size_h' ) . ')';
			}
		}

		if ( ! empty( $_wp_additional_image_sizes ) && is_array( $_wp_additional_image_sizes ) ) {
			foreach ( $_wp_additional_image_sizes as $key => $size ) {
				$choices[ $key ] = $key;
				if ( true === $show_dimension ) {
					$choices[ $key ] .= ' (' . $size['width'] . 'x' . $size['height'] . ')';
				}
			}
		}

		if ( ! empty( $allowed ) ) {
			foreach ( $choices as $key => $value ) {
				if ( ! in_array( $key, $allowed ) ) {
					unset( $choices[ $key ] );
				}
			}
		}

		return $choices;

	}

endif;

if ( ! function_exists( 'musical_vibe_get_image_alignment_options' ) ) :

	/**
	 * Returns image alignment options.
	 *
	 * @since 1.0.0
	 *
	 * @return array Options array.
	 */
	function musical_vibe_get_image_alignment_options() {

		$choices = array(
			'none'   => esc_html_x( 'None', 'alignment', 'musical-vibe' ),
			'left'   => esc_html_x( 'Left', 'alignment', 'musical-vibe' ),
			'center' => esc_html_x( 'Center', 'alignment', 'musical-vibe' ),
			'right'  => esc_html_x( 'Right', 'alignment', 'musical-vibe' ),
		);
		return $choices;

	}

endif;

if ( ! function_exists( 'musical_vibe_get_slider_caption_alignment_options' ) ) :

	/**
	 * Returns slider caption alignment options.
	 *
	 * @since 1.0.0
	 *
	 * @return array Options array.
	 */
	function musical_vibe_get_slider_caption_alignment_options() {

		$choices = array(
			'left'   => esc_html_x( 'Left', 'alignment', 'musical-vibe' ),
			'center' => esc_html_x( 'Center', 'alignment', 'musical-vibe' ),
			'right'  => esc_html_x( 'Right', 'alignment', 'musical-vibe' ),
		);
		return $choices;

	}

endif;

if ( ! function_exists( 'musical_vibe_get_featured_slider_transition_effects' ) ) :

	/**
	 * Returns the featured slider transition effects.
	 *
	 * @since 1.0.0
	 *
	 * @return array Options array.
	 */
	function musical_vibe_get_featured_slider_transition_effects() {

		$choices = array(
			'fade'       => _x( 'fade', 'transition effect', 'musical-vibe' ),
			'fadeout'    => _x( 'fadeout', 'transition effect', 'musical-vibe' ),
			'none'       => _x( 'none', 'transition effect', 'musical-vibe' ),
			'scrollHorz' => _x( 'scrollHorz', 'transition effect', 'musical-vibe' ),
		);
		$output = apply_filters( 'musical_vibe_filter_featured_slider_transition_effects', $choices );
		if ( ! empty( $output ) ) {
			ksort( $output );
		}
		return $output;

	}

endif;

if ( ! function_exists( 'musical_vibe_get_featured_slider_content_options' ) ) :

	/**
	 * Returns the featured slider content options.
	 *
	 * @since 1.0.0
	 *
	 * @return array Options array.
	 */
	function musical_vibe_get_featured_slider_content_options() {

		$choices = array(
			'home-page' => esc_html__( 'Static Front Page Only', 'musical-vibe' ),
			'disabled'  => esc_html__( 'Disabled', 'musical-vibe' ),
		);
		$output = apply_filters( 'musical_vibe_filter_featured_slider_content_options', $choices );
		if ( ! empty( $output ) ) {
			ksort( $output );
		}
		return $output;

	}

endif;

if ( ! function_exists( 'musical_vibe_get_featured_slider_type' ) ) :

	/**
	 * Returns the featured slider type.
	 *
	 * @since 1.0.0
	 *
	 * @return array Options array.
	 */
	function musical_vibe_get_featured_slider_type() {

		$choices = array(
			'featured-page' => __( 'Featured Pages', 'musical-vibe' ),
		);
		$output = apply_filters( 'musical_vibe_filter_featured_slider_type', $choices );
		if ( ! empty( $output ) ) {
			ksort( $output );
		}
		return $output;

	}

endif;

if ( ! function_exists( 'musical_vibe_get_featured_content_status_options' ) ) :

	/**
	 * Returns the featured content options.
	 *
	 * @since 1.0.0
	 *
	 * @return array Options array.
	 */
	function musical_vibe_get_featured_content_status_options() {

		$choices = array(
			'home-page' => esc_html__( 'Home Page Only', 'musical-vibe' ),
			'disabled'  => esc_html__( 'Disabled', 'musical-vibe' ),
		);
		$output = apply_filters( 'musical_vibe_filter_featured_content_status_options', $choices );
		if ( ! empty( $output ) ) {
			ksort( $output );
		}
		return $output;

	}

endif;

if ( ! function_exists( 'musical_vibe_get_numbers_dropdown_options' ) ) :

	/**
	 * Returns numbers dropdown options.
	 *
	 * @since 1.0.0
	 *
	 * @param int $min Min.
	 * @param int $max Max.
	 *
	 * @return array Options array.
	 */
	function musical_vibe_get_numbers_dropdown_options( $min = 1, $max = 4 ) {

		$output = array();

		if ( $min <= $max ) {
			for ( $i = $min; $i <= $max; $i++ ) {
				$output[ $i ] = $i;
			}
		}

		return $output;

	}

endif;
