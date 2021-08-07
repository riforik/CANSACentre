<?php
/**
* Template part for displaying Post Types Events
*
* @link https://developer.wordpress.org/themes/basics/template-hierarchy/
*
* @package Cansa-Centre
*/

the_post();
$page_id = get_queried_object_id();
$curr_page = esc_html( get_the_title($page_id) );

if ( is_page( 'activities' ) ) {
  $events = get_posts(array(
    'numberposts'	=> -1,
    'post_type'		=> 'event',
    'meta_key'    => 'event_type',
    'order'				=> 'ASC',
    'orderby'     => 'meta_value',
  ));
} else {
   $args = array(
    'numberposts'	=> -1,
  	'post_type'		=> 'event',
    'meta_key'    => 'date_start_date',
    'orderby'     => 'meta_value',
   	'order'				=> 'DESC',
    'meta_query'  => array(
      'relation'    => 'AND',
      array(
        'key'       => 'event_type',
        'value'     => $curr_page,
        'compare'   => 'LIKE'
      )
    )
   );

  $events = get_posts( $args );
}

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
function nextDate($start_date, $interval_days, $output_format){
   $start    = strtotime($start_date);
   $end      = strtotime(date('Y-m-d'));
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

if( $events ):
  foreach( $events as $event ):
  $event_id = $event->ID; // get post ID
  $the_link = $event->guid; // get post url

  // Name
  $event_name = get_field('name', $event_id); // get post name

  // Information
  $event_desc     = get_field('description', $event_id); // description
  $event_type     = get_field('event_type', $event_id); // event type
  $event_location = get_field('location', $event_id); // location
  $event_locType  = get_field('in-person_or_digital', $event_id); // loca. type
  $event_image    = get_field('featured_image', $event_id); // image
  $event_f_image  = get_the_post_thumbnail( $event_id, 'medium', array( 'class' => 'aligncenter' ) );

  // Date & Time Groups
  $event_date      = get_field('date', $event_id); // date array
  $event_date_time = $event_date['time']; // time array

  // External Link Info
  $event_ext_link        = get_field('external_link', $event_id); // external link group
  $event_ext_link_url    = $event_ext_link['external_link_url']; // external link URL
  $event_ext_link_prompt = $event_ext_link['external_link_prompt']; // external link text

  //  Date & Time Info, Occurence
  $event_multi_day = $event_date['multi_day_event']; // multi day event
  $str_event_start = date('F d, Y', strtotime($event_date['start_date']));
  $str_event_end   = date('F d, Y', strtotime($event_date['end_date']));
  $date_time_slot  = $event_date_time['time_slot'];
  $date_time_start = $event_date_time['start_time'];
  $date_time_end   = $event_date_time['end_time'];
  $secondary_date  = get_field('secondary_date', $event_id); // date array

  // Zoom Videos Group
  $zoom_group       = get_field('zoom', $event_id); // group
  $zoom_enabled     = $zoom_group['zoom_enabled']; // checkbox
  $zoom_links       = $zoom_group['zoom_links']; // video links text area
  $zoom_links_array = explode(PHP_EOL, $zoom_links);

  // display posts
  setup_postdata( $event );
?>
  <article class="events" id="post-<?= $event_id; ?>">
    <aside class="event">
      <a href="<?= $the_link; ?>">
      <section class="info-container">
        <div class="image">
          <?php if( $event_f_image ){ ?>
            <img class="aligncenter" title="<?= $event_image['alt']; ?>" src="<?= $event_image['url']; ?>" width="75px" height="75px" sizes="(max-width: 100px) 100vw, 300px" />
          <?php } elseif ($event_image) { ?>
            <img class="aligncenter" title="<?= $event_image['alt']; ?>" src="<?= $event_image['url']; ?>" width="75px" height="75px" sizes="(max-width: 100px) 100vw, 300px" />
          <?php }; ?>

        </div>
        <section class="info">
          <div class="title">
            <h2><?= $event_name; ?></h2>
          </div>
          <div class="details">
            <h4><?= $event_type; ?></h4>
            <h4><?= $event_location; ?></h4>
            <h4><?= $event_locType; ?></h4>
            <?php if ($zoom_enabled): ?>
              <h4 class="zoom">
                <i class="fas fa-video"></i>
              </h4>
            <?php endif; ?>
          </div>
          <div class="date">
            <p><span>
              <?php if ($event_date['start_date']): ?>
                <i class="fas fa-calendar-check"></i>&nbsp;
                <?php

                  // if date reoccurs
                  if ($event_date['reourring']) {

                    $start_date_input = date('m/d/Y', strtotime($event_date['start_date']));
                    $end_date_input   = date('m/d/Y', strtotime($event_date['end_date']));

                    if ($secondary_date) {

                      ?> Multiple Dates</span>
                      every <?= $event_date['frequency_days']; ?> day(s)
                      <?php if ($event_multi_day) { ?>
                       <br> <i class="fas fa-calendar-times"></i>&nbsp;
                       <span><?= date('M d, Y', strtotime($end_date_input)); ?></span> end date
                     <?php }
                    } else {

                      echo nextDate($start_date_input,$event_date['frequency_days'],'F d, Y');
                      ?>
                      </span>
                        every <?= $event_date['frequency_days']; ?> day(s)
                        <?php if ($event_multi_day) { ?>
                         <br> <i class="fas fa-calendar-times"></i>&nbsp;
                         <span><?= nextDate($end_date_input,7,'M d, Y'); ?></span> end date
                      <?php }
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
            <div class="date">
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
        </section>
      </section>
    </a>
    <p><?php
      if (strlen($event_desc) > 250) {
        $str = substr($event_desc, 0, 250) . '...';
        echo $str;
      } else {
        echo $event_desc;
      }
      ?>
    </p>
    <div class="links">
      <a href="<?= $the_link; ?>" class="more-link"><span class="more-button">Continue reading</span></a>
      <?php if ($event_ext_link_url): ?>
        <a href="<?= $event_ext_link_url; ?>">
          <h4><i class="fas fa-external-link-alt"><!-- icon --></i>&nbsp

            <?php if ($event_ext_link_prompt) {
              echo $event_ext_link_prompt;
            } else { ?>
                More Information
            <?php } ?>
          </h4>
        </a>
      <?php endif; ?>
    </div>
    </aside>
  </article><!-- #post-<?= $event_id; ?> -->
	<?php endforeach;
  wp_reset_postdata();
 endif;

// EOF
?>
