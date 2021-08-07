<?php
/**
 * WWD Options
 *
 * @package Cansa-Centre
 */

class CansaCentre_WWD_Options {
	public function __construct() {
		// Register WWD Options.
		add_action( 'customize_register', array( $this, 'register_options' ), 99 );

		// Add default options.
		add_filter( 'deneb_customizer_defaults', array( $this, 'add_defaults' ) );
	}

	/**
	 * Add options to defaults
	 */
	public function add_defaults( $default_options ) {
		$defaults = array(
			'deneb_wwd_visibility'   => 'disabled',
			'deneb_wwd_number'       => 6,
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
				'settings'          => 'deneb_wwd_visibility',
				'type'              => 'select',
				'sanitize_callback' => 'deneb_sanitize_select',
				'label'             => esc_html__( 'Visible On', 'cansa-centre' ),
				'section'           => 'deneb_ss_wwd',
				'choices'           => CansaCentre_Customizer_Utilities::section_visibility(),
			)
		);

		// Add Edit Shortcut Icon.
		$wp_customize->selective_refresh->add_partial( 'deneb_wwd_visibility', array(
			'selector' => '#wwd-section',
		) );

		CansaCentre_Customizer_Utilities::register_option(
			array(
				'type'              => 'text',
				'sanitize_callback' => 'deneb_text_sanitization',
				'settings'          => 'deneb_wwd_section_top_subtitle',
				'label'             => esc_html__( 'Section Top Sub-title', 'cansa-centre' ),
				'section'           => 'deneb_ss_wwd',
				'active_callback'   => array( $this, 'is_wwd_visible' ),
			)
		);

		CansaCentre_Customizer_Utilities::register_option(
			array(
				'settings'          => 'deneb_wwd_section_title',
				'type'              => 'text',
				'sanitize_callback' => 'deneb_text_sanitization',
				'label'             => esc_html__( 'Section Title', 'cansa-centre' ),
				'section'           => 'deneb_ss_wwd',
				'active_callback'   => array( $this, 'is_wwd_visible' ),
			)
		);

		CansaCentre_Customizer_Utilities::register_option(
			array(
				'settings'          => 'deneb_wwd_section_subtitle',
				'type'              => 'text',
				'sanitize_callback' => 'deneb_text_sanitization',
				'label'             => esc_html__( 'Section Subtitle', 'cansa-centre' ),
				'section'           => 'deneb_ss_wwd',
				'active_callback'   => array( $this, 'is_wwd_visible' ),
			)
		);

		CansaCentre_Customizer_Utilities::register_option(
			array(
				'settings'          => 'deneb_wwd_number',
				'type'              => 'number',
				'label'             => esc_html__( 'Number', 'cansa-centre' ),
				'description'       => esc_html__( 'Please refresh the customizer page once the number is changed.', 'cansa-centre' ),
				'section'           => 'deneb_ss_wwd',
				'sanitize_callback' => 'absint',
				'input_attrs'       => array(
					'min'   => 1,
					'max'   => 80,
					'step'  => 1,
					'style' => 'width:100px;',
				),
				'active_callback'   => array( $this, 'is_wwd_visible' ),
			)
		);

		CansaCentre_Customizer_Utilities::register_option(
			array(
				'custom_control'    => 'CansaCentre_Simple_Notice_Custom_Control',
				'sanitize_callback' => 'sanitize_text_field',
				'settings'          => 'deneb_wwd_icon_note',
				'label'             =>  esc_html__( 'Info', 'cansa-centre' ),
				/* translators: 1: Link Start html, 2: Link end html. */
				'description'       =>  sprintf( esc_html__( 'If you want camera icon, save "fas fa-camera". For more classes, check %1$sthis%2$s', 'cansa-centre' ), '<a href="' . esc_url( 'https://fontawesome.com/icons?d=gallery&m=free' ) . '" target="_blank">', '</a>' ),
				'section'           => 'deneb_ss_wwd',
				'active_callback'   => array( $this, 'is_wwd_visible' ),
			)
		);

		$numbers = deneb_gtm( 'deneb_wwd_number' );

		for( $i = 0, $j = 1; $i < $numbers; $i++, $j++ ) {
			CansaCentre_Customizer_Utilities::register_option(
				array(
					'custom_control'    => 'CansaCentre_Simple_Notice_Custom_Control',
					'sanitize_callback' => 'deneb_text_sanitization',
					'settings'          => 'deneb_wwd_notice_' . $i,
					'label'             => esc_html__( 'Item #', 'cansa-centre' )  . $j,
					'section'           => 'deneb_ss_wwd',
					'active_callback'   => array( $this, 'is_wwd_visible' ),
				)
			);

			CansaCentre_Customizer_Utilities::register_option(
				array(
					'sanitize_callback' => 'sanitize_text_field',
					'settings'          => 'deneb_wwd_custom_icon_' . $i,
					'label'             => esc_html__( 'Icon Class', 'cansa-centre' ),
					'section'           => 'deneb_ss_wwd',
					'active_callback'   => array( $this, 'is_wwd_visible' ),
				)
			);

			CansaCentre_Customizer_Utilities::register_option(
				array(
					'custom_control'    => 'CansaCentre_Dropdown_Posts_Custom_Control',
					'sanitize_callback' => 'absint',
					'settings'          => 'deneb_wwd_page_' . $i,
					'label'             => esc_html__( 'Select Page', 'cansa-centre' ),
					'section'           => 'deneb_ss_wwd',
					'active_callback'   => array( $this, 'is_wwd_visible' ),
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
	 * WWD visibility active callback.
	 */
	public function is_wwd_visible( $control ) {
		return ( deneb_display_section( $control->manager->get_setting( 'deneb_wwd_visibility' )->value() ) );
	}
}

/**
 * Initialize class
 */
$deneb_ss_wwd = new CansaCentre_WWD_Options();
