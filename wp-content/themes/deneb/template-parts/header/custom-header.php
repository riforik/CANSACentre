<?php
/**
 * Displays header site branding
 *
 * @package Deneb
 */

// Check metabox option.
$meta_option = get_post_meta( get_the_ID(), 'deneb-header-image', true );

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
			<?php deneb_header_title(); ?>
		</div> <!-- .container -->
	</div>  <!-- .custom-header-content -->
</div>
<?php
endif;
