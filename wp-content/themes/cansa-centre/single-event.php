<?php
/**
 * Template part for displaying Post Types Events
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Cansa-Centre
 */

get_header();
the_post();

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
function nextDate($start_date,$interval_days,$output_format){
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
/***********************************************/

// Name
$event_id = get_the_id(); // event post id
$event_name = get_field('name'); // get post name

// Information
$event_desc     = get_field('description'); // description
$event_type     = get_field('event_type'); // event type
$event_location = get_field('location'); // location
$event_locType  = get_field('in-person_or_digital'); // loca. type
$event_image    = get_field('featured_image'); // image

// Date & Time Groups
$event_date     = get_field('date'); // date array
$secondary_date = get_field('secondary_date'); // date array
$tertiary_date  = get_field('tertiary_date'); // date array

// External Link Info
$event_ext_link         = get_field('external_link'); // external link group
$event_ext_link_url     = $event_ext_link['external_link_url']; // external link URL
$event_ext_link_prompt  = $event_ext_link['external_link_prompt']; // external link text

// Secondary & Tertiary Dates
$dates_group[] = $event_date;
if (get_field('secondary_date_check')) {
  $dates_group[] = $secondary_date;
}
if (get_field('tertiary_date_check')) {
  $dates_group[] = $tertiary_date;
}

// Zoom Videos Group
$zoom_group       = get_field('zoom'); // group
$zoom_enabled     = $zoom_group['zoom_enabled']; // checkbox
// $zoom_links       = $zoom_group['zoom_links']; // video links text area
$zoom_playlist    = $zoom_group['playlist']; // event video playlist
// $zoom_playlist    = $explode("list=", $zoom_playlist);
// $zoom_links_array = preg_split('/\r\n|\r|\n/', $zoom_links);

?>

<div class="wrap">
	<div id="event-hero">
    <article class="events" id="post-<?= $event_id; ?>" data-playlist="<?= $zoom_playlist; ?>">
      <aside class="event">
        <section class="info-container">

          <?php if( $event_image ): ?>
  					<div class="image">
              <img class="aligncenter" title="<?= $event_image['alt']; ?>" src="<?= $event_image['url']; ?>" width="75px" height="75px" sizes="(max-width: 100px) 100vw, 300px" />
            </div>
          <?php endif; ?>

          <section class="info">
              <h2><?= $event_name; ?></h2>
            <div class="details">
              <h4><?= $event_type; ?></h4>
              <h4><?= $event_location; ?></h4>
              <h4><?= $event_locType; ?></h4>
            </div>
            <div class="date-time-group">

              <?php

              foreach ($dates_group as $key => $curr_date):
                //  Date & Time Info, Occurence
                $event_multi_day = $curr_date['multi_day_event']; // multi day event
                $str_event_start = date('F d, Y', strtotime($curr_date['start_date']));
                $str_event_end   = date('F d, Y', strtotime($curr_date['end_date']));
                $event_date_time = $curr_date['time']; // time array
                $date_time_slot  = $event_date_time['time_slot'];
                $date_time_start = $event_date_time['start_time'];
                $date_time_end   = $event_date_time['end_time'];
                ?>
                <div class="date-time">
                  <h3 class="date-title">
                    <?php
                    // full name day i.e. "Tuesday"
                    if ($curr_date['start_date']) {
                      echo date('l', strtotime($curr_date['start_date']));
                    }
                    ?>
                  </h3>
                  <div class="date">
                    <p>
                      <span>
                      <?php if ($curr_date['start_date']): ?>
                        <i class="fas fa-calendar-check"></i>&nbsp;
                        <?php

                        // if date reoccurs
                        if ($curr_date['reourring']) {

                          // Convert start/end date input for nextDate()
                          $start_date_input = date('m/d/Y', strtotime($curr_date['start_date']));
                          $end_date_input   = date('m/d/Y', strtotime($curr_date['end_date']));

                          // Display upcoming start date
                          echo nextDate($start_date_input,$curr_date['frequency_days'],'M d, Y'); ?>
                      </span>

                          every <?= $curr_date['frequency_days']; ?> day(s)
                             <?php if ($event_multi_day) { ?>
                              <br>
                              <i class="fas fa-calendar-times"></i>&nbsp;
                              <span><?= date('M d, Y', strtotime($curr_date['end_date'])); ?></span> end date
                              <?php
                            }

                           } else {
                             echo $str_event_start ?></span>
                             <?php if ($event_multi_day) { ?>
                              to <span><?= $str_event_end; ?></span>
                            <?php }
                            }
                          endif; ?>
                    </p>
                  </div>
                  <?php if ($date_time_slot): ?>
                    <div class="time">
                        <p><i class="fas fa-clock"></i>&nbsp;
                          <?= $date_time_start;
                            if ($date_time_end) {
                              ?>
                              to <?= $date_time_end; ?>.
                              <?php
                            }
                          ?>
                        </p>
                    </div>
                <?php endif; ?>
                </div>
              <?php endforeach; ?>
            </div>
          </section>
        </section>
        <p><?= $event_desc; ?></p>
        <div class="links single">

          <?php if ($event_ext_link_url): ?>
            <a target="_blank" href="<?= $event_ext_link_url; ?>">
              <h4><i class="fas fa-external-link-alt"></i>&nbsp;
                <?php
                if ($event_ext_link_prompt) {
                  echo $event_ext_link_prompt;
                  } else { ?>
                    More Information
                <?php } ?>
              </h4>
            </a>
          <?php endif; ?>
        </div>
        <?php if ($zoom_playlist): ?>
        <div class="zoom">
          <button type="button" name="button" id="showZoom">
          </button>
          <ul class="list" id="list">
          </ul>
          <div class="zoom-loading">
            <h2><i class="fas fa-spinner" id="loading-spinner"></i></h2>
          </div>
        </div>
        <?php endif; ?>
        <div class="edit">
        <?php
        edit_post_link( __( 'Edit', get_the_guid() ), '<p><i class="fas fa-edit"></i>&nbsp;', '</p>', null, 'btn btn-primary btn-edit-post-link' );
         ?>
         </div>
      </aside>
    </article><!-- #post-<?= $event_id; ?> -->
	<?php
		the_post_navigation( array(
						'prev_text' => '<span class="meta-nav">' . __( 'Previous', 'cansa-centre' ) . '</span>' . '<span class="post-title">'. '%title' .'</span>',
						'next_text' => '<span class="meta-nav">' . __( 'Next', 'cansa-centre' ) . '</span>' . '<span class="post-title">'.  '%title' .'</span>',
					) );

    // If comments are open or we have at least one comment, load up the comment template.
    /*
    if ( comments_open() || get_comments_number() ) :
      comments_template();
    endif;
    */
	 ?>
	</div>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<?php the_content(); ?>
		</main>
	</div>

</div>

<?php
get_footer(); ?>
