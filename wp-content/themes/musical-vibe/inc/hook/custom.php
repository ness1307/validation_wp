<?php
/**
 * Custom theme functions.
 *
 * This file contains hook functions attached to theme hooks.
 *
 * @package Musical_Vibe
 */

if ( ! function_exists( 'musical_vibe_skip_to_content' ) ) :
	/**
	 * Add Skip to content.
	 *
	 * @since 1.0.0
	 */
	function musical_vibe_skip_to_content() {
		?><a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'musical-vibe' ); ?></a><?php
	}
endif;

add_action( 'musical_vibe_action_before', 'musical_vibe_skip_to_content', 15 );

if ( ! function_exists( 'musical_vibe_site_branding' ) ) :

	/**
	 * Site branding.
	 *
	 * @since 1.0.0
	 */
	function musical_vibe_site_branding() {
		?>
		<div class="site-branding">

			<?php musical_vibe_the_custom_logo(); ?>

			<?php $show_title = musical_vibe_get_option( 'show_title' ); ?>
			<?php $show_tagline = musical_vibe_get_option( 'show_tagline' ); ?>
			<?php if ( true === $show_title || true === $show_tagline ) : ?>
				<div id="site-identity">
					<?php if ( true === $show_title ) :  ?>
						<?php if ( is_front_page() && is_home() ) : ?>
							<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
						<?php else : ?>
							<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
						<?php endif; ?>
					<?php endif; ?>
					<?php if ( true === $show_tagline ) :  ?>
						<p class="site-description"><?php bloginfo( 'description' ); ?></p>
					<?php endif; ?>
				</div><!-- #site-identity -->
			<?php endif; ?>
	    </div><!-- .site-branding -->

    	<?php
		$buy_button_text = musical_vibe_get_option( 'buy_button_text' );
		$buy_button_url  = musical_vibe_get_option( 'buy_button_url' );
    	?>
    	<?php if ( ! empty( $buy_button_text ) && ! empty( $buy_button_url ) ) : ?>
	        <a href="<?php echo esc_url( $buy_button_url ); ?>" class="custom-button header-link-button"><?php echo esc_html( $buy_button_text ); ?></a>
    	<?php endif; ?>

	    <div id="main-nav">
	        <nav id="site-navigation" class="main-navigation" role="navigation">
	            <div class="wrap-menu-content">
					<?php
					wp_nav_menu(
						array(
						'theme_location' => 'primary',
						'menu_id'        => 'primary-menu',
						'fallback_cb'    => 'musical_vibe_primary_navigation_fallback',
						)
					);
					?>
	            </div><!-- .menu-content -->
	        </nav><!-- #site-navigation -->
	    </div> <!-- #main-nav -->
	    <?php
	}

endif;

add_action( 'musical_vibe_action_header', 'musical_vibe_site_branding' );

if ( ! function_exists( 'musical_vibe_mobile_navigation' ) ) :

	/**
	 * Mobile navigation.
	 *
	 * @since 1.0.0
	 */
	function musical_vibe_mobile_navigation() {
		?>
		<a id="mobile-trigger" href="#mob-menu"><i class="fa fa-bars"></i></a>
		<div id="mob-menu">
			<?php
			wp_nav_menu( array(
				'theme_location' => 'primary',
				'container'      => '',
				'fallback_cb'    => 'musical_vibe_primary_navigation_fallback',
				) );
			?>
		</div><!-- #mob-menu -->
		<?php
	}

endif;

add_action( 'musical_vibe_action_before', 'musical_vibe_mobile_navigation', 20 );

if ( ! function_exists( 'musical_vibe_header_top_content' ) ) :

	/**
	 * Header Top.
	 *
	 * @since 1.0.0
	 */
	function musical_vibe_header_top_content() {
		$contact_number        = musical_vibe_get_option( 'contact_number' );
		$contact_email         = musical_vibe_get_option( 'contact_email' );
		$contact_address       = musical_vibe_get_option( 'contact_address' );
		$show_social_in_header = musical_vibe_get_option( 'show_social_in_header' );
		$search_in_header      = musical_vibe_get_option( 'search_in_header' );
		$cart_in_header        = musical_vibe_get_option( 'cart_in_header' );

		if ( empty( $contact_number ) && empty( $contact_email ) && empty( $contact_address ) ) {
			$contact_status = false;
		} else {
			$contact_status = true;
		}

		if ( false === $contact_status && false === $search_in_header && ( false === $show_social_in_header || false === has_nav_menu( 'social' ) ) && ! ( true === $cart_in_header && musical_vibe_is_woocommerce_active() ) ) {
			return;
		}
		?>
		<div id="tophead">
			<div class="container">

				<div id="quick-contact">
					<ul>
						<?php if ( ! empty( $contact_number ) ) : ?>
							<li class="quick-call">
								<a href="<?php echo esc_url( 'tel:' . preg_replace( '/\D+/', '', $contact_number ) ); ?>"><?php echo esc_html( $contact_number ); ?></a>
							</li>
						<?php endif; ?>
						<?php if ( ! empty( $contact_email ) ) : ?>
							<li class="quick-email">
								<a href="<?php echo esc_url( 'mailto:' . $contact_email ); ?>"><?php echo esc_html( antispambot( $contact_email ) ); ?></a>
							</li>
						<?php endif; ?>
						<?php if ( ! empty( $contact_address ) ) : ?>
							<li class="quick-address">
								<?php echo esc_html( $contact_address ); ?>
							</li>
						<?php endif; ?>
					</ul>
				</div><!-- #quick-contact -->

				<?php if ( true === $show_social_in_header && has_nav_menu( 'social' ) ) : ?>
					<div class="header-social-wrapper">
						<?php the_widget( 'Musical_Vibe_Social_Widget' ); ?>
					</div><!-- .header-social-wrapper -->
				<?php endif; ?>

				<div id="top-head-right">
					<?php if ( true === $search_in_header ) : ?>
						<div class="header-search-box">
							<a href="#" class="search-icon"><i class="fa fa-search"></i></a>
							<div class="search-box-wrap">
								<?php get_search_form(); ?>
							</div><!-- .search-box-wrap -->
						</div><!-- .header-search-box -->
					<?php endif; ?>

					<?php if ( musical_vibe_is_woocommerce_active() && true === $cart_in_header ) : ?>
						<a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="cart-button"><i class="fa fa-cart-plus"></i><span><?php echo absint( WC()->cart->get_cart_contents_count() ); ?></span></a>
					<?php endif; ?>
				</div><!-- #top-head-right -->
			</div><!-- .container -->
		</div><!-- #tophead -->
		<?php
	}

endif;

add_action( 'musical_vibe_action_before_header', 'musical_vibe_header_top_content', 5 );

if ( ! function_exists( 'musical_vibe_footer_copyright' ) ) :

	/**
	 * Footer copyright.
	 *
	 * @since 1.0.0
	 */
	function musical_vibe_footer_copyright() {

		// Check if footer is disabled.
		$footer_status = apply_filters( 'musical_vibe_filter_footer_status', true );
		if ( true !== $footer_status ) {
			return;
		}

		// Footer Menu.
		$footer_menu_content = wp_nav_menu( array(
			'theme_location' => 'footer',
			'container'      => 'div',
			'container_id'   => 'footer-navigation',
			'depth'          => 1,
			'fallback_cb'    => false,
			'echo'           => false,
		) );

		// Copyright content.
		$copyright_text = musical_vibe_get_option( 'copyright_text' );
		$copyright_text = apply_filters( 'musical_vibe_filter_copyright_text', $copyright_text );
		if ( ! empty( $copyright_text ) ) {
			$copyright_text = wp_kses_data( $copyright_text );
		}

		// Powered by content.
		$powered_by_text = sprintf( esc_html__( 'Musical Vibe by %s', 'musical-vibe' ), '<a target="_blank" rel="designer" href="https://wenthemes.com/">' . esc_html__( 'WEN Themes', 'musical-vibe' ) . '</a>' );

		$show_social_in_footer = musical_vibe_get_option( 'show_social_in_footer' );

		$column_count = 0;

		if ( $footer_menu_content ) {
			$column_count++;
		}
		if ( $copyright_text ) {
			$column_count++;
		}
		if ( $powered_by_text ) {
			$column_count++;
		}
		if ( true === $show_social_in_footer && has_nav_menu( 'social' ) ) {
			$column_count++;
		}
		?>

		<div class="colophon-inner colophon-grid-<?php echo esc_attr( $column_count ); ?>">
			<div class="colophon-column-left">
			    <?php if ( ! empty( $copyright_text ) ) : ?>
				    <div class="colophon-column">
				    	<div class="copyright">
				    		<?php echo $copyright_text; ?>
				    	</div><!-- .copyright -->
				    </div><!-- .colophon-column -->
			    <?php endif; ?>

			    <?php if ( ! empty( $footer_menu_content ) ) : ?>
			    	<div class="colophon-column">
						<?php echo $footer_menu_content; ?>
			    	</div><!-- .colophon-column -->
			    <?php endif; ?>

		    </div> <!-- .colophon-column-left -->
			    <div class="colophon-column-right">

			    <?php if ( true === $show_social_in_footer && has_nav_menu( 'social' ) ) : ?>
				    <div class="colophon-column">
				    	<div class="footer-social">
				    		<?php the_widget( 'Musical_Vibe_Social_Widget' ); ?>
				    	</div><!-- .footer-social -->
				    </div><!-- .colophon-column -->
			    <?php endif; ?>

			    <?php if ( ! empty( $powered_by_text ) ) : ?>
				    <div class="colophon-column">
				    	<div class="site-info">
				    		<?php echo $powered_by_text; ?>
				    	</div><!-- .site-info -->
				    </div><!-- .colophon-column -->
			    <?php endif; ?>
			 </div> <!-- .colophon-column-right -->
		</div><!-- .colophon-inner -->

	    <?php
	}

endif;

add_action( 'musical_vibe_action_footer', 'musical_vibe_footer_copyright', 10 );

if ( ! function_exists( 'musical_vibe_add_sidebar' ) ) :

	/**
	 * Add sidebar.
	 *
	 * @since 1.0.0
	 */
	function musical_vibe_add_sidebar() {

		global $post;

		$global_layout = musical_vibe_get_option( 'global_layout' );
		$global_layout = apply_filters( 'musical_vibe_filter_theme_global_layout', $global_layout );

		// Check if single.
		if ( $post && is_singular() ) {
			$post_options = get_post_meta( $post->ID, 'musical_vibe_theme_settings', true );
			if ( isset( $post_options['post_layout'] ) && ! empty( $post_options['post_layout'] ) ) {
				$global_layout = $post_options['post_layout'];
			}
		}

		// Include primary sidebar.
		if ( 'no-sidebar' !== $global_layout ) {
			get_sidebar();
		}

		// Include secondary sidebar.
		switch ( $global_layout ) {
			case 'three-columns':
				get_sidebar( 'secondary' );
			break;

			default:
			break;
		}

	}

endif;

add_action( 'musical_vibe_action_sidebar', 'musical_vibe_add_sidebar' );

if ( ! function_exists( 'musical_vibe_custom_posts_navigation' ) ) :
	/**
	 * Posts navigation.
	 *
	 * @since 1.0.0
	 */
	function musical_vibe_custom_posts_navigation() {

		the_posts_pagination();

	}
endif;

add_action( 'musical_vibe_action_posts_navigation', 'musical_vibe_custom_posts_navigation' );


if ( ! function_exists( 'musical_vibe_add_image_in_single_display' ) ) :

	/**
	 * Add image in single post.
	 *
	 * @since 1.0.0
	 */
	function musical_vibe_add_image_in_single_display() {

		global $post;

		if ( has_post_thumbnail() ) {

			$values = get_post_meta( $post->ID, 'musical_vibe_theme_settings', true );
			$musical_vibe_theme_settings_single_image = isset( $values['single_image'] ) ? esc_attr( $values['single_image'] ) : '';

			if ( ! $musical_vibe_theme_settings_single_image ) {
				$musical_vibe_theme_settings_single_image = musical_vibe_get_option( 'single_image' );
			}

			if ( 'disable' !== $musical_vibe_theme_settings_single_image ) {
				$args = array(
					'class' => 'aligncenter',
				);
				the_post_thumbnail( esc_attr( $musical_vibe_theme_settings_single_image ), $args );
			}
		}

	}

endif;

add_action( 'musical_vibe_single_image', 'musical_vibe_add_image_in_single_display' );

if ( ! function_exists( 'musical_vibe_add_breadcrumb' ) ) :

	/**
	 * Add breadcrumb.
	 *
	 * @since 1.0.0
	 */
	function musical_vibe_add_breadcrumb() {

		// Bail if Breadcrumb disabled.
		$breadcrumb_type = musical_vibe_get_option( 'breadcrumb_type' );
		if ( 'disabled' === $breadcrumb_type ) {
			return;
		}

		// Bail if Home Page.
		if ( is_front_page() || is_home() ) {
			return;
		}

		echo '<div id="breadcrumb">';

		switch ( $breadcrumb_type ) {
			case 'simple':
				musical_vibe_simple_breadcrumb();
			break;

			default:
			break;
		}

		echo '</div><!-- #breadcrumb -->';

	}

endif;

add_action( 'musical_vibe_action_breadcrumb', 'musical_vibe_add_breadcrumb' );

if ( ! function_exists( 'musical_vibe_footer_goto_top' ) ) :

	/**
	 * Go to top.
	 *
	 * @since 1.0.0
	 */
	function musical_vibe_footer_goto_top() {

		$go_to_top = musical_vibe_get_option( 'go_to_top' );
		if ( true !== $go_to_top ) {
			return;
		}
		echo '<a href="#page" class="scrollup" id="btn-scrollup"><i class="fa fa-long-arrow-up" aria-hidden="true"></i>
</a>';

	}

endif;

add_action( 'musical_vibe_action_after', 'musical_vibe_footer_goto_top', 20 );

if ( ! function_exists( 'musical_vibe_add_front_page_widget_area' ) ) :

	/**
	 * Add Front Page Widget area.
	 *
	 * @since 1.0.0
	 */
	function musical_vibe_add_front_page_widget_area() {

		$current_id = musical_vibe_get_index_page_id();

		if ( is_front_page() && get_queried_object_id() === $current_id && $current_id > 0 ) {
			echo '<div id="sidebar-front-page-widget-area" class="widget-area">';
			if ( is_active_sidebar( 'sidebar-front-page-widget-area' ) ) {
				dynamic_sidebar( 'sidebar-front-page-widget-area' );
			}
			else {
				do_action( 'musical_vibe_action_default_front_page_widget_area' );
			}
			echo '</div><!-- #sidebar-front-page-widget-area -->';
		}

	}
endif;

add_action( 'musical_vibe_action_before_content', 'musical_vibe_add_front_page_widget_area', 7 );

if ( ! function_exists( 'musical_vibe_check_home_page_content' ) ) :

	/**
	 * Check home page content status.
	 *
	 * @since 1.0.0
	 *
	 * @param bool $status Home page content status.
	 * @return bool Modified home page content status.
	 */
	function musical_vibe_check_home_page_content( $status ) {

		if ( is_front_page() ) {
			$home_content_status = musical_vibe_get_option( 'home_content_status' );
			if ( false === $home_content_status ) {
				$status = false;
			}
		}

		return $status;

	}

endif;

add_action( 'musical_vibe_filter_home_page_content', 'musical_vibe_check_home_page_content' );

if ( ! function_exists( 'musical_vibe_add_custom_header' ) ) :

	/**
	 * Add Custom Header.
	 *
	 * @since 1.0.0
	 */
	function musical_vibe_add_custom_header() {

		$flag_apply_custom_header = apply_filters( 'musical_vibe_filter_custom_header_status', true );
		if ( true !== $flag_apply_custom_header ) {
			return;
		}
		$attribute = '';
		$attribute = apply_filters( 'musical_vibe_filter_custom_header_style_attribute', $attribute );
		?>
		<div id="custom-header" <?php echo ( ! empty( $attribute ) ) ? ' style="' . esc_attr( $attribute ) . '" ' : ''; ?>>
			<div class="container">
				<?php do_action( 'musical_vibe_action_breadcrumb' ); ?>
				<?php
					/**
					 * Hook - musical_vibe_action_custom_header.
					 */
					do_action( 'musical_vibe_action_custom_header' );
				?>
			</div><!-- .container -->
		</div><!-- #custom-header -->

		<?php

	}
endif;

add_action( 'musical_vibe_action_before_content', 'musical_vibe_add_custom_header', 6 );

if ( ! function_exists( 'musical_vibe_add_title_in_custom_header' ) ) :

	/**
	 * Add title in Custom Header.
	 *
	 * @since 1.0.0
	 */
	function musical_vibe_add_title_in_custom_header() {
		$tag = 'h1';
		if ( is_front_page() ) {
			$tag = 'h2';
		}
		$custom_page_title = apply_filters( 'musical_vibe_filter_custom_page_title', '' );
		?>
		<div class="header-content">
			<div class="header-content-inner">
				<?php if ( ! empty( $custom_page_title ) ) : ?>
					<?php echo '<' . $tag . ' class="page-title">'; ?>
					<?php echo esc_html( $custom_page_title ); ?>
					<?php echo '</' . $tag . '>'; ?>
				<?php endif; ?>
			</div><!-- .header-content-inner -->
		</div><!-- .header-content -->
		<?php
	}

endif;

add_action( 'musical_vibe_action_custom_header', 'musical_vibe_add_title_in_custom_header' );

if ( ! function_exists( 'musical_vibe_customize_page_title' ) ) :

	/**
	 * Add title in Custom Header.
	 *
	 * @since 1.0.0
	 *
	 * @param string $title Title.
	 * @return string Modified title.
	 */
	function musical_vibe_customize_page_title( $title ) {

		if ( is_front_page() && 'posts' === get_option( 'show_on_front' ) ) {
			$title = musical_vibe_get_option( 'blog_title' );
		}
		elseif ( is_home() && ( $blog_page_id = musical_vibe_get_index_page_id( 'blog' ) ) > 0 ) {
			$title = musical_vibe_get_option( 'blog_title' );
		}
		elseif ( is_singular() ) {
			$title = single_post_title( '', false );
		}
		elseif ( is_archive() ) {
			$title = strip_tags( get_the_archive_title() );
		}
		elseif ( is_search() ) {
			$title = sprintf( __( 'Search Results for: %s', 'musical-vibe' ),  get_search_query() );
		}
		elseif ( is_404() ) {
			$title = __( '404!', 'musical-vibe' );
		}
		return $title;
	}
endif;

add_filter( 'musical_vibe_filter_custom_page_title', 'musical_vibe_customize_page_title' );

if ( ! function_exists( 'musical_vibe_add_image_in_custom_header' ) ) :

	/**
	 * Add image in Custom Header.
	 *
	 * @since 1.0.0
	 */
	function musical_vibe_add_image_in_custom_header( $input ) {

		$image_details = array();

		if ( empty( $image_details ) ) {

			// Fetch from Custom Header Image.
			$image = get_header_image();
			if ( ! empty( $image ) ) {
				$image_details['url']    = $image;
				$image_details['width']  = get_custom_header()->width;
				$image_details['height'] = get_custom_header()->height;
			}
		}

		if ( ! empty( $image_details ) ) {
			$input .= 'background-image:url(' . esc_url( $image_details['url'] ) . ');';
			$input .= 'background-size:cover;';
		}

		return $input;

	}

endif;

add_filter( 'musical_vibe_filter_custom_header_style_attribute', 'musical_vibe_add_image_in_custom_header' );

if( ! function_exists( 'musical_vibe_check_custom_header_status' ) ) :

	/**
	 * Check status of custom header.
	 *
	 * @since 1.0.0
	 */
	function musical_vibe_check_custom_header_status( $input ) {

		if ( is_front_page() && ! is_home() ) {
			$input = false;
		}

		return $input;

	}

endif;

add_filter( 'musical_vibe_filter_custom_header_status', 'musical_vibe_check_custom_header_status' );
