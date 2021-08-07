<?php
/**
 * Template part for displaying Service
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Cansa-Centre
 */

$deneb_enable_wwd = deneb_gtm( 'deneb_wwd_visibility' );

if ( ! deneb_display_section( $deneb_enable_wwd ) ) {
	return;
}

$deneb_top_subtitle = deneb_gtm( 'deneb_wwd_section_top_subtitle' );
$deneb_title        = deneb_gtm( 'deneb_wwd_section_title' );
$deneb_subtitle     = deneb_gtm( 'deneb_wwd_section_subtitle' );
?>

<div id="wwd-section" class="section style-one">
	<div class="section-wwd wwd-layout-1">
		<div class="container">
			<?php if ( $deneb_top_subtitle || $deneb_title || $deneb_subtitle ) : ?>
			<div class="section-title-wrap">
				<?php if ( $deneb_top_subtitle ) : ?>
				<p class="section-top-subtitle"><?php echo esc_html( $deneb_top_subtitle ); ?></p>
				<?php endif; ?>

				<?php if ( $deneb_title ) : ?>
				<h2 class="section-title"><?php echo esc_html( $deneb_title ); ?></h2>
				<?php endif; ?>

				<span class="divider"></span>
				<?php if ( $deneb_subtitle ) : ?>
				<p class="section-subtitle"><?php echo esc_html( $deneb_subtitle ); ?></p>
				<?php endif; ?>

			</div>
			<?php endif; ?>

			<?php get_template_part( 'template-parts/wwd/post-type' ); ?>
		</div><!-- .container -->
	</div><!-- .section-wwd  -->
</div><!-- .section -->
