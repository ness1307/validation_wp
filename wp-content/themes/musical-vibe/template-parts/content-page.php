<?php
/**
 * Template part for displaying page content in page.php.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Musical_Vibe
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <?php
	  /**
	   * Hook - musical_vibe_single_image.
	   *
	   * @hooked musical_vibe_add_image_in_single_display -  10
	   */
	  do_action( 'musical_vibe_single_image' );
	?>
	<div class="entry-content-wrapper">
		<div class="entry-content">
			<?php the_content(); ?>
			<?php
				wp_link_pages( array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'musical-vibe' ),
					'after'  => '</div>',
				) );
			?>
		</div><!-- .entry-content -->
	</div><!-- .entry-content-wrapper -->

	<footer class="entry-footer">
		<?php edit_post_link( esc_html__( 'Edit', 'musical-vibe' ), '<span class="edit-link">', '</span>' ); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->

