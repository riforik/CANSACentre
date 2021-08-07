<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Cansa-Centre
 */
 // Variables
 $ev_ID             = get_the_ID(); // post id
 $ev_name           = get_field('name'); // event name
 $ev_desc           = get_field('description'); // description
 $ev_auth_name      = get_the_author_meta('first_name');
 $ev_auth_url       = "https://www.cansacentre.com/author/" . get_the_author_meta('nicename');
 $ev_cat            = get_the_category($evID); // category array
 $ev_cat_name       = $ev_cat[0]->name; // category name
 $ev_cat_slug       = $ev_cat[0]->slug; // category slug
 $ev_cat_url        = "https://www.cansacentre.com/category/" . $ev_cat_slug; // category name
 $ev_image          = get_field('featured_image'); // image
 $ev_link           = get_the_guid(); // get post url
 $ev_date           = get_field('date'); // date array
 $ev_date_start     = date('Y/m/d', strtotime($ev_date['start_date']));
 $ev_date_start_str = date('F d, Y', strtotime($ev_date['start_date']));
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'grid-item' ); ?>>
	<div class="entry-inner archive author category tag">
		<div class="post-thumbnail event-post-thumbnail">
      <?php
      if ($ev_image) { ?>
        <a href="<?= $ev_link; ?>" aria-hidden="true" tabindex="-1">
          <img src="<?= $ev_image['url']; ?>" class="attachment-post-thumbnail size-post-thumbnail wp-post-image" alt="<?= $ev_image['alt']; ?>" loading="lazy" sizes="(max-width: 370px) 100vw, 370px" width="370" height="250">
        </a>
        <span class="cat-links">
          <?php if ($ev_cat): ?>
            <a href="<?= $ev_cat_url; ?>" rel="category tag"><?= $ev_cat_name; ?></a>
          <?php endif; ?>
        </span>
      <?php	} else {
        deneb_post_thumbnail();
        deneb_posted_cats();
        }
      ?>

		</div><!-- .post-thumbnail -->

		<div class="entry-container">
			<header class="entry-header">
				<?php
				if ( is_singular() ) :
					the_title( '<h1 class="entry-title">', '</h1>' );
				else :
					the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
				endif;
				?>
			</header><!-- .entry-header -->

			<?php if ( 'post' === get_post_type() ) : ?>
				<div class="entry-meta">
					<?php deneb_entry_header(); ?>

				</div>
			<?php endif; ?>
			<?php if ( 'event' === get_post_type() ) : ?>
				<div class="entry-meta">
          <?php if ($ev_date['start_date']) { ?>
            <span class="posted-on">
              <a href="<?= $ev_link; ?>" rel="bookmark">
                <time class="entry-date published updated" datetime="<?= $ev_date_start; ?>"><?= $ev_date_start_str; ?></time>
              </a>
            </span>
            <span class="byline">
              <span class="author vcard">
                <a class="url fn n" href="<?= $ev_auth_url; ?>"><?= $ev_auth_name; ?></a>
              </span>
            </span>
          <?php } ?>
				</div>
			<?php endif; ?>

			<div class="entry-summary">
				<?php the_excerpt(); ?>
        <?php if ($ev_desc): ?>
        <p><?php
          if (strlen($ev_desc) > 130) {
            $str = substr($ev_desc, 0, 130) . '...';
            echo $str;
          } else {
            echo $ev_desc;
          }
          ?>
          <a href="<?= $ev_link; ?>" class="more-link">
            <span class="more-button">Continue reading
              <span class="screen-reader-text"><?= get_the_title(); ?></span>
            </span>
          </a>
        </p>
        <?php endif; ?>
			</div>

			<?php if ( 'post' === get_post_type() ) : ?>
				<footer class="entry-footer">
					<div class="entry-meta">
						<?php deneb_entry_footer(); ?>
					</div>
				</footer><!-- .entry-footer -->
			<?php endif; ?>
			<?php if ( 'event' === get_post_type() ) : ?>
				<footer class="entry-footer">
          <div class="entry-meta">
						<span class="comments-link">
              <a href="<?= $ev_link . "#respond"; ?>">Leave a Comment
                <span class="screen-reader-text"> on <?= get_the_title(); ?></span>
              </a>
              </span>
              <?php edit_post_link( __( 'Edit', $ev_link ), '<span class="edit-link"><a class="post-edit-link">', '</a></span>', null, 'btn btn-primary btn-edit-post-link' ); ?>
              <span class="screen-reader-text">Start a fundraiser for yourself</span>
              </a>
            </span>
          </div>
				</footer><!-- .entry-footer -->
			<?php endif; ?>
		</div><!-- .entry-container -->
	</div><!-- .hentry-inner -->
</article><!-- #post-<?php the_ID(); ?> -->
