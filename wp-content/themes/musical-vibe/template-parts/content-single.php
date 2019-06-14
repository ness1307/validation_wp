<?php
/**
 * Template part for displaying single posts.
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
	   * @hooked musical_vibe_add_image_in_single_display - 10
	   */
	  do_action( 'musical_vibe_single_image' );
	?>


	<div class="entry-content-wrapper">
		<?php if ( 'post' === get_post_type() ) : ?>
			<div class="entry-meta">
				<?php musical_vibe_posted_on(); ?>
			</div><!-- .entry-meta -->
		<?php endif; ?>
		<div class="entry-content">
			<?php the_content(); ?>
			<?php
				wp_link_pages( array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'musical-vibe' ),
					'after'  => '</div>',
				) );
			?>
		</div><!-- .entry-content -->
		<footer class="entry-footer">
			<?php musical_vibe_entry_footer(); ?>
		</footer><!-- .entry-footer -->
	</div><!-- .entry-content-wrapper -->

</article><!-- #post-## -->
