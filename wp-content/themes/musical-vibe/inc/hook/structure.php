<?php
/**
 * Theme functions related to structure.
 *
 * This file contains structural hook functions.
 *
 * @package Musical_Vibe
 */

if ( ! function_exists( 'musical_vibe_doctype' ) ) :
	/**
	 * Doctype Declaration.
	 *
	 * @since 1.0.0
	 */
	function musical_vibe_doctype() {
	?><!DOCTYPE html> <html <?php language_attributes(); ?>><?php
	}
endif;

add_action( 'musical_vibe_action_doctype', 'musical_vibe_doctype', 10 );


if ( ! function_exists( 'musical_vibe_head' ) ) :
	/**
	 * Header Codes.
	 *
	 * @since 1.0.0
	 */
	function musical_vibe_head() {
		?>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="profile" href="http://gmpg.org/xfn/11">
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
		<?php
	}
endif;
add_action( 'musical_vibe_action_head', 'musical_vibe_head', 10 );

if ( ! function_exists( 'musical_vibe_page_start' ) ) :
	/**
	 * Page Start.
	 *
	 * @since 1.0.0
	 */
	function musical_vibe_page_start() {
		?>
		<div id="page" class="hfeed site">
		<?php
	}
endif;
add_action( 'musical_vibe_action_before', 'musical_vibe_page_start' );

if ( ! function_exists( 'musical_vibe_page_end' ) ) :
	/**
	 * Page End.
	 *
	 * @since 1.0.0
	 */
	function musical_vibe_page_end() {
	?></div><!-- #page --><?php
	}
endif;

add_action( 'musical_vibe_action_after', 'musical_vibe_page_end' );

if ( ! function_exists( 'musical_vibe_content_start' ) ) :
	/**
	 * Content Start.
	 *
	 * @since 1.0.0
	 */
	function musical_vibe_content_start() {
	?><div id="content" class="site-content"><div class="container"><div class="inner-wrapper"><?php
	}
endif;

add_action( 'musical_vibe_action_before_content', 'musical_vibe_content_start' );

if ( ! function_exists( 'musical_vibe_content_end' ) ) :
	/**
	 * Content End.
	 *
	 * @since 1.0.0
	 */
	function musical_vibe_content_end() {
		?></div><!-- .inner-wrapper --></div><!-- .container --></div><!-- #content --><?php
	}
endif;

add_action( 'musical_vibe_action_after_content', 'musical_vibe_content_end' );

if ( ! function_exists( 'musical_vibe_header_start' ) ) :
	/**
	 * Header Start.
	 *
	 * @since 1.0.0
	 */
	function musical_vibe_header_start() {
		?><header id="masthead" class="site-header" role="banner"><div class="container"><?php
	}
endif;

add_action( 'musical_vibe_action_before_header', 'musical_vibe_header_start' );

if ( ! function_exists( 'musical_vibe_header_end' ) ) :
	/**
	 * Header End.
	 *
	 * @since 1.0.0
	 */
	function musical_vibe_header_end() {
		?></div><!-- .container --></header><!-- #masthead --><?php
	}
endif;

add_action( 'musical_vibe_action_after_header', 'musical_vibe_header_end' );



if ( ! function_exists( 'musical_vibe_footer_start' ) ) :
	/**
	 * Footer Start.
	 *
	 * @since 1.0.0
	 */
	function musical_vibe_footer_start() {
		$footer_status = apply_filters( 'musical_vibe_filter_footer_status', true );
		if ( true !== $footer_status ) {
			return;
		}
	?><footer id="colophon" class="site-footer" role="contentinfo"><div class="container"><?php
	}
endif;
add_action( 'musical_vibe_action_before_footer', 'musical_vibe_footer_start' );


if ( ! function_exists( 'musical_vibe_footer_end' ) ) :
	/**
	 * Footer End.
	 *
	 * @since 1.0.0
	 */
	function musical_vibe_footer_end() {
		$footer_status = apply_filters( 'musical_vibe_filter_footer_status', true );
		if ( true !== $footer_status ) {
			return;
		}
	?></div><!-- .container --></footer><!-- #colophon --><?php
	}
endif;
add_action( 'musical_vibe_action_after_footer', 'musical_vibe_footer_end' );
