<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Musical_Vibe
 */

?><?php
	/**
	 * Hook - musical_vibe_action_doctype.
	 *
	 * @hooked musical_vibe_doctype -  10
	 */
	do_action( 'musical_vibe_action_doctype' );
?>
<head>
	<?php
	/**
	 * Hook - musical_vibe_action_head.
	 *
	 * @hooked musical_vibe_head -  10
	 */
	do_action( 'musical_vibe_action_head' );
	?>

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<?php
	/**
	 * Hook - musical_vibe_action_before.
	 *
	 * @hooked musical_vibe_page_start - 10
	 * @hooked musical_vibe_skip_to_content - 15
	 */
	do_action( 'musical_vibe_action_before' );
	?>

    <?php
	  /**
	   * Hook - musical_vibe_action_before_header.
	   *
	   * @hooked musical_vibe_header_top_content - 5
	   * @hooked musical_vibe_header_start - 10
	   */
	  do_action( 'musical_vibe_action_before_header' );
	?>
		<?php
		/**
		 * Hook - musical_vibe_action_header.
		 *
		 * @hooked musical_vibe_site_branding - 10
		 */
		do_action( 'musical_vibe_action_header' );
		?>
	<?php
	  /**
	   * Hook - musical_vibe_action_after_header.
	   *
	   * @hooked musical_vibe_header_end - 10
	   */
	  do_action( 'musical_vibe_action_after_header' );
	?>

	<?php
	/**
	 * Hook - musical_vibe_action_before_content.
	 *
	 * @hooked musical_vibe_content_start - 10
	 */
	do_action( 'musical_vibe_action_before_content' );
	?>
	<?php
	  /**
	   * Hook - musical_vibe_action_content.
	   */
	  do_action( 'musical_vibe_action_content' );
	?>
