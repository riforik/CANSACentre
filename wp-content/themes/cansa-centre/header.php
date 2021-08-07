<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Cansa-Centre
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="theme-color" content="#4279BB"/>
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<link rel="canonical" href="http://www.cansacentre.com/"/>
	<link rel="manifest" href="../../../wp-includes/manifest.json">
	<link rel="preload" href="../../../wp-content/themes/cansa-centre/css/fonts/Roboto-Condensed/RobotoCondensed-Bold.ttf" as="font" type="font/ttf" crossorigin>
	<link rel="preload" href="../../../wp-content/themes/cansa-centre/css/fonts/Roboto-Condensed/RobotoCondensed-Regular.ttf" as="font" type="font/ttf" crossorigin>
	<link rel="preload" href="../../../wp-content/themes/cansa-centre/css/fonts/Assistant/Assistant-VariableFont_wght.ttf" as="font" type="font/ttf" crossorigin>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="fb-root"></div>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'cansa-centre' ); ?></a>

	<?php
		get_template_part( 'template-parts/header/header-one' );
		get_template_part( 'template-parts/header/custom-header' );
		get_template_part( 'template-parts/header/breadcrumb' );
		get_template_part( 'template-parts/slider/slider' );
		get_template_part( 'template-parts/wwd/wwd' );
		get_template_part( 'template-parts/hero-content/hero-content' );
		get_template_part( 'template-parts/portfolio/portfolio' );
		get_template_part( 'template-parts/featured-content/featured-content' );
		get_template_part( 'template-parts/testimonial/testimonial' );
	?>

	<div id="content" class="site-content">
		<div class="container">
			<div class="row">
