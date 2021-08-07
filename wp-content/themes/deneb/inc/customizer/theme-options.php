<?php
/**
 * Adds the theme options sections, settings, and controls to the theme customizer
 *
 * @package Deneb
 */

class Deneb_Theme_Options {
	public function __construct() {
		// Register our Panel.
		add_action( 'customize_register', array( $this, 'add_panel' ) );

		// Register Breadcrumb Options.
		add_action( 'customize_register', array( $this, 'register_breadcrumb_options' ) );

		// Register Excerpt Options.
		add_action( 'customize_register', array( $this, 'register_excerpt_options' ) );

		// Register Homepage Options.
		add_action( 'customize_register', array( $this, 'register_homepage_options' ) );

		// Register Layout Options.
		add_action( 'customize_register', array( $this, 'register_layout_options' ) );

		// Register Search Options.
		add_action( 'customize_register', array( $this, 'register_search_options' ) );

		// Add default options.
		add_filter( 'deneb_customizer_defaults', array( $this, 'add_defaults' ) );
	}

	/**
	 * Add options to defaults
	 */
	public function add_defaults( $default_options ) {
		$defaults = array(
			// Header Media.
			'deneb_header_image_visibility' => 'entire-site',

			// Breadcrumb
			'deneb_breadcrumb_show' => 1,

			// Layout Options.
			'deneb_layout_type'             => 'fluid',
			'deneb_default_layout'          => 'right-sidebar',
			'deneb_homepage_archive_layout' => 'no-sidebar-full-width',
			
			// Excerpt Options
			'deneb_excerpt_length'    => 30,
			'deneb_excerpt_more_text' => esc_html__( 'Continue reading', 'deneb' ),

			// Homepage/Frontpage Options.
			'deneb_front_page_category'   => '',
			
			// Search Options.
			'deneb_search_text'         => esc_html__( 'Search...', 'deneb' ),
		);


		$updated_defaults = wp_parse_args( $defaults, $default_options );

		return $updated_defaults;
	}

	/**
	 * Register the Customizer panels
	 */
	public function add_panel( $wp_customize ) {
		/**
		 * Add our Header & Navigation Panel
		 */
		 $wp_customize->add_panel( 'deneb_theme_options',
		 	array(
				'title' => esc_html__( 'Theme Options', 'deneb' ),
			)
		);
	}

	/**
	 * Add breadcrumb section and its controls
	 */
	public function register_breadcrumb_options( $wp_customize ) {
		// Add Excerpt Options section.
		$wp_customize->add_section( 'deneb_breadcrumb_options',
			array(
				'title' => esc_html__( 'Breadcrumb', 'deneb' ),
				'panel' => 'deneb_theme_options',
			)
		);

		if ( function_exists( 'bcn_display' ) ) {
			Deneb_Customizer_Utilities::register_option(
				array(
					'custom_control'    => 'Deneb_Simple_Notice_Custom_Control',
					'sanitize_callback' => 'sanitize_text_field',
					'settings'          => 'ff_multiputpose_breadcrumb_plugin_notice',
					'label'             =>  esc_html__( 'Info', 'deneb' ),
					'description'       =>  sprintf( esc_html__( 'Since Breadcrumb NavXT Plugin is installed, edit plugin\'s settings %1$shere%2$s', 'deneb' ), '<a href="' . esc_url( get_admin_url( null, 'options-general.php?page=breadcrumb-navxt' ) ) . '" target="_blank">', '</a>' ),
					'section'           => 'ff_multiputpose_breadcrumb_options',
				)
			);

			return;
		}

		Deneb_Customizer_Utilities::register_option(
			array(
				'custom_control'    => 'Deneb_Toggle_Switch_Custom_control',
				'settings'          => 'deneb_breadcrumb_show',
				'sanitize_callback' => 'deneb_switch_sanitization',
				'label'             => esc_html__( 'Display Breadcrumb?', 'deneb' ),
				'section'           => 'deneb_breadcrumb_options',
			)
		);
	}

	/**
	 * Add layouts section and its controls
	 */
	public function register_layout_options( $wp_customize ) {
		// Add layouts section.
		$wp_customize->add_section( 'deneb_layouts',
			array(
				'title' => esc_html__( 'Layouts', 'deneb' ),
				'panel' => 'deneb_theme_options'
			)
		);

		Deneb_Customizer_Utilities::register_option(
			array(
				'type'              => 'select',
				'settings'          => 'deneb_layout_type',
				'sanitize_callback' => 'deneb_sanitize_select',
				'label'             => esc_html__( 'Site Layout', 'deneb' ),
				'section'           => 'deneb_layouts',
				'choices'           => array(
					'fluid' => esc_html__( 'Fluid', 'deneb' ),
					'boxed' => esc_html__( 'Boxed', 'deneb' ),
				),
			)
		);

		Deneb_Customizer_Utilities::register_option(
			array(
				'type'              => 'select',
				'settings'          => 'deneb_default_layout',
				'sanitize_callback' => 'deneb_sanitize_select',
				'label'             => esc_html__( 'Default Layout', 'deneb' ),
				'section'           => 'deneb_layouts',
				'choices'           => array(
					'right-sidebar'         => esc_html__( 'Right Sidebar', 'deneb' ),
					'no-sidebar-full-width' => esc_html__( 'No Sidebar: Full Width', 'deneb' ),
				),
			)
		);

		Deneb_Customizer_Utilities::register_option(
			array(
				'type'              => 'select',
				'settings'          => 'deneb_homepage_archive_layout',
				'sanitize_callback' => 'deneb_sanitize_select',
				'label'             => esc_html__( 'Homepage/Archive Layout', 'deneb' ),
				'section'           => 'deneb_layouts',
				'choices'           => array(
					'right-sidebar'         => esc_html__( 'Right Sidebar', 'deneb' ),
					'no-sidebar-full-width' => esc_html__( 'No Sidebar: Full Width', 'deneb' ),
				),
			)
		);
	}

	/**
	 * Add excerpt section and its controls
	 */
	public function register_excerpt_options( $wp_customize ) {
		// Add Excerpt Options section.
		$wp_customize->add_section( 'deneb_excerpt_options',
			array(
				'title' => esc_html__( 'Excerpt Options', 'deneb' ),
				'panel' => 'deneb_theme_options',
			)
		);

		Deneb_Customizer_Utilities::register_option(
			array(
				'type'              => 'number',
				'settings'          => 'deneb_excerpt_length',
				'sanitize_callback' => 'absint',
				'label'             => esc_html__( 'Excerpt Length (Words)', 'deneb' ),
				'section'           => 'deneb_excerpt_options',
			)
		);

		Deneb_Customizer_Utilities::register_option(
			array(
				'type'              => 'text',
				'settings'          => 'deneb_excerpt_more_text',
				'sanitize_callback' => 'sanitize_text_field',
				'label'             => esc_html__( 'Excerpt More Text', 'deneb' ),
				'section'           => 'deneb_excerpt_options',
			)
		);
	}

	/**
	 * Add Homepage/Frontpage section and its controls
	 */
	public function register_homepage_options( $wp_customize ) {
		Deneb_Customizer_Utilities::register_option(
			array(
				'custom_control'    => 'Deneb_Dropdown_Select2_Custom_Control',
				'sanitize_callback' => 'deneb_text_sanitization',
				'settings'          => 'deneb_front_page_category',
				'description'       => esc_html__( 'Filter Homepage/Blog page posts by following categories', 'deneb' ),
				'label'             => esc_html__( 'Categories', 'deneb' ),
				'section'           => 'static_front_page',
				'input_attrs'       => array(
					'multiselect' => true,
				),
				'choices'           => array( esc_html__( '--Select--', 'deneb' ) => Deneb_Customizer_Utilities::get_terms( 'category' ) ),
			)
		);
	}

	/**
	 * Add Homepage/Frontpage section and its controls
	 */
	public function register_search_options( $wp_customize ) {
		// Add Homepage/Frontpage Section.
		$wp_customize->add_section( 'deneb_search',
			array(
				'title' => esc_html__( 'Search', 'deneb' ),
				'panel' => 'deneb_theme_options',
			)
		);

		Deneb_Customizer_Utilities::register_option(
			array(
				'settings'          => 'deneb_search_text',
				'sanitize_callback' => 'deneb_text_sanitization',
				'label'             => esc_html__( 'Search Text', 'deneb' ),
				'section'           => 'deneb_search',
				'type'              => 'text',
			)
		);
	}
}

/**
 * Initialize class
 */
$deneb_theme_options = new Deneb_Theme_Options();
