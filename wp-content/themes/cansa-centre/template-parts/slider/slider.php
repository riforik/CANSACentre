<?php
/**
 * Template part for displaying Slider
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Cansa-Centre
 */

$deneb_enable_slider = deneb_gtm( 'deneb_slider_visibility' );

if ( ! deneb_display_section( $deneb_enable_slider ) ) {
	return;
}

?>
<div id="slider-section" class="section zoom-disabled no-padding style-one">
	<div class="swiper-wrapper">
		<?php get_template_part( 'template-parts/slider/post', 'type' ); ?>
	</div><!-- .swiper-wrapper -->

	<div class="swiper-pagination"></div>

	<div class="swiper-button-prev"></div>
    <div class="swiper-button-next"></div>
</div><!-- .main-slider -->
