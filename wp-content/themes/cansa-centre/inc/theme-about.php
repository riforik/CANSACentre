<?php
/**
 * Adds Theme page
 *
 * @package Cansa-Centre
 */

function deneb_about_admin_style( $hook ) {
	if ( 'appearance_page_deneb-about' === $hook ) {
		wp_enqueue_style( 'cansa-centre-theme-about', get_theme_file_uri( 'css/theme-about.css' ), null, '1.0' );
	}
}
add_action( 'admin_enqueue_scripts', 'deneb_about_admin_style' );

/**
 * Add theme page
 */
function deneb_menu() {
	add_theme_page( esc_html__( 'About Theme', 'cansa-centre' ), esc_html__( 'About Theme', 'cansa-centre' ), 'edit_theme_options', 'cansa-centre-about', 'deneb_about_display' );
}
add_action( 'admin_menu', 'deneb_menu' );

/**
 * Display About page
 */
function deneb_about_display() {
	$theme = wp_get_theme();
	?>
	<div class="wrap about-wrap full-width-layout">
		<h1><?php echo esc_html( $theme ); ?></h1>
		<div class="about-theme">
			<div class="theme-description">
				<p class="about-text">
					<?php
					// Remove last sentence of description.
					$description = explode( '. ', $theme->get( 'Description' ) );

					array_pop( $description );

					$description = implode( '. ', $description );

					echo esc_html( $description . '.' );
				?></p>
				<p class="actions">
					<a href="https://fireflythemes.com/themes/cansa-centre-pro" class="button button-secondary" target="_blank"><?php esc_html_e( 'Info', 'cansa-centre' ); ?></a>

					<a href="https://fireflythemes.com/documentation/cansa-centre/" class="button button-primary" target="_blank"><?php esc_html_e( 'Documentation', 'cansa-centre' ); ?></a>

					<a href="https://fireflythemes.com/demo/cansa-centre" class="button button-primary green" target="_blank"><?php esc_html_e( 'Demo', 'cansa-centre' ); ?></a>

					<a href="https://fireflythemes.com/support" class="button button-secondary" target="_blank"><?php esc_html_e( 'Support', 'cansa-centre' ); ?></a>
				</p>
			</div>

			<div class="theme-screenshot">
				<img src="<?php echo esc_url( $theme->get_screenshot() ); ?>" />
			</div>

		</div>

		<nav class="nav-tab-wrapper wp-clearfix" aria-label="<?php esc_attr_e( 'Secondary menu', 'cansa-centre' ); ?>">
			<a href="<?php echo esc_url( admin_url( add_query_arg( array( 'page' => 'cansa-centre-about' ), 'themes.php' ) ) ); ?>" class="nav-tab<?php echo ( isset( $_GET['page'] ) && 'cansa-centre-about' === $_GET['page'] && ! isset( $_GET['tab'] ) ) ?' nav-tab-active' : ''; ?>"><?php esc_html_e( 'About', 'cansa-centre' ); ?></a>

			<a href="<?php echo esc_url( admin_url( add_query_arg( array( 'page' => 'cansa-centre-about', 'tab' => 'changelog' ), 'themes.php' ) ) ); ?>" class="nav-tab<?php echo ( isset( $_GET['tab'] ) && 'changelog' === $_GET['tab'] ) ?' nav-tab-active' : ''; ?>"><?php esc_html_e( 'Changelog', 'cansa-centre' ); ?></a>
		</nav>

		<?php
			deneb_main_screen();

			deneb_changelog_screen();
		?>

		<div class="return-to-dashboard">
			<?php if ( current_user_can( 'update_core' ) && isset( $_GET['updated'] ) ) : ?>
				<a href="<?php echo esc_url( self_admin_url( 'update-core.php' ) ); ?>">
					<?php is_multisite() ? esc_html_e( 'Return to Updates', 'cansa-centre' ) : esc_html_e( 'Return to Dashboard &rarr; Updates', 'cansa-centre' ); ?>
				</a> |
			<?php endif; ?>
			<a href="<?php echo esc_url( self_admin_url() ); ?>"><?php is_blog_admin() ? esc_html_e( 'Go to Dashboard &rarr; Home', 'cansa-centre' ) : esc_html_e( 'Go to Dashboard', 'cansa-centre' ); ?></a>
		</div>
	</div>
	<?php
}

/**
 * Output the main about screen.
 */
function deneb_main_screen() {
	if ( isset( $_GET['page'] ) && 'cansa-centre-about' === $_GET['page'] && ! isset( $_GET['tab'] ) ) {
	?>
		<div class="feature-section two-col">
			<div class="col card">
				<h2 class="title"><?php esc_html_e( 'Theme Customizer', 'cansa-centre' ); ?></h2>
				<p><?php esc_html_e( 'All Theme Options are available via Customize screen.', 'cansa-centre' ) ?></p>
				<p><a href="<?php echo esc_url( admin_url( 'customize.php' ) ); ?>" class="button button-primary"><?php esc_html_e( 'Customize', 'cansa-centre' ); ?></a></p>
			</div>

			<div class="col card">
				<h2 class="title"><?php esc_html_e( 'Got theme support question?', 'cansa-centre' ); ?></h2>
				<p><?php esc_html_e( 'Get genuine support from genuine people. Whether it\'s customization or compatibility, our seasoned developers deliver tailored solutions to your queries.', 'cansa-centre' ) ?></p>
				<p><a href="https://fireflythemes.com/support" class="button button-primary"><?php esc_html_e( 'Support Forum', 'cansa-centre' ); ?></a></p>
			</div>
		</div>
	<?php
	}
}

/**
 * Output the changelog screen.
 */
function deneb_changelog_screen() {
	if ( isset( $_GET['tab'] ) && 'changelog' === $_GET['tab'] ) {
		global $wp_filesystem;
	?>
		<div class="wrap about-wrap">
			<?php
				$changelog_file = apply_filters( 'deneb_changelog_file', get_template_directory() . '/readme.txt' );

				// Check if the changelog file exists and is readable.
				if ( $changelog_file && is_readable( $changelog_file ) ) {
					WP_Filesystem();
					$changelog = $wp_filesystem->get_contents( $changelog_file );
					$changelog_list = deneb_parse_changelog( $changelog );

					echo wp_kses_post( $changelog_list );
				}
			?>
		</div>
	<?php
	}
}

/**
 * Parse changelog from readme file.
 * @param  string $content
 * @return string
 */
function deneb_parse_changelog( $content ) {
	// Explode content with ==  to juse separate main content to array of headings.
	$content = explode ( '== ', $content );

	$changelog_isolated = '';

	// Get element with 'Changelog ==' as starting string, i.e isolate changelog.
	foreach ( $content as $key => $value ) {
		if (strpos( $value, 'Changelog ==') === 0) {
			$changelog_isolated = str_replace( 'Changelog ==', '', $value );
		}
	}

	// Now Explode $changelog_isolated to manupulate it to add html elements.
	$changelog_array = explode( '= ', $changelog_isolated );

	// Unset first element as it is empty.
	unset( $changelog_array[0] );

	$changelog = '<pre class="changelog">';
		
	foreach ( $changelog_array as $value) {
		// Replace all enter (\n) elements with </span><span> , opening and closing span will be added in next process.
		$value = preg_replace( '/\n+/', '</span><span>', $value );

		// Add openinf and closing div and span, only first span element will have heading class.
		$value = '<div class="block"><span class="heading">= ' . $value . '</span></div>';

		// Remove empty <span></span> element which newr formed at the end.
		$changelog .= str_replace( '<span></span>', '', $value );
	}

	$changelog .= '</pre>';

	return wp_kses_post( $changelog );
}
