<?php
/**
 * CansaCentre Theme Customizer
 *
 * @package Cansa-Centre
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function deneb_sortable_sections( $wp_customize ) {
	$wp_customize->add_panel( 'deneb_sp_sortable', array(
		'title'       => esc_html__( 'Sections', 'cansa-centre' ),
		'priority'    => 150,
	) );

	$sortable_sections = array (
        'slider'               => esc_html__( 'Slider', 'cansa-centre' ),
        'wwd'                  => esc_html__( 'What We Do', 'cansa-centre' ),
        'hero_content'         => esc_html__( 'Hero Content', 'cansa-centre' ),
        'featured_product'     => esc_html__( 'Featured Product', 'cansa-centre' ),
        'portfolio'            => esc_html__( 'Portfolio', 'cansa-centre' ),
        'testimonial'          => esc_html__( 'Testimonials', 'cansa-centre' ),
        'featured_content'     => esc_html__( 'Featured Content', 'cansa-centre' ),
    );

	foreach ( $sortable_sections as $key => $value ) {
			// Add sections.
			$wp_customize->add_section( 'deneb_ss_' . $key,
				array(
					'title' => $value,
					'panel' => 'deneb_sp_sortable'
				)
			);
		
	}
}
add_action( 'customize_register', 'deneb_sortable_sections', 1 );
