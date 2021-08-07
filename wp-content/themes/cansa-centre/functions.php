<?php
/**
 * CansaCentre functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Cansa-Centre
 */

/**
 * Returns theme mod value saved for option merging with default option if available.
 * @since 1.0
 */
function deneb_gtm( $option ) {
	// Get our Customizer defaults
	$defaults = apply_filters( 'deneb_customizer_defaults', true );

	return isset( $defaults[ $option ] ) ? get_theme_mod( $option, $defaults[ $option ] ) : get_theme_mod( $option );
}

if ( ! function_exists( 'deneb_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function deneb_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on CansaCentre, use a find and replace
		 * to change 'cansa-centre' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'cansa-centre', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// Used in archive content, featured content.
		set_post_thumbnail_size( 825, 620, false );

		// Used in slider.
		add_image_size( 'cansa-centre-slider', 1920, 1000, false );

		// Used in hero content.
		add_image_size( 'cansa-centre-hero', 600, 650, false );

		// Used in portfolio, team.
		add_image_size( 'cansa-centre-portfolio', 400, 450, false );

		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary Menu', 'cansa-centre' ),
			'social' => esc_html__( 'Social Menu', 'cansa-centre' ),
		) );


		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'deneb_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );

		// Add theme editor style
		add_editor_style( array( 'css/editor-style.css' ) );

		// Add support for Block Styles.
		add_theme_support( 'wp-block-styles' );

		// Add support for editor styles.
		add_theme_support( 'editor-styles' );

		// Add support for full and wide align images.
		add_theme_support( 'align-wide' );

		// Add support for responsive embeds.
		add_theme_support( 'responsive-embeds' );

		add_theme_support( 'post-formats', array( 'aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat' ) );
	}
endif;
add_action( 'after_setup_theme', 'deneb_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 */
function deneb_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'deneb_content_width', 1230 );
}
add_action( 'after_setup_theme', 'deneb_content_width', 0 );

if ( ! function_exists( 'deneb_custom_content_width' ) ) :
	/**
	 * Custom content width.
	 *
	 * @since 1.0
	 */
	function deneb_custom_content_width() {
		$layout  = deneb_get_theme_layout();

		if ( 'no-sidebar-full-width' !== $layout ) {
			$GLOBALS['content_width'] = apply_filters( 'deneb_content_width', 890 );
		}
	}
endif;
add_filter( 'template_redirect', 'deneb_custom_content_width' );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function deneb_widgets_init() {
	$args = array(
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	);

	register_sidebar( array(
		'name'        => esc_html__( 'Sidebar', 'cansa-centre' ),
		'id'          => 'sidebar-1',
		'description' => esc_html__( 'Add widgets here.', 'cansa-centre' ),
		) + $args
	);

	register_sidebar( array(
		'name'        => esc_html__( 'Footer 1', 'cansa-centre' ),
		'id'          => 'sidebar-2',
		'description' => esc_html__( 'Add widgets here to appear in your footer.', 'cansa-centre' ),
		) + $args
	);

	register_sidebar( array(
		'name'        => esc_html__( 'Footer 2', 'cansa-centre' ),
		'id'          => 'sidebar-3',
		'description' => esc_html__( 'Add widgets here to appear in your footer.', 'cansa-centre' ),
		) + $args
	);

	register_sidebar( array(
		'name'        => esc_html__( 'Footer 3', 'cansa-centre' ),
		'id'          => 'sidebar-4',
		'description' => esc_html__( 'Add widgets here to appear in your footer.', 'cansa-centre' ),
		) + $args
	);
}
add_action( 'widgets_init', 'deneb_widgets_init' );

/**
 * Count the number of footer sidebars to enable dynamic classes for the footer
 *
 * @since 1.0
 */
function deneb_footer_sidebar_class() {
	$count = 0;

	if ( is_active_sidebar( 'sidebar-2' ) ) {
		$count++;
	}

	if ( is_active_sidebar( 'sidebar-3' ) ) {
		$count++;
	}

	if ( is_active_sidebar( 'sidebar-4' ) ) {
		$count++;
	}

	$class = '';

	switch ( $count ) {
		case '1':
			$class = 'one';
			break;
		case '2':
			$class = 'two';
			break;
		case '3':
			$class = 'three';
			break;
	}

	if ( $class ) {
		echo 'class="widget-area footer-widget-area ' . $class . '"'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}

if ( ! function_exists( 'deneb_fonts_url' ) ) :
	/**
	 * Register Google fonts for CansaCentre
	 *
	 * Create your own deneb_fonts_url() function to override in a child theme.
	 *
	 * @since 1.0
	 *
	 * @return string Google fonts URL for the theme.
	 */
	function deneb_fonts_url() {
		$fonts_url = '';

		/* Translators: If there are characters in your language that are not
		* supported by Poppins, translate this to 'off'. Do not translate
		* into your own language.
		*/
		$poppins = _x( 'on', 'Poppins font: on or off', 'cansa-centre' );

		if ( 'off' !== $poppins ) {
			$font_families = array();

			$font_families[] = 'Poppins:300,400,500,600,700,800,900';


			$query_args = array(
				'family' => urlencode( implode( '|', $font_families ) ),
				'subset' => urlencode( 'latin,latin-ext' ),
			);

			$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
		}

		return esc_url_raw( $fonts_url );
	}
endif;

/**
 * Enqueue scripts and styles.
 */
function deneb_scripts() {
	$min  = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
	// jQuery Script
	wp_deregister_script('jquery');
	wp_enqueue_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js', array(), null, true);

  // Youtube JS API.
	wp_deregister_script('data-api');
	wp_enqueue_script('data-api', 'https://apis.google.com/js/api.js', array( 'jquery' ), null, true);

	// Facebook Page-Plugin Javascript SDK
	wp_enqueue_script('page-plugin', 'https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v11.0', array(), '11.0', false);

	// Fullcalendar stylesheet.
	wp_enqueue_style('fullcalendar-css', get_template_directory_uri() . '/assets/fullcalendar/main.css', array(), null);

  // Fullcalendar script.
	wp_enqueue_script('fullcalendar-js', get_template_directory_uri() . '/assets/fullcalendar/main.min.js', array( 'jquery' ), '5.7.0', true);

  // ACF script.
	wp_enqueue_script('acf', get_template_directory_uri() . '/assets/acf/acf.min.js', array( 'jquery' ), null, true);

	// Mobile menu script.
	wp_enqueue_script('menu-script', get_template_directory_uri() . '/assets/menu/menu.js', array( 'jquery' ), null, true);

  // Fullcalendar user script.
	wp_enqueue_script('app', get_template_directory_uri() . '/assets/fullcalendar/app.js', array( 'jquery' ), null, true);

  // Youtube  user script.
	wp_enqueue_script('main', get_template_directory_uri() . '/assets/youtube/main.js', array( 'jquery' ), null, true);

  // Gallery user script.
	wp_enqueue_script('gallery-app', get_template_directory_uri() . '/assets/gallery/gallery-app.js', array( 'jquery' ), null, true);

	// FontAwesome.
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/css/font-awesome/css/solid' . $min . '.css', array(), '5.12.0', 'all' );

	// Theme stylesheet.
	wp_enqueue_style( 'cansa-centre-style', get_stylesheet_uri(), array(), deneb_get_file_mod_date( 'style.css' ) );

	// Add google fonts.
	// wp_enqueue_style( 'cansa-centre-fonts', deneb_fonts_url(), array(), null );

	// Theme block stylesheet.
	wp_enqueue_style( 'cansa-centre-block-style', get_template_directory_uri() . '/css/blocks' . $min . '.css', array( 'cansa-centre-style' ), deneb_get_file_mod_date( 'css/blocks' . $min . '.css' ) );

	$scripts = array(
		'cansa-centre-skip-link-focus-fix' => array(
			'src'      => '/js/skip-link-focus-fix' . $min . '.js',
			'deps'      => array(),
			'in_footer' => true,
		),
		'cansa-centre-keyboard-image-navigation' => array(
			'src'      => '/js/keyboard-image-navigation' . $min . '.js',
			'deps'      => array(),
			'in_footer' => true,
		),
	);

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	$deps = array( 'jquery', 'masonry' );

	$enable_featured_video = deneb_gtm( 'deneb_featured_video_visibility' );

	$scripts['cansa-centre-script'] = array(
		'src'       => '/js/functions' . $min . '.js',
		'deps'      => $deps,
		'in_footer' => true,
	);

	// Slider Scripts.
	$enable_slider                  = deneb_gtm( 'deneb_slider_visibility' );
	$enable_testimonial             = deneb_gtm( 'deneb_testimonial_visibility' );

	if ( deneb_display_section( $enable_slider ) || deneb_display_section( $enable_testimonial ) ) {
		wp_enqueue_style( 'swiper-css', get_template_directory_uri() . '/css/swiper' . $min . '.css', array(), deneb_get_file_mod_date( '/css/swiper' . $min . '.css' ), false );

		$scripts['swiper'] = array(
			'src'      => '/js/swiper' . $min . '.js',
			'deps'      => null,
			'in_footer' => true,
		);

		$scripts['swiper-custom'] = array(
			'src'      => '/js/swiper-custom' . $min . '.js',
			'deps'      => array( 'swiper' ),
			'in_footer' => true,
		);
	}

	// foreach ( $scripts as $handle => $script ) {
	// 	wp_enqueue_script( $handle, get_theme_file_uri( $script['src'] ), $script['deps'], deneb_get_file_mod_date( $script['src'] ), $script['in_footer'] );
	// }

	wp_localize_script( 'cansa-centre-script', 'denebScreenReaderText', array(
		'expand'   => esc_html__( 'expand child menu', 'cansa-centre' ),
		'collapse' => esc_html__( 'collapse child menu', 'cansa-centre' ),
	) );
}
add_action( 'wp_enqueue_scripts', 'deneb_scripts' );


/**
 * Get google fonts
 */

 function wpb_add_google_fonts() {

 	// Assistant Font
	wp_enqueue_style( 'wpb-google-fonts', 'https://fonts.googleapis.com/css2?family=Assistant:wght@200;300;400;500;600;700;800&display=swap', false );

 	// Roboto Condensed Font
	wp_enqueue_style( 'wpb-google-fonts', '"https://fonts.googleapis.com/css2?family=Roboto+Condensed:ital,wght@0,400;0,700;1,400;1,700&display=swap', false );

}
add_action( 'wp_enqueue_scripts', 'wpb_add_google_fonts' );

/**
 * Get file modified date
 */
function deneb_get_file_mod_date( $file ) {
	return date( 'Ymd-Gis', filemtime( get_theme_file_path( $file ) ) );
}

/**
 * Enqueue editor styles for Gutenberg
 */
function deneb_block_editor_styles() {
	// Block styles.
	wp_enqueue_style( 'cansa-centre-block-editor-style', trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'css/editor-blocks.css' );

	// Add custom fonts.
	// wp_enqueue_style( 'cansa-centre-fonts', deneb_fonts_url(), array(), null );
}
add_action( 'enqueue_block_editor_assets', 'deneb_block_editor_styles' );

/**
 * Implement the Custom Header feature.
 */
require get_theme_file_path( '/inc/custom-header.php' );

/**
 * Breadcrumb.
 */
require get_theme_file_path( '/inc/breadcrumb.php' );

/**
 * Custom template tags for this theme.
 */
require get_theme_file_path( '/inc/template-tags.php' );

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_theme_file_path( '/inc/template-functions.php' );

/**
 * Customizer additions.
 */
require get_theme_file_path( '/inc/customizer/customizer.php' );

/**
 * Metabox additions.
 */
require get_theme_file_path( '/inc/metabox.php' );

// require get_template_directory() . '/inc/custom-header.php';
class F6_DRILL_MENU_WALKER extends Walker_Nav_Menu
{
    /*
     * Add vertical menu class
     */

    public function start_lvl(&$output, $depth = 0, $args = array())
    {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul class=\"vertical menu\">\n";
    }
}

function f6_drill_menu_fallback($args)
{
    /*
     * Instantiate new Page Walker class instead of applying a filter to the
     * "wp_page_menu" function in the event there are multiple active menus in theme.
     */

    $walker_page = new Walker_Page();
    $fallback    = $walker_page->walk(get_pages(), 0);
    $fallback    = str_replace("children", "children vertical menu", $fallback);
    echo '<ul class="vertical medium-horizontal menu" data-responsive-menu="drilldown medium-dropdown" style="width: 100%;">' . $fallback . '</ul>';
}
/**
 * Registering custom postypes & taxonomies
 */
require get_template_directory() . '/inc/post-types.php';
require get_template_directory() . '/inc/taxonomy_types.php';


/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_theme_file_path( '/inc/jetpack.php' );
}

/**
 * Load Theme About Page
 */
require get_parent_theme_file_path( '/inc/theme-about.php' );

add_filter( 'widget_text', 'do_shortcode' );

function tg_include_custom_post_types_in_archive_pages( $query ) {
    if ( $query->is_main_query() && ! is_admin() && ( is_category() || is_tag() && empty( $query->query_vars['suppress_filters'] ) ) ) {
        $query->set( 'post_type', array( 'post', 'event' ) );
    }
}
function cptui_support_author_archive( $query ) {
    if ( $query->is_main_query() && ! is_admin() && ( is_author() && empty( $query->query_vars['suppress_filters'] ) ) ) {
        $query->set( 'post_type', array( 'post', 'event' ) );
    }
}
add_action( 'pre_get_posts', 'tg_include_custom_post_types_in_archive_pages' );
add_action( 'pre_get_posts', 'cptui_support_author_archive' );

function add_data_attribute($tag, $handle) {
   if ( 'page-plugin' !== $handle )
    return $tag;

   return str_replace( ' src', ' nonce="WJeSCh0N" async defer crossorigin="anonymous" src', $tag );
}
add_filter('script_loader_tag', 'add_data_attribute', 10, 2);
