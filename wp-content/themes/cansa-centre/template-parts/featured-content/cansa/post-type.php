<?php
/**
 * Template part for displaying Post Types Slider
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Cansa-Centre
 */

/**
* Find the soonest date if an event is upcoming
*
* @access private
* @author Isaiah Robinson
* @param array $start_date Event Start Date
* @param array $interval_days Event Reoccurence Interval
* @param array $output_format Date Display Format
* @return date Date
*/
function nextDate($start_date, $interval_days, $output_format) {
  $start = strtotime($start_date);
  $end = strtotime(date('Y-m-d'));
  $days_ago = ($end - $start) / 24 / 60 / 60;
  if($days_ago < 0)return date($output_format,$start);
  $remainder_days = $days_ago % $interval_days;
  if($remainder_days > 0){
      $new_date_string = "+" . ($interval_days - $remainder_days) . " days";
  } else {
      $new_date_string = "today";
  }
  return date($output_format,strtotime($new_date_string));
}

$deneb_args = deneb_get_section_args( 'featured_content' );

// 3 event types to use for getting events.
$post_types = array('Past Events', 'Ongoing', 'Upcoming');

/**
* Get the single most recent event.
* 3 single events from each event type page.
* add each event item to an array called $events.
*/
foreach ($post_types as $key => $post_type) {
	$events[] = get_posts( array(
	 'numberposts'	=> 1,
	 'post_type'		=> 'event',
	 'meta_query'		=> array(
		 'relation'		=> 'AND',
		 array(
			 'key'				=> 'event_type',
			 'value'			=> $post_type,
			 'compare'		=> 'LIKE'
		 )
	 )
	));
}
/**********************************************************/

// add CansaCentre and CANSA posts
$deneb_loop[] = new WP_Query( $deneb_args );
$deneb_loop[] = $events;

// If the CANSA Centre Event Posts exist
if ($deneb_loop[1]) {
	?>
		<div class="featured-content-block-list">
			<div class="row">
		<?php
		$replace = ["/", " "]; // characters to replace

			// Variable to hold CANSA event posts
		 	$cansa_events = $deneb_loop[1];

			/**
		 * Get active website bloggers with profile photo for author page.
		 * If no photo exists on website, check intranet.
		 * If neither location has photo, send user email to upload one.
		 */
			foreach ($cansa_events as $key => $cansa_event) {
				if ($cansa_event) {
				$curr_event = $cansa_event[0];
				$event_id = $curr_event->ID; // get post ID
				$the_link = $curr_event->guid; // get post url

				// Info
				$event_type= get_field('event_type', $event_id); // desc
				$event_desc = get_field('description', $event_id); // desc
				$event_img = get_field('featured_image', $event_id); // image

				// Date
				$event_date = get_field('date', $event_id); // date group
				$reocurring = $event_date['reourring'];
				$secondary_date = get_field('secondary_date', $event_id); // date array
				$tertiary_date = get_field('tertiary_date', $event_id); // date array

				// Secondary & Tertiary Dates
				$dates_group[$key][] = $event_date;
				if (get_field('secondary_date_check', $event_id)) {
				  $dates_group[$key][] = $secondary_date;
				}
				if (get_field('tertiary_date_check', $event_id)) {
				  $dates_group[$key][] = $tertiary_date;
				}

				// URL
				$event_link = 'http://cansacentre.com/' . str_replace($replace, "-", $event_type);
				$log_stats = array(
					'id'		=> $event_id,
					'desc'	=> $event_desc,
					'date'	=> $event_date,
					'link'	=> $event_link,
					'image'	=> $event_img['id']
				);

				// HTML CONTENT
				?>
				<div class="latest-posts-item ff-grid-4">
					<div class="latest-posts-wrapper inner-block-shadow">
						<!-- Image -->
						<div class="latest-posts-thumb">
							<a class="image-hover-zoom" href="<?= $event_link; ?>">
								<img src="<?php print_r($event_img['sizes']['large']); ?>" class="attachment-thumbnail size-thumbnail" alt="Shree Purushottama flyer" loading="lazy" width="150" height="150">
							</a>
						</div>

						<div class="latest-posts-text-content-wrapper">
							<div class="latest-posts-text-content">
								<!-- Title -->
								<h3 class="latest-posts-title">
									<a href="<?= $event_link; ?>" rel="bookmark"><?= $event_type; ?></a>
								</h3>
								<!-- Date -->
								<?php if ($event_date['start_date']){ ?>
								<div class="entry-meta latest-posts-meta">
									<span class="posted-on">
										<a href="<?= $event_link; ?>" rel="bookmark">
											<?php

  											if ($reocurring) {
  												$curItm = $dates_group[$key];
  												$fnlDateCnt = count($curItm);
  												$fnlDate = $curItm[$fnlDateCnt - 1];
  												/**
  												* ---- StrToTime Arguments ----
  												* $event_date['start_date']
  												* will use primary event date
  												* 					OR
  												* $fnlDate['start_date']
  												* will use secondary/tertiary event date
  												*/
  												$start_date_input = date('m/d/Y', strtotime($event_date['start_date']));
  											 	?>
  												<time class="entry-date published"><?= nextDate($start_date_input,$event_date['frequency_days'],'F d, Y'); ?></time>
  												<?php
  											} else {
  												?>
  												<time class="entry-date published"><?= date('F d, Y', strtotime($event_date['start_date'])); ?></time>
  												<?php
  											}?>
										</a>
									</span>
								</div>
							<?php } else {
                ?>
                <div class="entry-meta latest-posts-meta">
                  <span class="posted-on">
                    <a href="<?= $event_link; ?>" rel="bookmark">
                      <time class="entry-date published"><?= get_the_date('F d, Y', $event_id); ?></time>
                    </a>
                  </span>
                </div>
                <?php
              } ?>

								<!-- Desc -->
								<div class="entry-summary">
									<p><?php
										// exceprt the description
										if (strlen($event_desc) > 125) {
											$str = substr($event_desc, 0, 125) . '...';
											echo $str;
										} else {
											echo $event_desc;
										} ?>
										<a href="<?= $event_link; ?>" class="more-link">
											<span class="more-button">Continue reading
												<span class="screen-reader-text"><?= $event_type; ?>
												</span>
											</span>
										</a>
									</p>
								</div>
							</div><!-- .latest-posts-text-content -->
						</div><!-- .latest-posts-text-content-wrapper -->
					</div><!-- .latest-posts-wrapper -->
				</div><!-- .latest-posts-item -->
				<?php

				}
				else {
					// CansaCentre posts script as fallback
					if ( $deneb_loop[0]->have_posts() ) :
						?>
						<div class="featured-content-block-list">
							<div class="row">
								<?php
								while ( $deneb_loop[0]->have_posts() ) :
									$deneb_loop[0]->the_post();

									?>
									<div class="latest-posts-item ff-grid-4">
										<div class="latest-posts-wrapper inner-block-shadow">
											<?php if ( has_post_thumbnail() ) : ?>
											<div class="latest-posts-thumb">
												<a class="image-hover-zoom" href="<?php the_permalink(); ?>" >
													<?php the_post_thumbnail(); ?>
												</a>
											</div><!-- latest-posts-thumb  -->
											<?php endif; ?>

											<div class="latest-posts-text-content-wrapper">
												<div class="latest-posts-text-content">
													<?php the_title( '<h3 class="latest-posts-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">','</a></h3>'); ?>
													<?php deneb_featured_content_meta();  ?>

													<?php deneb_display_content( 'featured_content' ); ?>

												</div><!-- .latest-posts-text-content -->
											</div><!-- .latest-posts-text-content-wrapper -->
										</div><!-- .latest-posts-wrapper -->
									</div><!-- .latest-posts-item -->
								<?php endwhile; ?>
							</div><!-- .row -->
						</div><!-- .featured-content-block-list -->
						<?php
						endif;
				} // end if else $cansa_event
			} // end foreach
		 ?>
		 		</div>
		 </div>
<?php
  }
wp_reset_postdata();

// EOF
