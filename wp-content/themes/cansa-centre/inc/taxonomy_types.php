<?php

/**
 * Register a custom taxonomy type called "Activity".
 *
 * @see get_post_type_labels() for label keys.
 */
 function custom_taxonomy_type_init() {
  $tax_labels = array(
    'name' => 'Activites',
    'singular_name' => 'Activity',
    'search_items' => 'Search Activities',
    'all_items' => 'All Activities',
    'parent_item' => 'Parent Activity',
    'parent_item_colon' => 'Parent Activity',
    'edit_item' => 'Edit Activity',
    'update_item' => 'Update Activity',
    'add_new_item' => 'Add New Activity',
    'new_item_name' => 'New Activity Name',
    'menu_name' => 'Activities',
    'back_to_items' => __( 'Back to activities', 'cansa-centre' ),
    'not_found' => __( 'No activities found.', 'cansa-centre' ),
    'not_found_in_trash' => __( 'No activities found in Trash.', 'cansa-centre' ),
  );

  $tax_args = array(
    'hierarchical' => true,
    'labels' => $tax_labels,
    'show_ui' => true,
    'show_in_menu' => true,
    'query_var' => true,
    'show_admin_column' => true,
    'rewrite' => array( 'slug' => 'activity' ),
  );

  register_taxonomy('activity', array('event'), $tax_args);
}

add_action( 'init' , 'custom_taxonomy_type_init' );
?>
