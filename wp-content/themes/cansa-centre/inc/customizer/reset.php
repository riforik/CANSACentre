<?php
/**
 * Reset Theme Options
 *
 * @package Cansa-Centre
 */

if ( ! class_exists( 'CansaCentre_Customizer_Reset' ) ) {
	/**
	 * Adds Reset button to customizer
	 */
	final class CansaCentre_Customizer_Reset {
		/**
		 * @var CansaCentre_Customizer_Reset
		 */
		private static $instance = null;

		/**
		 * @var WP_Customize_Manager
		 */
		private $wp_customize;

		public static function get_instance() {
			if ( null === self::$instance ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		private function __construct() {
			add_action( 'customize_controls_print_scripts', array( $this, 'customize_controls_print_scripts' ) );
			add_action( 'wp_ajax_customizer_reset', array( $this, 'ajax_customizer_reset' ) );
			add_action( 'customize_register', array( $this, 'customize_register' ) );
		}

		public function customize_controls_print_scripts() {
			$min  = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

			wp_enqueue_script( 'cansa-centre-customizer-reset', get_template_directory_uri() . '/js/customizer-reset' . $min . '.js', array( 'customize-preview' ), deneb_get_file_mod_date( '/js/customizer-reset' . $min . '.js' ), true );

			wp_localize_script( 'cansa-centre-customizer-reset', '_denebCustomizerReset', array(
				'reset'        => esc_html__( 'Reset', 'cansa-centre' ),
				'confirm'      => esc_html__( "Caution! This action is irreversible. Press OK to continue.", 'cansa-centre' ),
				'nonce'        => array(
					'reset' => wp_create_nonce( 'cansa-centre-customizer-reset' ),
				),
				'resetSection' => esc_html__( 'Reset Section', 'cansa-centre' ),
				'confirmSection' => esc_html__( "Caution! This action is irreversible. Press OK to reset the section.", 'cansa-centre' ),
			) );
		}

		/**
		 * Store a reference to `WP_Customize_Manager` instance
		 *
		 * @param $wp_customize
		 */
		public function customize_register( $wp_customize ) {
			$this->wp_customize = $wp_customize;
		}

		public function ajax_customizer_reset() {
			if ( ! $this->wp_customize->is_preview() ) {
				wp_send_json_error( 'not_preview' );
			}

			if ( ! check_ajax_referer( 'cansa-centre-customizer-reset', 'nonce', false ) ) {
				wp_send_json_error( 'invalid_nonce' );
			}

			if ( isset( $_POST['section'] ) && 'reset-all' === $_POST['section'] ) {
				$this->reset_customizer();
			}

			if ( isset( $_POST['section'] ) && 'colors' === $_POST['section'] ) {
				$reset_options = CansaCentre_Basic_Colors_Options::get_colors();

				foreach( $reset_options as $key => $value ) {
					remove_theme_mod( $key );
				}
			}

			wp_send_json_success();
		}

		public function reset_customizer() {
			remove_theme_mods();
		}
	}
}

CansaCentre_Customizer_Reset::get_instance();
