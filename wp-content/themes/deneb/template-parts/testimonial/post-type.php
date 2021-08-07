<?php
/**
 * Template part for displaying Post Types Slider
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Deneb
 */

$deneb_args = deneb_get_section_args( 'testimonial' );
$deneb_loop = new WP_Query( $deneb_args );

if ( $deneb_loop->have_posts() ) :

	$deneb_carousel = deneb_gtm( 'deneb_testimonial_enable_slider' );
	?>
	<div class="testimonial-content-wrapper swiper-carousel-enabled">
		<div class="swiper-wrapper">
		<?php

		while ( $deneb_loop->have_posts() ) :
			$deneb_loop->the_post();
			?>
			<div class="testimonial-item swiper-slide">
              <div class="testimonial-wrapper clear-fix">
					<div class="testimonial-summary">
						<div class="clinet-info">
							<?php the_title( '<h3><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">','</a></h3>'); ?>
						</div>
						<!-- .clinet-info -->

						<?php deneb_display_content( 'testimonial' ); ?>
					</div>
				</div><!-- .testimonial-wrapper -->
				<?php if ( has_post_thumbnail() ) : ?>
					<div class="testimonial-thumb">
						<a href="<?php the_permalink(); ?>">
							<?php the_post_thumbnail( 'deneb-portfolio', array( 'class' => 'pull-left' ) ); ?>
						</a>
					</div>
					<?php endif; ?>
			</div><!-- .testimonial-item -->
		<?php
		endwhile;
		?>
		</div><!-- .swiper-wrapper -->

		<div class="swiper-pagination"></div>
	</div><!-- .testimonial-content-wrapper -->
<?php
endif;

wp_reset_postdata();
