<?php
/**
 * Portfolio Options
 *
 * @package Deneb
 */

class Deneb_Portfolio_Options {
	public function __construct() {
		// Register Portfolio Options.
		add_action( 'customize_register', array( $this, 'register_options' ), 99 );

		// Add default options.
		add_filter( 'deneb_customizer_defaults', array( $this, 'add_defaults' ) );
	}

	/**
	 * Add options to defaults
	 */
	public function add_defaults( $default_options ) {
		$defaults = array(
			'deneb_portfolio_visibility' => 'disabled',
			'deneb_portfolio_number'     => 6,
		);

		$updated_defaults = wp_parse_args( $defaults, $default_options );

		return $updated_defaults;
	}

	/**
	 * Add layouts section and its controls
	 */
	public function register_options( $wp_customize ) {
		Deneb_Customizer_Utilities::register_option(
			array(
				'settings'          => 'deneb_portfolio_visibility',
				'type'              => 'select',
				'sanitize_callback' => 'deneb_sanitize_select',
				'label'             => esc_html__( 'Visible On', 'deneb' ),
				'section'           => 'deneb_ss_portfolio',
				'choices'           => Deneb_Customizer_Utilities::section_visibility(),
			)
		);

		// Add Edit Shortcut Icon.
		$wp_customize->selective_refresh->add_partial( 'deneb_portfolio_visibility', array(
			'selector' => '#portfolio-section',
		) );

		Deneb_Customizer_Utilities::register_option(
			array(
				'type'              => 'text',
				'sanitize_callback' => 'deneb_text_sanitization',
				'settings'          => 'deneb_portfolio_section_top_subtitle',
				'label'             => esc_html__( 'Section Top Sub-title', 'deneb' ),
				'section'           => 'deneb_ss_portfolio',
				'active_callback'   => array( $this, 'is_portfolio_visible' ),
			)
		);

		Deneb_Customizer_Utilities::register_option(
			array(
				'settings'          => 'deneb_portfolio_section_title',
				'type'              => 'text',
				'sanitize_callback' => 'deneb_text_sanitization',
				'label'             => esc_html__( 'Section Title', 'deneb' ),
				'section'           => 'deneb_ss_portfolio',
				'active_callback'   => array( $this, 'is_portfolio_visible' ),
			)
		);

		Deneb_Customizer_Utilities::register_option(
			array(
				'settings'          => 'deneb_portfolio_section_subtitle',
				'type'              => 'text',
				'sanitize_callback' => 'deneb_text_sanitization',
				'label'             => esc_html__( 'Section Subtitle', 'deneb' ),
				'section'           => 'deneb_ss_portfolio',
				'active_callback'   => array( $this, 'is_portfolio_visible' ),
			)
		);

		Deneb_Customizer_Utilities::register_option(
			array(
				'settings'          => 'deneb_portfolio_number',
				'type'              => 'number',
				'label'             => esc_html__( 'Number', 'deneb' ),
				'description'       => esc_html__( 'Please refresh the customizer page once the number is changed.', 'deneb' ),
				'section'           => 'deneb_ss_portfolio',
				'sanitize_callback' => 'absint',
				'input_attrs'       => array(
					'min'   => 1,
					'max'   => 80,
					'step'  => 1,
					'style' => 'width:100px;',
				),
				'active_callback'   => array( $this, 'is_portfolio_visible' ),
			)
		);

		$numbers = deneb_gtm( 'deneb_portfolio_number' );

		for( $i = 0, $j = 1; $i < $numbers; $i++, $j++ ) {
			Deneb_Customizer_Utilities::register_option(
				array(
					'custom_control'    => 'Deneb_Dropdown_Posts_Custom_Control',
					'sanitize_callback' => 'absint',
					'settings'          => 'deneb_portfolio_page_' . $i,
					'label'             => esc_html__( 'Select Page', 'deneb' ),
					'section'           => 'deneb_ss_portfolio',
					'active_callback'   => array( $this, 'is_portfolio_visible' ),
					'input_attrs' => array(
						'post_type'      => 'page',
						'posts_per_page' => -1,
						'orderby'        => 'name',
						'order'          => 'ASC',
					),
				)
			);
		}
	}

	/**
	 * Portfolio visibility active callback.
	 */
	public function is_portfolio_visible( $control ) {
		return ( deneb_display_section( $control->manager->get_setting( 'deneb_portfolio_visibility' )->value() ) );
	}
}

/**
 * Initialize class
 */
$deneb_ss_portfolio = new Deneb_Portfolio_Options();
