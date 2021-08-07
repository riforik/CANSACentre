<?php
/**
 * Template part for displaying Post Types Slider
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Deneb
 */

$deneb_wwd_args = deneb_get_section_args( 'wwd' );

$deneb_loop = new WP_Query( $deneb_wwd_args );

if ( $deneb_loop->have_posts() ) :
	?>
	<div class="wwd-block-list">
		<div class="row">
		<?php

		while ( $deneb_loop->have_posts() ) :
			$deneb_loop->the_post();
			
			$count = absint( $deneb_loop->current_post );
			
			$icon  = deneb_gtm( 'deneb_wwd_custom_icon_' . $count );
			?>
			<div class="wwd-block-item<?php echo ( has_post_thumbnail() ) ? ' featured-image-enabled' : ''; ?> post-type ff-grid-4">
				<?php if ( has_post_thumbnail() ) : ?>
					<div class="wwd-post-thumb">
						<a class="post-thumbnail image-hover-zoom" href="<?php the_permalink(); ?>" >
							<?php the_post_thumbnail(); ?>
						</a>
					</div><!--.wwd-post-thumb  -->
				<?php endif; ?>
				
				<div class="wwd-block-inner inner-block-shadow">
					<?php if ( $icon ) : ?>
					<a class="wwd-fonts-icon" href="<?php the_permalink(); ?>" >
						<i class="<?php echo esc_attr( $icon ); ?>"></i>
					</a>
					<?php endif; ?>

					<div class="wwd-block-inner-content">
						<?php the_title( '<h3 class="wwd-item-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">','</a></h3>'); ?>

						<div class="wwd-block-item-excerpt">
							<?php the_excerpt(); ?>
						</div><!-- .wwd-block-item-excerpt -->
					</div><!-- .wwd-block-inner-content -->
				</div><!-- .wwd-block-inner -->
			</div><!-- .wwd-block-item -->
		<?php
		endwhile;
		?>
		</div><!-- .row -->
	</div><!-- .wwd-block-list -->
<?php
endif;

wp_reset_postdata();
