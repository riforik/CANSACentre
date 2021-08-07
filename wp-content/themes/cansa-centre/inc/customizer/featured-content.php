<?php
/**
 * Featured Content Options
 *
 * @package Cansa-Centre
 */

class CansaCentre_Featured_Content_Options {
	public function __construct() {
		// Register Featured Content Options.
		add_action( 'customize_register', array( $this, 'register_options' ), 99 );

		// Add default options.
		add_filter( 'deneb_customizer_defaults', array( $this, 'add_defaults' ) );
	}

	/**
	 * Add options to defaults
	 */
	public function add_defaults( $default_options ) {
		$defaults = array(
			'deneb_featured_content_visibility'  => 'disabled',
			'deneb_featured_content_number'      => 3,
			'deneb_featured_content_button_link' => '#',
		);

		$updated_defaults = wp_parse_args( $defaults, $default_options );

		return $updated_defaults;
	}

	/**
	 * Add layouts section and its controls
	 */
	public function register_options( $wp_customize ) {

		CansaCentre_Customizer_Utilities::register_option(
			array(
				'settings'          => 'deneb_featured_content_visibility',
				'type'              => 'select',
				'sanitize_callback' => 'deneb_sanitize_select',
				'label'             => esc_html__( 'Visible On', 'cansa-centre' ),
				'section'           => 'deneb_ss_featured_content',
				'choices'           => CansaCentre_Customizer_Utilities::section_visibility(),
			)
		);

		// Add Edit Shortcut Icon.
		$wp_customize->selective_refresh->add_partial( 'deneb_featured_content_visibility', array(
			'selector' => '#featured-content-section',
		) );

		CansaCentre_Customizer_Utilities::register_option(
			array(
				'type'              => 'text',
				'sanitize_callback' => 'deneb_text_sanitization',
				'settings'          => 'deneb_featured_content_section_top_subtitle',
				'label'             => esc_html__( 'Section Top Sub-title', 'cansa-centre' ),
				'section'           => 'deneb_ss_featured_content',
				'active_callback'   => array( $this, 'is_featured_content_visible' ),
			)
		);

		CansaCentre_Customizer_Utilities::register_option(
			array(
				'settings'          => 'deneb_featured_content_section_title',
				'type'              => 'text',
				'sanitize_callback' => 'deneb_text_sanitization',
				'label'             => esc_html__( 'Section Title', 'cansa-centre' ),
				'section'           => 'deneb_ss_featured_content',
				'active_callback'   => array( $this, 'is_featured_content_visible' ),
			)
		);

		CansaCentre_Customizer_Utilities::register_option(
			array(
				'settings'          => 'deneb_featured_content_section_subtitle',
				'type'              => 'text',
				'sanitize_callback' => 'deneb_text_sanitization',
				'label'             => esc_html__( 'Section Subtitle', 'cansa-centre' ),
				'section'           => 'deneb_ss_featured_content',
				'active_callback'   => array( $this, 'is_featured_content_visible' ),
			)
		);

		CansaCentre_Customizer_Utilities::register_option(
			array(
				'settings'          => 'deneb_featured_content_number',
				'type'              => 'number',
				'label'             => esc_html__( 'Number', 'cansa-centre' ),
				'description'       => esc_html__( 'Please refresh the customizer page once the number is changed.', 'cansa-centre' ),
				'section'           => 'deneb_ss_featured_content',
				'sanitize_callback' => 'absint',
				'input_attrs'       => array(
					'min'   => 1,
					'max'   => 80,
					'step'  => 1,
					'style' => 'width:100px;',
				),
				'active_callback'   => array( $this, 'is_featured_content_visible' ),
			)
		);

		$numbers = deneb_gtm( 'deneb_featured_content_number' );

		for( $i = 0, $j = 1; $i < $numbers; $i++, $j++ ) {
			CansaCentre_Customizer_Utilities::register_option(
				array(
					'custom_control'    => 'CansaCentre_Dropdown_Posts_Custom_Control',
					'sanitize_callback' => 'absint',
					'settings'          => 'deneb_featured_content_page_' . $i,
					'label'             => esc_html__( 'Select Page', 'cansa-centre' ),
					'section'           => 'deneb_ss_featured_content',
					'active_callback'   => array( $this, 'is_featured_content_visible' ),
					'input_attrs' => array(
						'post_type'      => 'page',
						'posts_per_page' => -1,
						'orderby'        => 'name',
						'order'          => 'ASC',
					),
				)
			);
		}

		CansaCentre_Customizer_Utilities::register_option(
			array(
				'type'              => 'text',
				'sanitize_callback' => 'deneb_text_sanitization',
				'settings'          => 'deneb_featured_content_button_text',
				'label'             => esc_html__( 'Button Text', 'cansa-centre' ),
				'section'           => 'deneb_ss_featured_content',
				'active_callback'   => array( $this, 'is_featured_content_visible' ),
			)
		);

		CansaCentre_Customizer_Utilities::register_option(
			array(
				'type'              => 'url',
				'sanitize_callback' => 'esc_url_raw',
				'settings'          => 'deneb_featured_content_button_link',
				'label'             => esc_html__( 'Button Link', 'cansa-centre' ),
				'section'           => 'deneb_ss_featured_content',
				'active_callback'   => array( $this, 'is_featured_content_visible' ),
			)
		);

		CansaCentre_Customizer_Utilities::register_option(
			array(
				'custom_control'    => 'CansaCentre_Toggle_Switch_Custom_control',
				'settings'          => 'deneb_featured_content_button_target',
				'sanitize_callback' => 'deneb_switch_sanitization',
				'label'             => esc_html__( 'Open link in new tab?', 'cansa-centre' ),
				'section'           => 'deneb_ss_featured_content',
				'active_callback'   => array( $this, 'is_featured_content_visible' ),
			)
		);
	}

	/**
	 * Featured Content visibility active callback.
	 */
	public function is_featured_content_visible( $control ) {
		return ( deneb_display_section( $control->manager->get_setting( 'deneb_featured_content_visibility' )->value() ) );
	}
}

/**
 * Initialize class
 */
$deneb_ss_featured_content = new CansaCentre_Featured_Content_Options();
