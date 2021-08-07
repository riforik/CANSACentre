<?php
/**
 * Template part for displaying Post Types Slider
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Cansa-Centre
 */

// $deneb_args = deneb_get_section_args( 'featured_content' );
$deneb_args = array (
'ignore_sticky_posts' => 1,
'posts_per_page' => 3,
'post__in' =>
	array (
		'0' => 105,
		'1' => 103,
		'2' => 104
	),
'orderby' => post__in,
'post_type' => page
);

$post_types = array('Past Events', 'Ongoing', 'Upcoming');
foreach ($post_types as $key => $post_type) {
	$events[] = get_posts( array(
	 'numberposts'	=> 1,
	 'post_type'		=> 'event',
	 'meta_query' => array(
		 'relation' => 'AND',
		 array(
			 'key' => 'event_type',
			 'value' => $post_type,
			 'compare' => 'LIKE'
		 )
	 )
	));
}
$upcoming_args = array(
 'numberposts'	=> 1,
 'post_type'		=> 'event',
 'meta_query' => array(
	 'relation' => 'AND',
	 array(
		 'key' => 'event_type',
		 'value' => 'Upcoming',
		 'compare' => 'LIKE'
	 )
 )
);


$deneb_loop[] = new WP_Query( $deneb_args );
$deneb_loop[] = $events;
if ( $deneb_loop[0]->have_posts() ) :
	?>
	<div class="featured-content-block-list">
		<div class="row">
			<?php
			while ( $deneb_loop[0]->have_posts() ) :
				$deneb_loop[0]->the_post();

				?>
				<div class="latest-posts-item ff-grid-4">
					<div class="latest-posts-wrapper inner-block-shadow">
						<?php if ( has_post_thumbnail() ) : ?>
						<div class="latest-posts-thumb">
							<a class="image-hover-zoom" href="<?php the_permalink(); ?>" >
								<?php the_post_thumbnail(); ?>
							</a>
						</div><!-- latest-posts-thumb  -->
						<?php endif; ?>

						<div class="latest-posts-text-content-wrapper">
							<div class="latest-posts-text-content">
								<?php the_title( '<h3 class="latest-posts-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">','</a></h3>'); ?>
								<?php deneb_featured_content_meta();  ?>

								<?php deneb_display_content( 'featured_content' ); ?>

								<?php // print_r($deneb_args); ?>
							</div><!-- .latest-posts-text-content -->
						</div><!-- .latest-posts-text-content-wrapper -->
					</div><!-- .latest-posts-wrapper -->
				</div><!-- .latest-posts-item -->
			<?php endwhile; ?>

		</div><!-- .row -->
	</div><!-- .featured-content-block-list -->
	<?php
	endif; ?>
<?php

wp_reset_postdata();
