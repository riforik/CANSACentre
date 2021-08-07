<?php
/**
 * Adds the header options sections, settings, and controls to the theme customizer
 *
 * @package Deneb
 */

class Deneb_Header_Options {
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
				'title' => esc_html__( 'Header Options', 'deneb' ),
				'panel' => 'deneb_theme_options'
			)
		);

		Deneb_Customizer_Utilities::register_option(
			array(
				'type'              => 'text',
				'settings'          => 'deneb_header_email',
				'sanitize_callback' => 'sanitize_email',
				'label'             => esc_html__( 'Email', 'deneb' ),
				'section'           => 'deneb_header_options',
			)
		);

		Deneb_Customizer_Utilities::register_option(
			array(
				'type'              => 'text',
				'settings'          => 'deneb_header_phone',
				'sanitize_callback' => 'deneb_text_sanitization',
				'label'             => esc_html__( 'Phone', 'deneb' ),
				'section'           => 'deneb_header_options',
			)
		);

		Deneb_Customizer_Utilities::register_option(
			array(
				'type'              => 'text',
				'settings'          => 'deneb_header_address',
				'sanitize_callback' => 'deneb_text_sanitization',
				'label'             => esc_html__( 'Address', 'deneb' ),
				'section'           => 'deneb_header_options',
			)
		);

		Deneb_Customizer_Utilities::register_option(
			array(
				'type'              => 'text',
				'settings'          => 'deneb_header_open_hours',
				'sanitize_callback' => 'deneb_text_sanitization',
				'label'             => esc_html__( 'Open Hours', 'deneb' ),
				'section'           => 'deneb_header_options',
			)
		);

		Deneb_Customizer_Utilities::register_option(
			array(
				'type'              => 'text',
				'settings'          => 'deneb_header_button_text',
				'sanitize_callback' => 'deneb_text_sanitization',
				'label'             => esc_html__( 'Button Text', 'deneb' ),
				'section'           => 'deneb_header_options',
			)
		);

		Deneb_Customizer_Utilities::register_option(
			array(
				'type'              => 'url',
				'settings'          => 'deneb_header_button_link',
				'sanitize_callback' => 'esc_url_raw',
				'label'             => esc_html__( 'Button Link', 'deneb' ),
				'section'           => 'deneb_header_options',
			)
		);

		Deneb_Customizer_Utilities::register_option(
			array(
				'custom_control'    => 'Deneb_Toggle_Switch_Custom_control',
				'settings'          => 'deneb_header_button_target',
				'sanitize_callback' => 'deneb_switch_sanitization',
				'label'             => esc_html__( 'Open link in new tab?', 'deneb' ),
				'section'           => 'deneb_header_options',
			)
		);
	}
}

/**
 * Initialize class
 */
$deneb_theme_options = new Deneb_Header_Options();
