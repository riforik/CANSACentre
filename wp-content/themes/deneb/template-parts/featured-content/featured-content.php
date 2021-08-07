<?php
/**
 * Template part for displaying Service
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Deneb
 */

$deneb_visibility = deneb_gtm( 'deneb_featured_content_visibility' );

if ( ! deneb_display_section( $deneb_visibility ) ) {
	return;
}

?>
<div id="featured-content-section" class="featured-content-section section style-one page">
	<div class="section-latest-posts">
		<div class="container">
			<?php deneb_section_title( 'featured_content' ); ?>

		    <?php get_template_part( 'template-parts/featured-content/post-type' ); ?>

			<?php
			$deneb_button_text   = deneb_gtm( 'deneb_featured_content_button_text' );
			$deneb_button_link   = deneb_gtm( 'deneb_featured_content_button_link' );
			$deneb_button_target = deneb_gtm( 'deneb_featured_content_button_target' ) ? '_blank' : '_self';

			if ( $deneb_button_text ) : ?>
				<div class="more-wrapper clear-fix">
					<a href="<?php echo esc_url( $deneb_button_link ); ?>" class="ff-button" target="<?php echo esc_attr( $deneb_button_target ); ?>"><?php echo esc_html( $deneb_button_text ); ?></a>
				</div><!-- .more-wrapper -->
			<?php endif; ?>
		</div><!-- .container -->
	</div><!-- .latest-posts-section -->
</div><!-- .section-latest-posts -->

