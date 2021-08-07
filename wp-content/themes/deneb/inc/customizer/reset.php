<?php
/**
 * Reset Theme Options
 *
 * @package Deneb
 */

if ( ! class_exists( 'Deneb_Customizer_Reset' ) ) {
	/**
	 * Adds Reset button to customizer
	 */
	final class Deneb_Customizer_Reset {
		/**
		 * @var Deneb_Customizer_Reset
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

			wp_enqueue_script( 'deneb-customizer-reset', get_template_directory_uri() . '/js/customizer-reset' . $min . '.js', array( 'customize-preview' ), deneb_get_file_mod_date( '/js/customizer-reset' . $min . '.js' ), true );

			wp_localize_script( 'deneb-customizer-reset', '_denebCustomizerReset', array(
				'reset'        => esc_html__( 'Reset', 'deneb' ),
				'confirm'      => esc_html__( "Caution! This action is irreversible. Press OK to continue.", 'deneb' ),
				'nonce'        => array(
					'reset' => wp_create_nonce( 'deneb-customizer-reset' ),
				),
				'resetSection' => esc_html__( 'Reset Section', 'deneb' ),
				'confirmSection' => esc_html__( "Caution! This action is irreversible. Press OK to reset the section.", 'deneb' ),
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

			if ( ! check_ajax_referer( 'deneb-customizer-reset', 'nonce', false ) ) {
				wp_send_json_error( 'invalid_nonce' );
			}

			if ( isset( $_POST['section'] ) && 'reset-all' === $_POST['section'] ) {
				$this->reset_customizer();
			}

			if ( isset( $_POST['section'] ) && 'colors' === $_POST['section'] ) {
				$reset_options = Deneb_Basic_Colors_Options::get_colors();

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

Deneb_Customizer_Reset::get_instance();
