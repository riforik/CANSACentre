<?php
/**
 * Template part for displaying Hero Content
 *
 * @package Cansa-Centre
 */

$deneb_enable = deneb_gtm( 'deneb_hero_content_visibility' );

if ( ! deneb_display_section( $deneb_enable ) ) {
	return;
}

get_template_part( 'template-parts/hero-content/content-hero' );
