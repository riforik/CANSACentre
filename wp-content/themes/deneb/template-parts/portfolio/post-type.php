<?php
/**
 * Template part for displaying Post Types Slider
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Deneb
 */

$portfolio_args = deneb_get_section_args( 'portfolio' );

$deneb_loop = new WP_Query( $portfolio_args );

if ( $deneb_loop->have_posts() ) :
	?>
	<div class="portfolio-main-wrapper">
		<div>
		<?php

		while ( $deneb_loop->have_posts() ) :
			$deneb_loop->the_post();
			?>
			<div class="portfolio-item ff-grid-4">
				<div class="item-inner-wrapper">
					<?php if ( has_post_thumbnail() ) : ?>
					<div class="portfolio-thumb-wrap image-hover-zoom">
						<?php the_post_thumbnail( 'deneb-portfolio', array( 'class' => 'deneb-portfolio' ) ); ?>
					</div>
					<?php endif; ?>

					<div class="portfolio-content">

							<?php the_title( '<h3><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">','</a></h3>'); ?>

					</div><!-- .portfolio-content -->
				</div><!-- .item-inner-wrapper -->
			</div><!-- .portfolio-item -->
		<?php
		endwhile;
		?>
		</div><!-- .swiper-wrapper -->
	</div><!-- .portfolio-main-wrapper -->
<?php
endif;

wp_reset_postdata();
