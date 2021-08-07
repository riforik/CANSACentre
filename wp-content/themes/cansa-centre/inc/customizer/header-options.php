<?php
/**
 * Adds the header options sections, settings, and controls to the theme customizer
 *
 * @package Cansa-Centre
 */

class CansaCentre_Header_Options {
	public function __construct() {
		// Register Header Options.
		add_action( 'customize_register', array( $this, 'register_header_options' ) );
	}

	/**
	 * Add header options section and its controls
	 */
	public function register_header_options( $wp_customize ) {
		// Add header options section.
		$wp_customize->add_section( 'deneb_header_options',
			array(
				'title' => esc_html__( 'Header Options', 'cansa-centre' ),
				'panel' => 'deneb_theme_options'
			)
		);

		CansaCentre_Customizer_Utilities::register_option(
			array(
				'type'              => 'text',
				'settings'          => 'deneb_header_email',
				'sanitize_callback' => 'sanitize_email',
				'label'             => esc_html__( 'Email', 'cansa-centre' ),
				'section'           => 'deneb_header_options',
			)
		);

		CansaCentre_Customizer_Utilities::register_option(
			array(
				'type'              => 'text',
				'settings'          => 'deneb_header_phone',
				'sanitize_callback' => 'deneb_text_sanitization',
				'label'             => esc_html__( 'Phone', 'cansa-centre' ),
				'section'           => 'deneb_header_options',
			)
		);

		CansaCentre_Customizer_Utilities::register_option(
			array(
				'type'              => 'text',
				'settings'          => 'deneb_header_address',
				'sanitize_callback' => 'deneb_text_sanitization',
				'label'             => esc_html__( 'Address', 'cansa-centre' ),
				'section'           => 'deneb_header_options',
			)
		);

		CansaCentre_Customizer_Utilities::register_option(
			array(
				'type'              => 'text',
				'settings'          => 'deneb_header_open_hours',
				'sanitize_callback' => 'deneb_text_sanitization',
				'label'             => esc_html__( 'Open Hours', 'cansa-centre' ),
				'section'           => 'deneb_header_options',
			)
		);

		CansaCentre_Customizer_Utilities::register_option(
			array(
				'type'              => 'text',
				'settings'          => 'deneb_header_button_text',
				'sanitize_callback' => 'deneb_text_sanitization',
				'label'             => esc_html__( 'Button Text', 'cansa-centre' ),
				'section'           => 'deneb_header_options',
			)
		);

		CansaCentre_Customizer_Utilities::register_option(
			array(
				'type'              => 'url',
				'settings'          => 'deneb_header_button_link',
				'sanitize_callback' => 'esc_url_raw',
				'label'             => esc_html__( 'Button Link', 'cansa-centre' ),
				'section'           => 'deneb_header_options',
			)
		);

		CansaCentre_Customizer_Utilities::register_option(
			array(
				'custom_control'    => 'CansaCentre_Toggle_Switch_Custom_control',
				'settings'          => 'deneb_header_button_target',
				'sanitize_callback' => 'deneb_switch_sanitization',
				'label'             => esc_html__( 'Open link in new tab?', 'cansa-centre' ),
				'section'           => 'deneb_header_options',
			)
		);
	}
}

/**
 * Initialize class
 */
$deneb_theme_options = new CansaCentre_Header_Options();
