<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Musical_Vibe
 */

	/**
	 * Hook - musical_vibe_action_after_content.
	 *
	 * @hooked musical_vibe_content_end - 10
	 */
	do_action( 'musical_vibe_action_after_content' );
?>

	<?php
	/**
	 * Hook - musical_vibe_action_before_footer.
	 *
	 * @hooked musical_vibe_footer_start - 10
	 */
	do_action( 'musical_vibe_action_before_footer' );
	?>
    <?php
	  /**
	   * Hook - musical_vibe_action_footer.
	   *
	   * @hooked musical_vibe_footer_copyright - 10
	   */
	  do_action( 'musical_vibe_action_footer' );
	?>
	<?php
	/**
	 * Hook - musical_vibe_action_after_footer.
	 *
	 * @hooked musical_vibe_footer_end - 10
	 */
	do_action( 'musical_vibe_action_after_footer' );
	?>

<?php
	/**
	 * Hook - musical_vibe_action_after.
	 *
	 * @hooked musical_vibe_page_end - 10
	 * @hooked musical_vibe_footer_goto_top - 20
	 */
	do_action( 'musical_vibe_action_after' );
?>

<?php wp_footer(); ?>
</body>
</html>
