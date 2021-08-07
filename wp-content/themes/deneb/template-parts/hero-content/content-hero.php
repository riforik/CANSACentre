<?php
/**
 * Template part for displaying Hero Content
 *
 * @package Deneb
 */

$deneb_args = array(
	'page_id' => absint( deneb_gtm( 'deneb_hero_content_page' ) ),
);

// If $deneb_args is empty return false
if ( ! $deneb_args ) {
	return;
}

$deneb_args['posts_per_page'] = 1;

$deneb_loop = new WP_Query( $deneb_args );

while ( $deneb_loop->have_posts() ) :
	$deneb_loop->the_post();
	?>

	<div id="hero-content-section" class="hero-content-section section content-position-right default">
		<div class="section-featured-page">
			<div class="container">
				<div class="row">
					<?php if ( has_post_thumbnail() ) : ?>
					<div class="ff-grid-6 featured-page-thumb">
						<?php the_post_thumbnail( 'deneb-hero', array( 'class' => 'alignnone' ) );?>
					</div>
					<?php endif; ?>

					<!-- .ff-grid-6 -->
					<div class="ff-grid-6 featured-page-content">
						<div class="featured-page-section">
							<div class="section-title-wrap">
								<?php 
								$deneb_subtitle = deneb_gtm( 'deneb_hero_content_custom_subtitle' );
								
								if ( $deneb_subtitle ) : ?>
								<p class="section-top-subtitle"><?php echo esc_html( $deneb_subtitle ); ?></p>
								<?php endif; ?>

								<?php the_title( '<h2 class="section-title">', '</h2>' ); ?>

								<span class="divider"></span>
							</div>

							<?php deneb_display_content( 'hero_content' ); ?>
						</div><!-- .featured-page-section -->
					</div><!-- .ff-grid-6 -->
				</div><!-- .row -->
			</div><!-- .container -->
		</div><!-- .section-featured-page -->
	</div><!-- .section -->
<?php
endwhile;

wp_reset_postdata();
