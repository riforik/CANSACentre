<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Deneb
 */

get_header();
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

		<?php
		while ( have_posts() ) :
			the_post();

			get_template_part( 'template-parts/content/content', 'single' );

			the_post_navigation( array(
	            'prev_text' => '<span class="meta-nav">' . __( 'Previous', 'deneb' ) . '</span>' . '<span class="post-title">'. '%title' .'</span>',
	            'next_text' => '<span class="meta-nav">' . __( 'Next', 'deneb' ) . '</span>' . '<span class="post-title">'.  '%title' .'</span>',
	        ) );

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		endwhile; // End of the loop.
		?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
