<?php
/**
 * Theme widgets.
 *
 * @package Musical_Vibe
 */

// Load widget base.
require_once get_template_directory() . '/lib/widget-base/class-widget-base.php';

if ( ! function_exists( 'musical_vibe_load_widgets' ) ) :

	/**
	 * Load widgets.
	 *
	 * @since 1.0.0
	 */
	function musical_vibe_load_widgets() {

		// Social widget.
		register_widget( 'Musical_Vibe_Social_Widget' );

		// Featured Page widget.
		register_widget( 'Musical_Vibe_Featured_Page_Widget' );

		// Latest News widget.
		register_widget( 'Musical_Vibe_Latest_News_Widget' );

		// Call To Action widget.
		register_widget( 'Musical_Vibe_Call_To_Action_Widget' );

		// Services widget.
		register_widget( 'Musical_Vibe_Services_Widget' );

		// Recent Posts widget.
		register_widget( 'Musical_Vibe_Recent_Posts_Widget' );
	}

endif;

add_action( 'widgets_init', 'musical_vibe_load_widgets' );

if ( ! class_exists( 'Musical_Vibe_Social_Widget' ) ) :

	/**
	 * Social widget Class.
	 *
	 * @since 1.0.0
	 */
	class Musical_Vibe_Social_Widget extends Musical_Vibe_Widget_Base {

		/**
		 * Sets up a new widget instance.
		 *
		 * @since 1.0.0
		 */
		function __construct() {

			$opts = array(
				'classname'                   => 'musical_vibe_widget_social',
				'description'                 => __( 'Displays social icons.', 'musical-vibe' ),
				'customize_selective_refresh' => true,
				);
			$fields = array(
				'title' => array(
					'label' => __( 'Title:', 'musical-vibe' ),
					'type'  => 'text',
					'class' => 'widefat',
					),
				'subtitle' => array(
					'label' => __( 'Subtitle:', 'musical-vibe' ),
					'type'  => 'text',
					'class' => 'widefat',
					),
				);

			if ( false === has_nav_menu( 'social' ) ) {
				$fields['message'] = array(
					'label' => __( 'Social menu is not set. Please create menu and assign it to Social Menu.', 'musical-vibe' ),
					'type'  => 'message',
					'class' => 'widefat',
					);
			}

			parent::__construct( 'musical-vibe-social', __( 'MV: Social', 'musical-vibe' ), $opts, array(), $fields );

		}

		/**
		 * Outputs the content for the current widget instance.
		 *
		 * @since 1.0.0
		 *
		 * @param array $args     Display arguments.
		 * @param array $instance Settings for the current widget instance.
		 */
		function widget( $args, $instance ) {

			$params = $this->get_params( $instance );

			echo $args['before_widget'];

			if ( ! empty( $params['title'] ) ) {
				echo $args['before_title'] . $params['title'] . $args['after_title'];
			}

			if ( ! empty( $params['subtitle'] ) ) {
				echo '<p class="widget-subtitle">' . esc_html( $params['subtitle'] ) . '</p>';
			}

			if ( has_nav_menu( 'social' ) ) {
				wp_nav_menu( array(
					'theme_location' => 'social',
					'container'      => false,
					'depth'          => 1,
					'link_before'    => '<span class="screen-reader-text">',
					'link_after'     => '</span>',
				) );
			}

			echo $args['after_widget'];

		}
	}
endif;

if ( ! class_exists( 'Musical_Vibe_Featured_Page_Widget' ) ) :

	/**
	 * Featured page widget Class.
	 *
	 * @since 1.0.0
	 */
	class Musical_Vibe_Featured_Page_Widget extends Musical_Vibe_Widget_Base {

		/**
		 * Sets up a new widget instance.
		 *
		 * @since 1.0.0
		 */
		function __construct() {

			$opts = array(
				'classname'                   => 'musical_vibe_widget_featured_page',
				'description'                 => __( 'Displays single featured Page or Post.', 'musical-vibe' ),
				'customize_selective_refresh' => true,
				);
			$fields = array(
				'title' => array(
					'label' => __( 'Title:', 'musical-vibe' ),
					'type'  => 'text',
					'class' => 'widefat',
					),
				'use_page_title' => array(
					'label'   => __( 'Use Page/Post Title as Widget Title', 'musical-vibe' ),
					'type'    => 'checkbox',
					'default' => true,
					),
				'subtitle' => array(
					'label' => __( 'Subtitle:', 'musical-vibe' ),
					'type'  => 'text',
					'class' => 'widefat',
					),
				'featured_page' => array(
					'label'            => __( 'Select Page:', 'musical-vibe' ),
					'type'             => 'dropdown-pages',
					'show_option_none' => __( '&mdash; Select &mdash;', 'musical-vibe' ),
					),
				'id_message' => array(
					'label'            => '<strong>' . _x( 'OR', 'Featured Page Widget', 'musical-vibe' ) . '</strong>',
					'type'             => 'message',
					),
				'featured_post' => array(
					'label'             => __( 'Post ID:', 'musical-vibe' ),
					'placeholder'       => __( 'Eg: 1234', 'musical-vibe' ),
					'type'              => 'text',
					'sanitize_callback' => 'musical_vibe_widget_sanitize_post_id',
					),
				'content_type' => array(
					'label'   => __( 'Show Content:', 'musical-vibe' ),
					'type'    => 'select',
					'default' => 'full',
					'options' => array(
						'excerpt' => __( 'Excerpt', 'musical-vibe' ),
						'full'    => __( 'Full', 'musical-vibe' ),
						),
					),
				'excerpt_length' => array(
					'label'       => __( 'Excerpt Length:', 'musical-vibe' ),
					'description' => __( 'Applies when Excerpt is selected in Content option.', 'musical-vibe' ),
					'type'        => 'number',
					'css'         => 'max-width:60px;',
					'default'     => 100,
					'min'         => 1,
					'max'         => 400,
					),
				'featured_image' => array(
					'label'   => __( 'Featured Image:', 'musical-vibe' ),
					'type'    => 'select',
					'options' => musical_vibe_get_image_sizes_options(),
					),
				'featured_image_alignment' => array(
					'label'   => __( 'Image Alignment:', 'musical-vibe' ),
					'type'    => 'select',
					'default' => 'center',
					'options' => musical_vibe_get_image_alignment_options(),
					),
				);

			parent::__construct( 'musical-vibe-featured-page', __( 'MV: Featured Page', 'musical-vibe' ), $opts, array(), $fields );

		}

		/**
		 * Outputs the content for the current widget instance.
		 *
		 * @since 1.0.0
		 *
		 * @param array $args     Display arguments.
		 * @param array $instance Settings for the current widget instance.
		 */
		function widget( $args, $instance ) {

			$params = $this->get_params( $instance );

			echo $args['before_widget'];

			$our_id = '';

			if ( absint( $params['featured_post'] ) > 0 ) {
				$our_id = absint( $params['featured_post'] );
			}

			if ( absint( $params['featured_page'] ) > 0 ) {
				$our_id = absint( $params['featured_page'] );
			}

			if ( absint( $our_id ) > 0 ) {
				$qargs = array(
					'p'             => absint( $our_id ),
					'post_type'     => 'any',
					'no_found_rows' => true,
					);

				$the_query = new WP_Query( $qargs );
				if ( $the_query->have_posts() ) {

					while ( $the_query->have_posts() ) {
						$the_query->the_post();

						echo '<div class="featured-page-widget image-align' . esc_attr( $params['featured_image_alignment'] ) . ' entry-content">';

						if ( 'disable' != $params['featured_image'] && has_post_thumbnail() ) {
							the_post_thumbnail( esc_attr( $params['featured_image'] ) );
						}

						echo '<div class="featured-page-content">';

						if ( true === $params['use_page_title'] ) {
							the_title( $args['before_title'], $args['after_title'] );
						} else {
							if ( $params['title'] ) {
								echo $args['before_title'] . $params['title'] . $args['after_title'];
							}
						}

						if ( ! empty( $params['subtitle'] ) ) {
							echo '<p class="widget-subtitle">' . esc_html( $params['subtitle'] ) . '</p>';
						}

						if ( 'excerpt' === $params['content_type'] && absint( $params['excerpt_length'] ) > 0 ) {
							$excerpt = musical_vibe_the_excerpt( absint( $params['excerpt_length'] ) );
							echo wp_kses_post( wpautop( $excerpt ) );
							echo '<a href="'  . esc_url( get_permalink() ) . '" class="custom-button">' . esc_html__( 'Know More', 'musical-vibe' ) . '</a>';
						} else {
							the_content();
						}

						echo '</div><!-- .featured-page-content -->';
						echo '</div><!-- .featured-page-widget -->';
					}

					wp_reset_postdata();
				}

			}

			echo $args['after_widget'];
		}
	}
endif;

if ( ! class_exists( 'Musical_Vibe_Latest_News_Widget' ) ) :

	/**
	 * Latest news widget Class.
	 *
	 * @since 1.0.0
	 */
	class Musical_Vibe_Latest_News_Widget extends Musical_Vibe_Widget_Base {

		/**
		 * Sets up a new widget instance.
		 *
		 * @since 1.0.0
		 */
		function __construct() {
			$opts = array(
				'classname'                   => 'musical_vibe_widget_latest_news',
				'description'                 => __( 'Displays latest posts in grid.', 'musical-vibe' ),
				'customize_selective_refresh' => true,
				);
			$fields = array(
				'title' => array(
					'label' => __( 'Title:', 'musical-vibe' ),
					'type'  => 'text',
					'class' => 'widefat',
					),
				'subtitle' => array(
					'label' => __( 'Subtitle:', 'musical-vibe' ),
					'type'  => 'text',
					'class' => 'widefat',
					),
				'post_category' => array(
					'label'           => __( 'Select Category:', 'musical-vibe' ),
					'type'            => 'dropdown-taxonomies',
					'show_option_all' => __( 'All Categories', 'musical-vibe' ),
					),
				'post_number' => array(
					'label'   => __( 'Number of Posts:', 'musical-vibe' ),
					'type'    => 'number',
					'default' => 3,
					'css'     => 'max-width:60px;',
					'min'     => 1,
					'max'     => 100,
					),
				'post_column' => array(
					'label'   => __( 'Number of Columns:', 'musical-vibe' ),
					'type'    => 'select',
					'default' => 3,
					'options' => musical_vibe_get_numbers_dropdown_options( 3, 4 ),
					),
				'featured_image' => array(
					'label'   => __( 'Featured Image:', 'musical-vibe' ),
					'type'    => 'select',
					'default' => 'musical-vibe-thumb',
					'options' => musical_vibe_get_image_sizes_options(),
					),
				'excerpt_length' => array(
					'label'       => __( 'Excerpt Length:', 'musical-vibe' ),
					'description' => __( 'in words', 'musical-vibe' ),
					'type'        => 'number',
					'css'         => 'max-width:60px;',
					'default'     => 15,
					'min'         => 1,
					'max'         => 400,
					'adjacent'    => true,
					),
				'more_text' => array(
					'label'   => __( 'More Text:', 'musical-vibe' ),
					'type'    => 'text',
					'default' => __( 'Know More', 'musical-vibe' ),
					),
				'disable_date' => array(
					'label'   => __( 'Disable Date', 'musical-vibe' ),
					'type'    => 'checkbox',
					'default' => false,
					),
				'disable_excerpt' => array(
					'label'   => __( 'Disable Excerpt', 'musical-vibe' ),
					'type'    => 'checkbox',
					'default' => false,
					),
				'disable_more_text' => array(
					'label'   => __( 'Disable More Text', 'musical-vibe' ),
					'type'    => 'checkbox',
					'default' => false,
					),
				);

			parent::__construct( 'musical-vibe-latest-news', __( 'MV: Latest News', 'musical-vibe' ), $opts, array(), $fields );
		}

		/**
		 * Outputs the content for the current widget instance.
		 *
		 * @since 1.0.0
		 *
		 * @param array $args     Display arguments.
		 * @param array $instance Settings for the current widget instance.
		 */
		function widget( $args, $instance ) {

			$params = $this->get_params( $instance );

			echo $args['before_widget'];

			if ( ! empty( $params['title'] ) ) {
				echo $args['before_title'] . $params['title'] . $args['after_title'];
			}

			if ( ! empty( $params['subtitle'] ) ) {
				echo '<p class="widget-subtitle">' . esc_html( $params['subtitle'] ) . '</p>';
			}

			$qargs = array(
				'posts_per_page' => esc_attr( $params['post_number'] ),
				'no_found_rows'  => true,
				);
			if ( absint( $params['post_category'] ) > 0 ) {
				$qargs['cat'] = absint( $params['post_category'] );
			}
			$all_posts = get_posts( $qargs );
			?>
			<?php if ( ! empty( $all_posts ) ) : ?>

				<?php global $post; ?>

				<div class="latest-news-widget latest-news-col-<?php echo esc_attr( $params['post_column'] ); ?>">

					<div class="inner-wrapper">

						<?php foreach ( $all_posts as $key => $post ) : ?>
							<?php setup_postdata( $post ); ?>

							<div class="latest-news-item">
							<div  class="latest-news-inner">
									<?php if ( 'disable' !== $params['featured_image'] && has_post_thumbnail() ) : ?>
										<div class="latest-news-thumb">

											<a href="<?php the_permalink(); ?>">
												<?php
												$img_attributes = array( 'class' => 'aligncenter' );
												the_post_thumbnail( esc_attr( $params['featured_image'] ), $img_attributes );
												?>
											</a>
										</div><!-- .latest-news-thumb -->
									<?php endif; ?>
									<div class="latest-news-text-wrap">

										<div class="latest-news-text-content">
											<?php $category = musical_vibe_get_single_post_category(); ?>
											<?php if ( false !== $params['disable_date'] || ! empty( $category ) ) : ?>
												<div class="latest-news-meta">
													<?php if ( false === $params['disable_date'] ) : ?>
														<span class="posted-on">
															<a href="<?php the_permalink(); ?>"><?php the_time( get_option( 'date_format' ) ); ?></a>
														</span>
													<?php endif; ?>
													<?php if ( ! empty( $category ) ) : ?>
														<span class="cat-links"><a href="<?php echo esc_url( $category['url'] ); ?>"><?php echo esc_html( $category['name'] ); ?></a></span>
													<?php endif; ?>
												</div><!-- .latest-news-meta -->
											<?php endif; ?>
											<h3 class="latest-news-title">
												<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
											</h3><!-- .latest-news-title -->


											<?php if ( false === $params['disable_excerpt'] ) : ?>
												<div class="latest-news-summary">
												<?php
												$summary = musical_vibe_the_excerpt( esc_attr( $params['excerpt_length'] ), $post );
												echo wp_kses_post( wpautop( $summary ) );
												?>
												</div><!-- .latest-news-summary -->
											<?php endif; ?>
										</div><!-- .latest-news-text-content -->

										<?php if ( false === $params['disable_more_text'] ) : ?>
											<a href="<?php the_permalink(); ?>" class="custom-button"><?php echo esc_html( $params['more_text'] ); ?><span class="screen-reader-text">"<?php the_title(); ?>"</span>
											</a>
										<?php endif; ?>

									</div><!-- .latest-news-text-wrap -->
								</div><!--  .latest-news-inner -->
							</div><!-- .latest-news-item -->

						<?php endforeach; ?>
					</div><!-- .row -->

				</div><!-- .latest-news-widget -->

				<?php wp_reset_postdata(); ?>

			<?php endif; ?>

			<?php echo $args['after_widget'];

		}
	}
endif;

if ( ! class_exists( 'Musical_Vibe_Call_To_Action_Widget' ) ) :

	/**
	 * Call to action widget Class.
	 *
	 * @since 1.0.0
	 */
	class Musical_Vibe_Call_To_Action_Widget extends Musical_Vibe_Widget_Base {

		/**
		 * Sets up a new widget instance.
		 *
		 * @since 1.0.0
		 */
		function __construct() {

			$opts = array(
				'classname'                   => 'musical_vibe_widget_call_to_action',
				'description'                 => __( 'Call To Action Widget.', 'musical-vibe' ),
				'customize_selective_refresh' => true,
				);
			$fields = array(
				'title' => array(
					'label' => __( 'Title:', 'musical-vibe' ),
					'type'  => 'text',
					'class' => 'widefat',
					),
				'description' => array(
					'label' => __( 'Description:', 'musical-vibe' ),
					'type'  => 'text',
					'class' => 'widefat',
					),
				'primary_button_text' => array(
					'label'   => __( 'Primary Button Text:', 'musical-vibe' ),
					'default' => __( 'Learn more', 'musical-vibe' ),
					'type'    => 'text',
					'class'   => 'widefat',
					),
				'primary_button_url' => array(
					'label' => __( 'Primary Button URL:', 'musical-vibe' ),
					'type'  => 'url',
					'class' => 'widefat',
					),
				'secondary_button_text' => array(
					'label'   => __( 'Secondary Button Text:', 'musical-vibe' ),
					'default' => '',
					'type'    => 'text',
					'class'   => 'widefat',
					),
				'secondary_button_url' => array(
					'label' => __( 'Secondary Button URL:', 'musical-vibe' ),
					'type'  => 'url',
					'class' => 'widefat',
					),
				'layout' => array(
					'label'   => esc_html__( 'Select Layout:', 'musical-vibe' ),
					'type'    => 'select',
					'default' => 1,
					'options' => musical_vibe_get_numbers_dropdown_options( 1, 2, esc_html__( 'Layout', 'musical-vibe' ) . ' ' ),
					),
				'background_image' => array(
					'label'   => __( 'Background Image:', 'musical-vibe' ),
					'type'    => 'image',
					'default' => '',
					),
				'background_image_message' => array(
					'label'   => __( 'Background Image applies to Layout 2 only.', 'musical-vibe' ),
					'type'    => 'message',
					),
				'enable_background_overlay' => array(
					'label'   => __( 'Enable Background Overlay', 'musical-vibe' ),
					'type'    => 'checkbox',
					'default' => true,
					),
				);

			parent::__construct( 'musical-vibe-call-to-action', __( 'MV: Call To Action', 'musical-vibe' ), $opts, array(), $fields );

		}

		/**
		 * Outputs the content for the current widget instance.
		 *
		 * @since 1.0.0
		 *
		 * @param array $args     Display arguments.
		 * @param array $instance Settings for the current widget instance.
		 */
		function widget( $args, $instance ) {

			$params = $this->get_params( $instance );

			// Add background image for layout 2.
			if ( 2 === absint( $params['layout'] ) && ! empty( $params['background_image'] ) ) {
				$background_style = '';
				$background_style .= ' style="background-image:url(' . esc_url( $params['background_image'] ) . ');" ';
				$args['before_widget'] = implode( $background_style . ' ' . 'class="', explode( 'class="', $args['before_widget'], 2 ) );
			}

			// Add overlay class.
			$overlay_class = ( true === $params['enable_background_overlay'] ) ? 'overlay-enabled' : 'overlay-disabled';
			$overlay_class .= ' cta-layout-' . absint( $params['layout'] ) . ' ';
			$args['before_widget'] = implode( 'class="' . $overlay_class . ' ', explode( 'class="', $args['before_widget'], 2 ) );

			echo $args['before_widget'];
			echo '<div class="call-to-action-main-wrap">';
			echo '<div class="call-to-action-content-wrap">';
			if ( ! empty( $params['title'] ) ) {
				echo $args['before_title'] . $params['title'] . $args['after_title'];
			}
			?>
			<div class="call-to-action-content">
				<?php if ( ! empty( $params['description'] ) ) : ?>
					<div class="call-to-action-description">
						<?php echo wp_kses_post( wpautop( $params['description'] ) ); ?>
					</div><!-- .call-to-action-description -->
				<?php endif; ?>
			</div><!-- .call-to-action-content -->
			<?php echo '</div>'; ?>
			<?php if ( ( ! empty( $params['primary_button_text'] ) && ! empty( $params['primary_button_url'] ) ) || ( ! empty( $params['secondary_button_text'] ) && ! empty( $params['secondary_button_url'] ) )  ) : ?>
				<div class="call-to-action-buttons">
					<?php if ( ! empty( $params['primary_button_url'] ) && ! empty( $params['primary_button_text'] ) ) : ?>
						<a href="<?php echo esc_url( $params['primary_button_url'] ); ?>" class="custom-button btn-call-to-action button-primary"><?php echo esc_html( $params['primary_button_text'] ); ?></a>
					<?php endif; ?>
					<?php if ( ! empty( $params['secondary_button_url'] ) && ! empty( $params['secondary_button_text'] ) ) : ?>
						<a href="<?php echo esc_url( $params['secondary_button_url'] ); ?>" class="custom-button btn-call-to-action button-secondary"><?php echo esc_html( $params['secondary_button_text'] ); ?></a>
					<?php endif; ?>
				</div><!-- .call-to-action-buttons -->
			<?php endif; ?>
			<?php echo '</div>'; ?>
			<?php

			echo $args['after_widget'];

		}
	}
endif;

if ( ! class_exists( 'Musical_Vibe_Services_Widget' ) ) :

	/**
	 * Services widget Class.
	 *
	 * @since 1.0.0
	 */
	class Musical_Vibe_Services_Widget extends Musical_Vibe_Widget_Base {

		/**
		 * Sets up a new widget instance.
		 *
		 * @since 1.0.0
		 */
		function __construct() {

			$opts = array(
				'classname'                   => 'musical_vibe_widget_services',
				'description'                 => __( 'Show your services with icon and read more link.', 'musical-vibe' ),
				'customize_selective_refresh' => true,
				);
			$fields = array(
				'title' => array(
					'label' => __( 'Title:', 'musical-vibe' ),
					'type'  => 'text',
					'class' => 'widefat',
					),
				'subtitle' => array(
					'label' => __( 'Subtitle:', 'musical-vibe' ),
					'type'  => 'text',
					'class' => 'widefat',
					),
				'excerpt_length' => array(
					'label'       => __( 'Excerpt Length:', 'musical-vibe' ),
					'description' => __( 'in words', 'musical-vibe' ),
					'type'        => 'number',
					'css'         => 'max-width:60px;',
					'default'     => 15,
					'min'         => 1,
					'max'         => 400,
					'adjacent'    => true,
					),
				'disable_excerpt' => array(
					'label'   => __( 'Disable Excerpt', 'musical-vibe' ),
					'type'    => 'checkbox',
					'default' => false,
					),
				'more_text' => array(
					'label'   => __( 'Read More Text:', 'musical-vibe' ),
					'type'    => 'text',
					'default' => __( 'Know More', 'musical-vibe' ),
					),
				'disable_more_text' => array(
					'label'   => __( 'Disable Read More', 'musical-vibe' ),
					'type'    => 'checkbox',
					'default' => false,
					),
				'enable_image' => array(
					'label'   => __( 'Show featured image instead of icon.', 'musical-vibe' ),
					'type'    => 'checkbox',
					'default' => false,
					),
				);

			for( $i = 1; $i <= 6; $i++ ) {
				$fields[ 'block_heading_' . $i ] = array(
					'label' => __( 'Block', 'musical-vibe' ) . ' #' . $i,
					'type'  => 'heading',
					'class' => 'widefat',
					);
				$fields[ 'block_page_' . $i ] = array(
					'label'            => __( 'Select Page:', 'musical-vibe' ),
					'type'             => 'dropdown-pages',
					'show_option_none' => __( '&mdash; Select &mdash;', 'musical-vibe' ),
					);
				$fields[ 'block_icon_' . $i ] = array(
					'label'       => __( 'Icon:', 'musical-vibe' ),
					'description' => __( 'Eg: fa-cogs', 'musical-vibe' ),
					'type'        => 'text',
					'default'     => 'fa-cogs',
					);
			}

			parent::__construct( 'musical-vibe-services', __( 'MV: Services', 'musical-vibe' ), $opts, array(), $fields );

		}

		/**
		 * Outputs the content for the current widget instance.
		 *
		 * @since 1.0.0
		 *
		 * @param array $args     Display arguments.
		 * @param array $instance Settings for the current widget instance.
		 */
		function widget( $args, $instance ) {

			$params = $this->get_params( $instance );

			echo $args['before_widget'];

			if ( ! empty( $params['title'] ) ) {
				echo $args['before_title'] . $params['title'] . $args['after_title'];
			}
			if ( ! empty( $params['subtitle'] ) ) {
				echo '<p class="widget-subtitle">' . esc_html( $params['subtitle'] ) . '</p>';
			}

			$service_arr = array();
			for ( $i = 0; $i < 6 ; $i++ ) {
				$block = ( $i + 1 );
				$service_arr[ $i ] = array(
					'page' => $params[ 'block_page_' . $block ],
					'icon' => $params[ 'block_icon_' . $block ],
					);
			}
			$refined_arr = array();
			if ( ! empty( $service_arr ) ) {
				foreach ( $service_arr as $item ) {
					if ( ! empty( $item['page'] ) ) {
						$refined_arr[ $item['page'] ] = $item;
					}
				}
			}

			if ( ! empty( $refined_arr ) ) {
				$this->render_widget_content( $refined_arr, $params );
			}

			echo $args['after_widget'];

		}

		/**
		 * Render services content.
		 *
		 * @since 1.0.0
		 *
		 * @param array $service_arr Services array.
		 * @param array $params      Parameters array.
		 */
		function render_widget_content( $service_arr, $params ) {

			$column = count( $service_arr );

			$page_ids = array_keys( $service_arr );

			$qargs = array(
				'posts_per_page' => count( $page_ids ),
				'post__in'       => $page_ids,
				'post_type'      => 'page',
				'orderby'        => 'post__in',
				'no_found_rows'  => true,
			);

			$all_posts = get_posts( $qargs );
			?>
			<?php if ( ! empty( $all_posts ) ) : ?>

				<?php global $post; ?>

				<div class="service-block-list service-col-<?php echo esc_attr( $column ); ?>">
					<div class="inner-wrapper">

						<?php foreach ( $all_posts as $post ) : ?>
							<?php setup_postdata( $post ); ?>
							<div class="service-block-item">
								<div class="service-block-inner">
									<?php if ( true === $params['enable_image'] ) : ?>

										<?php if ( has_post_thumbnail( $post->ID ) ) : ?>
											<a class="service-icon" href="<?php echo esc_url( get_permalink( $post->ID ) ); ?>"><?php the_post_thumbnail( 'thumbnail' ); ?></a>
										<?php endif; ?>

									<?php else : ?>

										<?php if ( isset( $service_arr[ $post->ID ]['icon'] ) && ! empty( $service_arr[ $post->ID ]['icon'] ) ) : ?>
											<a class="service-icon" href="<?php echo esc_url( get_permalink( $post->ID ) ); ?>"><i class="<?php echo 'fa ' . esc_attr( $service_arr[ $post->ID ]['icon'] ); ?>"></i></a>
										<?php endif; ?>

									<?php endif; ?>
									<div class="service-block-inner-content">
										<h3 class="service-item-title">
											<a href="<?php echo esc_url( get_permalink( $post->ID ) ); ?>">
												<?php echo get_the_title( $post->ID ); ?>
											</a>
										</h3>
										<?php if ( true !== $params['disable_excerpt'] ) :  ?>
											<div class="service-block-item-excerpt">
												<?php
												$excerpt = musical_vibe_the_excerpt( $params['excerpt_length'], $post );
												echo wp_kses_post( wpautop( $excerpt ) );
												?>
											</div><!-- .service-block-item-excerpt -->
										<?php endif; ?>

										<?php if ( true !== $params['disable_more_text'] ) :  ?>
											<a href="<?php echo esc_url( get_permalink( $post -> ID ) ); ?>" class="custom-button small-size"><?php echo esc_html( $params['more_text'] ); ?></a>
										<?php endif; ?>
									</div><!-- .service-block-inner-content -->
								</div><!-- .service-block-inner -->
							</div><!-- .service-block-item -->
						<?php endforeach; ?>

					</div><!-- .inner-wrapper -->

				</div><!-- .service-block-list -->

				<?php wp_reset_postdata(); ?>

			<?php endif; ?>

			<?php
		}

	}
endif;

if ( ! class_exists( 'Musical_Vibe_Recent_Posts_Widget' ) ) :

	/**
	 * Recent posts widget Class.
	 *
	 * @since 1.0.0
	 */
	class Musical_Vibe_Recent_Posts_Widget extends Musical_Vibe_Widget_Base {

		/**
		 * Sets up a new widget instance.
		 *
		 * @since 1.0.0
		 */
		function __construct() {

			$opts = array(
				'classname'                   => 'musical_vibe_widget_recent_posts',
				'description'                 => __( 'Displays recent posts.', 'musical-vibe' ),
				'customize_selective_refresh' => true,
				);
			$fields = array(
				'title' => array(
					'label' => __( 'Title:', 'musical-vibe' ),
					'type'  => 'text',
					'class' => 'widefat',
					),
				'subtitle' => array(
					'label' => __( 'Subtitle:', 'musical-vibe' ),
					'type'  => 'text',
					'class' => 'widefat',
					),
				'post_category' => array(
					'label'           => __( 'Select Category:', 'musical-vibe' ),
					'type'            => 'dropdown-taxonomies',
					'show_option_all' => __( 'All Categories', 'musical-vibe' ),
					),
				'post_number' => array(
					'label'   => __( 'Number of Posts:', 'musical-vibe' ),
					'type'    => 'number',
					'default' => 4,
					'css'     => 'max-width:60px;',
					'min'     => 1,
					'max'     => 100,
					),
				'featured_image' => array(
					'label'   => __( 'Featured Image:', 'musical-vibe' ),
					'type'    => 'select',
					'default' => 'thumbnail',
					'options' => musical_vibe_get_image_sizes_options( true, array( 'disable', 'thumbnail' ), false ),
					),
				'image_width' => array(
					'label'       => __( 'Image Width:', 'musical-vibe' ),
					'type'        => 'number',
					'description' => __( 'px', 'musical-vibe' ),
					'css'         => 'max-width:60px;',
					'adjacent'    => true,
					'default'     => 70,
					'min'         => 1,
					'max'         => 150,
					),
				'disable_date' => array(
					'label'   => __( 'Disable Date', 'musical-vibe' ),
					'type'    => 'checkbox',
					'default' => false,
					),
				);

			parent::__construct( 'musical-vibe-recent-posts', __( 'MV: Recent Posts', 'musical-vibe' ), $opts, array(), $fields );

		}

		/**
		 * Outputs the content for the current widget instance.
		 *
		 * @since 1.0.0
		 *
		 * @param array $args     Display arguments.
		 * @param array $instance Settings for the current widget instance.
		 */
		function widget( $args, $instance ) {

			$params = $this->get_params( $instance );

			echo $args['before_widget'];

			if ( ! empty( $params['title'] ) ) {
				echo $args['before_title'] . $params['title'] . $args['after_title'];
			}
			if ( ! empty( $params['subtitle'] ) ) {
				echo '<p class="widget-subtitle">' . esc_html( $params['subtitle'] ) . '</p>';
			}
			$qargs = array(
				'posts_per_page' => esc_attr( $params['post_number'] ),
				'no_found_rows'  => true,
				);
			if ( absint( $params['post_category'] ) > 0 ) {
				$qargs['cat'] = $params['post_category'];
			}
			$all_posts = get_posts( $qargs );

			?>
			<?php if ( ! empty( $all_posts ) ) :  ?>

				<?php global $post; ?>

				<div class="recent-posts-wrapper">

					<?php foreach ( $all_posts as $key => $post ) :  ?>
						<?php setup_postdata( $post ); ?>

						<div class="recent-posts-item">

							<?php if ( 'disable' !== $params['featured_image'] && has_post_thumbnail() ) :  ?>
								<div class="recent-posts-thumb">
									<a href="<?php the_permalink(); ?>">
										<?php
										$img_attributes = array(
											'class' => 'alignleft',
											'style' => 'max-width:' . esc_attr( $params['image_width'] ). 'px;',
											);
										the_post_thumbnail( esc_attr( $params['featured_image'] ), $img_attributes );
										?>
									</a>
								</div><!-- .recent-posts-thumb -->
							<?php endif ?>
							<div class="recent-posts-text-wrap">
								<h3 class="recent-posts-title">
									<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
								</h3><!-- .recent-posts-title -->

								<?php if ( false === $params['disable_date'] ) :  ?>
									<div class="recent-posts-meta">

										<?php if ( false === $params['disable_date'] ) :  ?>
											<span class="recent-posts-date"><?php the_time( get_option( 'date_format' ) ); ?></span><!-- .recent-posts-date -->
										<?php endif; ?>

									</div><!-- .recent-posts-meta -->
								<?php endif; ?>

							</div><!-- .recent-posts-text-wrap -->

						</div><!-- .recent-posts-item -->

					<?php endforeach; ?>

				</div><!-- .recent-posts-wrapper -->

				<?php wp_reset_postdata(); // Reset. ?>

			<?php endif; ?>

			<?php
			echo $args['after_widget'];

		}
	}
endif;
