<?php
/**
 * Template for displaying search forms in Deneb
 *
 * @package Deneb
 */
?>

<?php $search_text = deneb_gtm( 'deneb_search_text' ); ?>

<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label>
		<span class="screen-reader-text"><?php echo esc_html_x( 'Search for:', 'label', 'deneb' ); ?></span>
		<input type="search" class="search-field" placeholder="<?php echo esc_attr( $search_text ); ?>" value="<?php the_search_query(); ?>" name="s" />
	</label>
	<input type="submit" class="search-submit" value="&#xf002;" />

</form>
