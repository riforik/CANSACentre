<?php
/**
 * Template part for displaying Service
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Deneb
 */

$deneb_visibility = deneb_gtm( 'deneb_testimonial_visibility' );

if ( ! deneb_display_section( $deneb_visibility ) ) {
	return;
}

$image = deneb_gtm( 'deneb_testimonial_bg_image' );
?>
<div id="testimonial-section" class="carousel-enabled  testimonial-section section" <?php echo $image ? 'style="background-image: url( ' .esc_url( $image ) . ' )"' : ''; ?>>
	<div class="section-testimonial testimonial-layout-1">
		<div class="container">
			<?php deneb_section_title( 'testimonial' ); ?>

			<div class="next-prev-wrap">
		   		<div class="swiper-button-prev"></div>
			    <div class="swiper-button-next"></div>
			</div>

			<?php get_template_part( 'template-parts/testimonial/post-type' ); ?>
		</div><!-- .container -->
	</div><!-- .section-testimonial  -->
</div><!-- .section -->
