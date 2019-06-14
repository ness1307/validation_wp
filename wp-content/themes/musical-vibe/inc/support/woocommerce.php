<?php
/**
 * WooCommerce support class.
 *
 * @package Musical_Vibe
 */

/**
 * Woocommerce support class.
 *
 * @since 1.0.0
 */
class Musical_Vibe_Woocommerce {

	/**
	 * Construcor.
	 *
	 * @since 1.0.0
	 */
	function __construct() {

		$this->setup();
		$this->init();

	}

	/**
	 * Initial setup.
	 *
	 * @since 1.0.0
	 */
	function setup() {
	}

	/**
	 * Initialize hooks.
	 *
	 * @since 1.0.0
	 */
	function init() {

		// Register widgets.
		add_action( 'widgets_init', array( $this, 'register_woo_sidebars' ) );

		// Wrapper.
		remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
		remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
		add_action( 'woocommerce_before_main_content', array( $this, 'woo_wrapper_start' ), 10 );
		add_action( 'woocommerce_after_main_content', array( $this, 'woo_wrapper_end' ), 10 );

		// Breadcrumb.
		add_filter( 'woocommerce_breadcrumb_defaults', array( $this, 'custom_woocommerce_breadcrumbs_defaults' ) );
		add_action( 'wp', array( $this, 'hooking_woo' ) );

		// Sidebar.
		add_action( 'woocommerce_sidebar', array( $this, 'add_secondary_sidebar' ), 11 );

		// Sidebar filter.
		add_filter( 'musical_vibe_filter_default_sidebar_id', array( $this, 'sidebar_defaults' ), 10, 2 );

		// Customizer options.
		add_action( 'customize_register', array( $this, 'customizer_fields' ) );

		// Add default options.
		add_filter( 'musical_vibe_filter_default_theme_options', array( $this, 'default_options' ) );

		// Modify global layout.
		add_filter( 'musical_vibe_filter_theme_global_layout', array( $this, 'modify_global_layout' ), 15 );

	}

	/**
	 * Default options.
	 * @param  array $input Passed default options.
	 * @return array Modified default options.
	 */
	function default_options( $input ) {

		$input['woo_page_layout']       = 'right-sidebar';
		$input['woo_sidebar_primary']   = '';
		$input['woo_sidebar_secondary'] = '';
		return $input;

	}

	/**
	 * Hooking Woocommerce.
	 *
	 * @since 1.0.0
	 */
	function hooking_woo() {

		// Fix page title.
		add_filter( 'woocommerce_show_page_title' , '__return_false' );

		add_filter( 'musical_vibe_filter_custom_page_title', array( $this, 'custom_shop_title' ), 11 );

		// Fix single product title.
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );

		// Remove default breadcrumb.
		remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );

		if ( 'disabled' !== musical_vibe_get_option( 'breadcrumb_type' ) && is_woocommerce() ) {
			add_action( 'musical_vibe_action_breadcrumb', 'woocommerce_breadcrumb' );
			remove_action( 'musical_vibe_action_breadcrumb', 'musical_vibe_add_breadcrumb' );
		}

		// Fixing primary sidebar.
		$global_layout = musical_vibe_get_option( 'global_layout' );
		$global_layout = apply_filters( 'musical_vibe_filter_theme_global_layout', $global_layout );
		if ( in_array( $global_layout, array( 'no-sidebar' ) ) ) {
			remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
		}

	}

	/**
	 * Modify global layout.
	 *
	 * @since 1.0.0
	 */
	function modify_global_layout( $layout ) {

		$woo_page_layout = musical_vibe_get_option( 'woo_page_layout' );

		if ( is_woocommerce() && ! empty( $woo_page_layout ) ) {
			$layout = esc_attr( $woo_page_layout );
		}

		return $layout;

	}

	/**
	 * Add extra customizer options for WooCommerce.
	 *
	 * @since 1.0.0
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 */
	function customizer_fields( $wp_customize ) {

		$default = musical_vibe_get_default_theme_options();

		// WooCommerce Section.
		$wp_customize->add_section( 'section_theme_woocommerce',
			array(
				'title'       => esc_html__( 'WooCommerce Options', 'musical-vibe' ),
				'description' => esc_html__( 'Settings specific to WooCommerce. Note: WooCommerce Page means shop page, product page and product archive page.', 'musical-vibe' ),
				'priority'    => 100,
				'capability'  => 'edit_theme_options',
				'panel'       => 'theme_option_panel',
			)
		);
		// Setting - woo_page_layout.
		$wp_customize->add_setting( 'theme_options[woo_page_layout]',
			array(
				'default'           => $default['woo_page_layout'],
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => 'musical_vibe_sanitize_select',
			)
		);
		$wp_customize->add_control( 'theme_options[woo_page_layout]',
			array(
				'label'   => esc_html__( 'Content Layout', 'musical-vibe' ),
				'section' => 'section_theme_woocommerce',
				'type'    => 'select',
				'choices' => musical_vibe_get_global_layout_options(),
			)
		);
		// Setting - woo_sidebar_primary.
		$wp_customize->add_setting( 'theme_options[woo_sidebar_primary]',
			array(
				'default'           => $default['woo_sidebar_primary'],
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => 'sanitize_key',
			)
		);
		$wp_customize->add_control(
			new Musical_Vibe_Dropdown_Sidebars_Control( $wp_customize, 'theme_options[woo_sidebar_primary]',
				array(
					'label'       => esc_html__( 'Primary Sidebar', 'musical-vibe' ),
					'description' => esc_html__( 'Choose Primary Sidebar for WooCommerce pages. If not selected default sidebar will be displayed.', 'musical-vibe' ),
					'section'  => 'section_theme_woocommerce',
					'settings' => 'theme_options[woo_sidebar_primary]',
				)
			)
		);
		// Setting - woo_sidebar_secondary.
		$wp_customize->add_setting( 'theme_options[woo_sidebar_secondary]',
			array(
				'default'           => $default['woo_sidebar_secondary'],
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => 'sanitize_key',
			)
		);
		$wp_customize->add_control(
			new Musical_Vibe_Dropdown_Sidebars_Control( $wp_customize, 'theme_options[woo_sidebar_secondary]',
				array(
					'label'       => esc_html__( 'Secondary Sidebar', 'musical-vibe' ),
					'description' => esc_html__( 'Choose Secondary Sidebar for WooCommerce pages. If not selected default sidebar will be displayed.', 'musical-vibe' ),
					'section'  => 'section_theme_woocommerce',
					'settings' => 'theme_options[woo_sidebar_secondary]',
				)
			)
		);

	}

	/**
	 * Register Woocommerce sidebars.
	 *
	 * @since 1.0.0
	 */
	function register_woo_sidebars() {

		register_sidebar( array(
			'name'          => __( 'WooCommerce Primary', 'musical-vibe' ),
			'id'            => 'sidebar-woocommerce-primary',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		) );
		register_sidebar( array(
			'name'          => __( 'WooCommerce Secondary', 'musical-vibe' ),
			'id'            => 'sidebar-woocommerce-secondary',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		) );

	}

	/**
	 * Add secondary sidebar in Woocommerce.
	 *
	 * @since 1.0.0
	 */
	function add_secondary_sidebar() {

		$global_layout = musical_vibe_get_option( 'global_layout' );
		$global_layout = apply_filters( 'musical_vibe_filter_theme_global_layout', $global_layout );

		switch ( $global_layout ) {
			case 'three-columns':
				get_sidebar( 'secondary' );
			break;

			default:
			break;
		}

	}

	/**
	 * Woocommerce content wrapper start.
	 *
	 * @since 1.0.0
	 */
	function woo_wrapper_start() {
		echo '<div id="primary">';
		echo '<main role="main" class="site-main" id="main">';
	}

	/**
	 * Woocommerce content wrapper end.
	 *
	 * @since 1.0.0
	 */
	function woo_wrapper_end() {
		echo '</main><!-- #main -->';
		echo '</div><!-- #primary -->';
	}

	/**
	 * Woocommerce breadcrumb defaults.
	 *
	 * @since 1.0.0
	 *
	 * @param array $defaults Breadcrumb defaults.
	 * @return array Modified breadcrumb defaults.
	 */
	function custom_woocommerce_breadcrumbs_defaults( $defaults ) {

		$defaults['delimiter']   = '';
		$defaults['wrap_before'] = '<div id="breadcrumb" itemprop="breadcrumb"><div class="container"><ul id="crumbs">';
		$defaults['wrap_after']  = '</ul></div></div>';
		$defaults['before']      = '<li>';
		$defaults['after']       = '</li>';
		$defaults['home']        = get_bloginfo( 'name', 'display' );

		return $defaults;
	}

	/**
	 * Modify shop title.
	 *
	 * @param  string $title Title.
	 * @return string Modified title.
	 */
	function custom_shop_title( $title ) {

		if ( is_shop() ) {
			$shop_page_id = get_option( 'woocommerce_shop_page_id' );
			if ( absint( $shop_page_id ) > 0 ) {
				$title = get_the_title( absint( $shop_page_id ) );
			}
		}

		return $title;
	}
	/**
	 * Modify woo sidebar id defaults.
	 *
	 * @param  string $id       Sidebar ID.
	 * @param  string $location Sidebar position.
	 * @return string           Modified default sidebar id.
	 */
	function sidebar_defaults( $id, $location ) {
		if ( ! is_woocommerce() ) {
			return $id;
		}
		switch ( $location ) {
			case 'primary':
				$woo_sidebar_primary = musical_vibe_get_option( 'woo_sidebar_primary' );
				if ( ! empty( $woo_sidebar_primary ) ) {
					$id = esc_attr( $woo_sidebar_primary );
				}
			break;
			case 'secondary':
				$woo_sidebar_secondary = musical_vibe_get_option( 'woo_sidebar_secondary' );
				if ( ! empty( $woo_sidebar_secondary ) ) {
					$id = esc_attr( $woo_sidebar_secondary );
				}
			break;

			default:
			break;
		}
		return $id;

	}
} // End class.


// Initialize.
$musical_vibe_woocommerce = new Musical_Vibe_Woocommerce();
