<?php
/**
 * Header Search
 *
 * @package Cansa-Centre
 */

$deneb_phone      = deneb_gtm( 'deneb_header_phone' );
$deneb_email      = deneb_gtm( 'deneb_header_email' );
$deneb_address    = deneb_gtm( 'deneb_header_address' );
$deneb_open_hours = deneb_gtm( 'deneb_header_open_hours' );

if ( $deneb_phone || $deneb_email || $deneb_address || $deneb_open_hours ) : ?>
	<div class="inner-quick-contact">
		<ul>
			<?php if ( $deneb_phone ) : ?>
				<li class="quick-call">
					<span><?php esc_html_e( 'Phone', 'cansa-centre' ); ?></span><a href="tel:<?php echo preg_replace( '/\s+/', '', esc_attr( $deneb_phone ) ); ?>"><?php echo esc_html( $deneb_phone ); ?></a> </li>
			<?php endif; ?>

			<?php if ( $deneb_email ) : ?>
				<li class="quick-email"><span><?php esc_html_e( 'Email', 'cansa-centre' ); ?></span><a href="<?php echo esc_url( 'mailto:' . esc_attr( antispambot( $deneb_email ) ) ); ?>"><?php echo esc_html( antispambot( $deneb_email ) ); ?></a> </li>
			<?php endif; ?>

			<?php if ( $deneb_address ) : ?>
				<li class="quick-address"><span><?php esc_html_e( 'Address', 'cansa-centre' ); ?></span><?php echo esc_html( $deneb_address ); ?></li>
			<?php endif; ?>

			<?php if ( $deneb_open_hours ) : ?>
				<li class="quick-open-hours"><span><?php esc_html_e( 'Open Hours', 'cansa-centre' ); ?></span><?php echo esc_html( $deneb_open_hours ); ?></li>
			<?php endif; ?>
		</ul>
	</div><!-- .inner-quick-contact -->
<?php endif; ?>

