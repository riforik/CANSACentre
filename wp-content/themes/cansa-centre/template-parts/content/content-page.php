<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Cansa-Centre
 */

	// If field group exists, get the custom contents
	if ( function_exists( 'get_field' ) ) {
	$custom_contents = get_field( 'custom_contents' );

		foreach ( $custom_contents as $custom_content ) {
		$banner = $custom_content['banner'];
			if ($banner) {
			?>
				<style type="text/css">
					#custom-header {
						background-image: url('<?= $banner; ?>');
					}
				</style>
			<?php
			} else {
				break;
			} // End If Banner
		} // End Foreach
	} // End Custom Contents If Statement
	/***********************************************/
	?>


<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="single-content-wraper">
		<?php deneb_post_thumbnail(); ?>

		<div class="entry-content-wrapper">

			<?php
			$deneb_enable = deneb_gtm( 'deneb_header_image_visibility' );

			if ( ! deneb_display_section( $deneb_enable ) ) : ?>
			<header class="entry-header">
				<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
			</header><!-- .entry-header -->
			<?php endif; ?>

			<div class="entry-content">

				<?php
				the_content();

				wp_link_pages( array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'cansa-centre' ),
					'after'  => '</div>',
				) );
				?>
			</div><!-- .entry-content -->

			<?php if ( get_edit_post_link() ) : ?>
				<footer class="entry-footer">
					<?php
					edit_post_link(
						sprintf(
							wp_kses(
								/* translators: %s: Name of current post. Only visible to screen readers */
								__( 'Edit <span class="screen-reader-text">%s</span>', 'cansa-centre' ),
								array(
									'span' => array(
										'class' => array(),
									),
								)
							),
							get_the_title()
						),
						'<span class="edit-link">',
						'</span>'
					);
					?>
				</footer><!-- .entry-footer -->
			<?php endif; ?>
		</div><!-- .entry-content-wrapper -->
	</div><!-- .single-content-wraper -->
</article><!-- #post-<?php the_ID(); ?> -->
