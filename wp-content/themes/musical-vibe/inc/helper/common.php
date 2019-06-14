<?php
/**
 * Common helper functions.
 *
 * @package Musical_Vibe
 */

if ( ! function_exists( 'musical_vibe_the_excerpt' ) ) :

	/**
	 * Generate excerpt.
	 *
	 * @since 1.0.0
	 *
	 * @param int     $length Excerpt length in words.
	 * @param WP_Post $post_obj WP_Post instance (Optional).
	 * @return string Excerpt.
	 */
	function musical_vibe_the_excerpt( $length = 15, $post_obj = null ) {

		global $post;
		if ( is_null( $post_obj ) ) {
			$post_obj = $post;
		}
		$length = absint( $length );
		if ( $length < 1 ) {
			$length = 40;
		}
		$source_content = $post_obj->post_content;
		if ( ! empty( $post_obj->post_excerpt ) ) {
			$source_content = $post_obj->post_excerpt;
		}
		$source_content = preg_replace( '`\[[^\]]*\]`', '', $source_content );
		$trimmed_content = wp_trim_words( $source_content, $length, '...' );
		return $trimmed_content;

	}

endif;

if ( ! function_exists( 'musical_vibe_simple_breadcrumb' ) ) :

	/**
	 * Simple breadcrumb.
	 *
	 * @since 1.0.0
	 */
	function musical_vibe_simple_breadcrumb() {

		if ( ! function_exists( 'breadcrumb_trail' ) ) {
			require_once get_template_directory() . '/lib/breadcrumbs/breadcrumbs.php';
		}

		$breadcrumb_args = array(
			'container'   => 'div',
			'show_browse' => false,
		);
		breadcrumb_trail( $breadcrumb_args );

	}

endif;

if ( ! function_exists( 'musical_vibe_fonts_url' ) ) :

	/**
	 * Return fonts URL.
	 *
	 * @since 1.0.0
	 * @return string Fonts URL.
	 */
	function musical_vibe_fonts_url() {

		$fonts_url = '';
		// TODO

		return $fonts_url;

	}

endif;

if( ! function_exists( 'musical_vibe_get_sidebar_options' ) ) :

	/**
	 * Get sidebar options.
	 *
	 * @since 1.0.0
	 */
	function musical_vibe_get_sidebar_options() {

		global $wp_registered_sidebars;

		$output = array();

		if ( ! empty( $wp_registered_sidebars ) && is_array( $wp_registered_sidebars ) ) {
			foreach ( $wp_registered_sidebars as $key => $sidebar ) {
				$output[$key] = $sidebar['name'];
			}
		}

		return $output;

	}

endif;

if( ! function_exists( 'musical_vibe_primary_navigation_fallback' ) ) :

	/**
	 * Fallback for primary navigation.
	 *
	 * @since 1.0.0
	 */
	function musical_vibe_primary_navigation_fallback() {
		echo '<ul>';
		echo '<li><a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( 'Home', 'musical-vibe' ). '</a></li>';
		wp_list_pages( array(
			'title_li' => '',
			'depth'    => 1,
			'number'   => 5,
		) );
		echo '</ul>';

	}

endif;

if ( ! function_exists( 'musical_vibe_the_custom_logo' ) ) :

	/**
	 * Render logo.
	 *
	 * @since 1.0.0
	 */
	function musical_vibe_the_custom_logo() {

		if ( function_exists( 'the_custom_logo' ) ) {
			the_custom_logo();
		}

	}

endif;

/**
 * Sanitize post ID.
 *
 * @since 1.0.0
 *
 * @param string $key Field key.
 * @param array  $field Field detail.
 * @param mixed  $value Raw value.
 * @return mixed Sanitized value.
 */
function musical_vibe_widget_sanitize_post_id( $key, $field, $value ) {

	$output = '';
	$value = absint( $value );
	if ( $value ) {
		$not_allowed = array( 'revision', 'attachment', 'nav_menu_item' );
		$post_type = get_post_type( $value );
		if ( ! in_array( $post_type, $not_allowed ) && 'publish' === get_post_status( $value ) ) {
			$output = $value;
		}
	}
	return $output;

}

if ( ! function_exists( 'musical_vibe_get_index_page_id' ) ) :

	/**
	 * Get front index page ID.
	 *
	 * @since 1.0.0
	 *
	 * @param string $type Type.
	 * @return int Corresponding Page ID.
	 */
	function musical_vibe_get_index_page_id( $type = 'front' ) {

		$page = '';

		switch ( $type ) {
			case 'front':
				$page = get_option( 'page_on_front' );
				break;

			case 'blog':
				$page = get_option( 'page_for_posts' );
				break;

			default:
				break;
		}

		$page = absint( $page );

		return $page;

	}
endif;

if ( ! function_exists( 'musical_vibe_render_select_dropdown' ) ) :

	/**
	 * Render select dropdown.
	 *
	 * @since 1.0.0
	 *
	 * @param array  $main_args     Main arguments.
	 * @param string $callback      Callback method.
	 * @param array  $callback_args Callback arguments.
	 * @return string Rendered markup.
	 */
	function musical_vibe_render_select_dropdown( $main_args, $callback, $callback_args = array() ) {

		$defaults = array(
			'id'          => '',
			'name'        => '',
			'selected'    => 0,
			'echo'        => true,
			'add_default' => false,
			);

		$r = wp_parse_args( $main_args, $defaults );
		$output = '';
		$choices = array();

		if ( is_callable( $callback ) ) {
			$choices = call_user_func_array( $callback, $callback_args );
		}

		if ( ! empty( $choices ) || true === $r['add_default'] ) {

			$output = "<select name='" . esc_attr( $r['name'] ) . "' id='" . esc_attr( $r['id'] ) . "'>\n";
			if ( true === $r['add_default'] ) {
				$output .= '<option value="">' . esc_html__( 'Default', 'musical-vibe' ) . '</option>\n';
			}
			if ( ! empty( $choices ) ) {
				foreach ( $choices as $key => $choice ) {
					$output .= '<option value="' . esc_attr( $key ) . '" ';
					$output .= selected( $r['selected'], $key, false );
					$output .= '>' . esc_html( $choice ) . '</option>\n';
				}
			}
			$output .= "</select>\n";
		}

		if ( $r['echo'] ) {
			echo $output;
		}
		return $output;

	}

endif;

if ( ! function_exists( 'musical_vibe_get_single_post_category' ) ) :

	/**
	 * Get single post category.
	 *
	 * @since 1.0.0
	 *
	 * @param WP_Post $post_obj WP_Post instance.
	 * @return array Category details.
	 */
	function musical_vibe_get_single_post_category( $post_obj = null ) {

		$output = array();

		global $post;

		if ( is_null( $post_obj ) ) {
			$post_obj = $post;
		}

		$terms = get_the_terms( $post_obj, 'category' );

		if ( ! is_wp_error( $terms ) && ! empty( $terms ) ) {
			$first_term = array_shift( $terms );
			$output['name']    = $first_term->name;
			$output['slug']    = $first_term->slug;
			$output['term_id'] = $first_term->term_id;
			$output['url']     = get_term_link( $first_term );
		}

		return $output;
	}

endif;

if ( ! function_exists( 'musical_vibe_is_woocommerce_active' ) ) :

	/**
	 * Check if WooCommerce is active.
	 *
	 * @since 1.0.0
	 *
	 * @return bool Active status.
	 */
	function musical_vibe_is_woocommerce_active() {
		$output = false;

		if ( class_exists( 'WooCommerce' ) ) {
			$output = true;
		}

		return $output;
	}

endif;
