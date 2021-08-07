<?php
/**
 * Displays header site branding
 *
 * @package Cansa-Centre
 */

// Check metabox option.
$meta_option = get_post_meta( get_the_ID(), 'cansa-centre-header-image', true );



if ( empty( $meta_option ) ) {
	$meta_option = 'default';
}

// Bail if header image is removed via metabox option.
if ( 'disable' === $meta_option ) {
	return;
}

$deneb_enable = deneb_gtm( 'deneb_header_image_visibility' );

if ( deneb_display_section( $deneb_enable ) ) : ?>
<div id="custom-header">
	<?php is_header_video_active() && has_header_video() ? the_custom_header_markup() : ''; ?>

	<div class="custom-header-content">
		<div class="container">

	<div class="site-identity">
		<?php if ( is_front_page() ) : ?>
			<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
			<?php
			$description = get_bloginfo( 'description', 'display' );
			if ( $description || is_customize_preview() && is_front_page() ) : ?>
				<h2 class="site-description"><?php echo $description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></h2>

			<?php endif; ?>
		<?php else : ?>
			<?php deneb_header_title(); ?>
		<?php endif; ?>


	</div><!-- .site-identity -->

		</div> <!-- .container -->
	</div>  <!-- .custom-header-content -->

	<!-- If field group exists, get the home contents -->
	<?php
	if ( function_exists( 'get_field' ) ) {
	$home_contents = get_field( 'home_contents' );
	?>
	<?php
		foreach ( $home_contents as $home_content ) {
		$tagline = $home_content['tagline'];
		?>
			<div style="position: absolute;bottom: 0;text-align: center;width: 100%;color: white;z-index: 9;">
				<h3 style="color: white;">
						<!-- If site title exists, show it -->
						<?php if ($tagline){ ?>
						<?php echo $tagline; ?>
						<?php } ?>
				</h3>
			</div>
		<!-- End Foreach -->
		<?php } ?>
	<!-- End Home Contents If Statement -->
	<?php } ?>

</div>
<?php
endif;
