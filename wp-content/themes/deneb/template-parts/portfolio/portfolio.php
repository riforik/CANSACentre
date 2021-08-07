<?php
/**
 * Template part for displaying Service
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Deneb
 */

$deneb_visibility = deneb_gtm( 'deneb_portfolio_visibility' );

if ( ! deneb_display_section( $deneb_visibility ) ) {
	return;
}

?>
<div id="portfolio-section" class="section-portfolio section page style-one">
	<div class="container">
		<?php deneb_section_title( 'portfolio' ); ?>

		<?php get_template_part( 'template-parts/portfolio/post-type' ); ?>
	</div>
</div><!-- .section -->
