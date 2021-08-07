<?php
/**
* Template part for displaying page content in page.php
*
* @link https://developer.wordpress.org/themes/basics/template-hierarchy/
*
* @package Cansa-Centre
*
*
* Get Gallery photos from gallery page shortcode
*
* @access private
* @author Isaiah Robinson
* @param array $image_posts Image Posts
* @param array $image_ids Image Post IDs
* @param array $image_attachments Image Posts Meta Attachments
*/
 function get_gal_photos(array $image_posts, array $image_ids, array $image_attachments){

   // Create HTML Gallery Container

	?><article id="gallery-row" class="gallery-row"><?php
	$gallery_post_array = (array) null; // empty array variable

  /**
 * Use the images ids list to filter media
 * Add items that find a match to a gallery posts array
 */
 	foreach ($image_posts as $image) {
    $image_id = $image->ID; // get image ID

    // add images that are in the gallery
		if (in_array($image_id, $image_ids)) { // if attachment is in the gallery
			array_push($gallery_post_array, $image); // add image to array
		}
 	}

	$rev_arr = array_reverse($gallery_post_array); // reverse array order

    /**
   * Get individual photos from the gallery short code array.
   * Create an HTML figure element that contains the individual images
   */
	foreach ($image_attachments as $index => $photo) {
    $p_img_id         = $rev_arr[$index]->ID; // get image ID
		$p_img_activity[] = get_field('activity', $p_img_id); // get post name
    $concatStr        = []; // declare concatonated string array
		?>
      <figure class="gallery-item">
			<div class="gallery-icon">
				<a href="">
					<?=
          $photo;
          foreach ($p_img_activity[$index] as $key => $currAc) {
            $concatStr[] = $p_img_activity[$index][$key]->slug;
          } ?>
          <p data-name="<?= $p_img_activity[$index][0]->name; ?>"
             data-slug="<?= implode(" ", array_reverse($concatStr)); ?>"
             data-date="<?php echo get_post_time('Y-m-d', false, $p_img_id); ?>">
           </p>
        </a>
			</div>
		</figure>
		<?php
	} // end foreach
  /**************************************************/

  setup_postdata( $image );

  ?> </article> <?php
} // end get_gal_photos

  // Custom Banner Image
	if ( function_exists( 'get_field' ) ) {
	   $custom_contents  = get_field( 'custom_contents' );

	   foreach ( $custom_contents as $custom_content ) {
	   $banner           = $custom_content['banner'];
			if ($banner) { ?>
				<style type="text/css">
					#custom-header {
						background-image: url('<?= $banner; ?>');
					}
				</style>
			<?php } else {
				break;
			}
    }
  } // end Custom Banner Image

  $terms = get_terms([
    'taxonomy'    => 'activity',
    'hide_empty'  => false,
    'parent'      => 0,
  ]);
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

        <!-- Gallery Nav -->
        <nav class="gallery-nav">
          <div class="view-select">
            <label for="gallery-view">Choose an View:</label>&nbsp;
            <select id="gallery-view" name="view" disabled="true">
              <option value="column">Mosaic</option>
              <option value="masonry">Masonry</option>
              <option value="full">Full</option>
            </select>

          </div>
          <div class="date-input">
            <input type="date" id="sort-date" name="sort-date" value="2021-07-29" min="2021-06-13" list="event-dates-list" disabled>
            <datalist id="event-dates-list" disabled>
            </datalist>
          </div>
          <div class="event-select">
            <label for="gallery-event">Choose an Event:</label>
            <select id="gallery-event" name="event">
              <option value="All Events" class="emptyOption" disabled selected>⎯⎯&nbsp; select an event&nbsp; ⎯⎯</option>
              <?php
              foreach ($terms as $key => $term) {
                $child_terms = get_terms([
                  'taxonomy'    => 'activity',
                  'hide_empty'  => false,
                  'parent'      => $term->term_id,
                ]);
                ?>
                <option value="<?= $term->slug; ?>" class="parent"><?= $term->name; ?></option>
                <?php if ($child_terms) { ?>
                  <?php foreach ($child_terms as $key => $term1) { ?>
                    <option value="<?= $child_terms[$key]->slug; ?>">&nbsp;&nbsp;&nbsp; <?= $child_terms[$key]->name; ?></option>
                  <?php
                  };
                };
              }; ?>
            </select>   <!-- #gallery-event -->
          </div>  <!-- .event-select -->
          <div class="sort-buttons">
            <button id="sortAsc" disabled="true">Ascending</button><br>
            <button id="sortDesc" disabled="true">Descending</button>
          </div>  <!-- .sort-buttons -->
        </nav>  <!-- .gallery-nav -->
        <nav class="desktop-gallery-nav">
          <h1>Filters</h1>
          <p>Sort</p>
          <div class="sort-buttons">
            <button id="sortAscDesk" disabled="true">Ascending</button>
            <button id="sortDescDesk" disabled="true">Descending</button>
          </div>  <!-- .sort-buttons -->
          <p>Views</p>
          <form id="view_radio">
            <input type="radio" name="view_options" value="0" id="column-radio" disabled checked>
            <label for="column-radio">Mosaic</label><br>

            <input type="radio" name="view_options" value="1" id="masonry-radio" disabled>
            <label for="masonry-radio">Masonry</label><br>

            <input type="radio" name="view_options" value="2" id="full-radio" disabled>
            <label for="full-radio">Full</label><br>
          </form>
          <p>Events</p>
          <form id="event_radio">
            <input class="emptyOption" type="radio" name="event_options" value="All Events" id="all-events" disabled checked>
            <label class="emptyOption" for="all-events">⎯⎯&nbsp; select an event&nbsp; ⎯⎯</label><br>
            <?php
            foreach ($terms as $key => $term) {
              $child_terms = get_terms([
                'taxonomy'    => 'activity',
                'hide_empty'  => false,
                'parent'      => $term->term_id,
              ]);
              ?>
              <input type="radio" name="event_options" value="<?= $term->slug; ?>" id="<?= $term->slug; ?>">
              <label for="<?= $term->slug; ?>"><?= $term->name; ?></label><br>
              <?php if ($child_terms) { ?>
                <?php foreach ($child_terms as $key => $term1) { ?>
                  <input class="child" type="radio" name="event_options" value="<?= $term1->slug; ?>" id="<?= $term1->slug; ?>">
                  <label for="<?= $term1->slug; ?>"><?= $term1->name; ?></label><br>
                <?php
                };
              };
            }; ?>
          </form>
          <p>Dates</p>
          <div class="date-input">
            <input type="date" id="sort-date-desktop" name="sort-date-desktop" value="2021-07-29" min="2021-06-13" disabled>
          </div>
        </nav>
        <button class="showNav" id="showNav" type="button" name="button">
          <i class="fas fa-chevron-down"></i>
        </button>

				<?php
				// the_content();

				wp_link_pages( array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'cansa-centre' ),
					'after'  => '</div>',
				) );


				$image_attachments = (array) null; // empty array variable
				$gallerys = get_post_gallery( get_the_ID(), false ); // get the gallery

				// If the gallery exists
				if ( $gallerys ) {
					$image_ids = explode(",", $gallerys['ids']); // separated image IDs

					// For each photo in the gallery, send that attachment to an array
					foreach ( $image_ids as $ids ) {
						array_push($image_attachments, wp_get_attachment_image($ids, 'full')); // add to array
					}

					 $image_posts = get_posts(array(
					 	'numberposts'    => -1,
					 	'post_type'      => 'attachment',
						'post_mime_type' => 'image', // Make sure it doesn't pull other resources, like videos
					 	'orberby'        => 'menu_order',
						'post_status'    => null,
						'order'          => 'DESC'
					 ));

         get_gal_photos(
           $image_posts,
           $image_ids,
           $image_attachments
         );
				}
				 ?>

         <aside class="gallery-splash">
           <h1 class="splash-title">
             <span>
               <i class="fas fa-photo-video"></i>&nbsp; Choose an Event
             </span>
           </h1>
         </aside>
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
<?php wp_reset_postdata();

// EOF ?>
