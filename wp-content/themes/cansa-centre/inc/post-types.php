<?php

/**
 * Register a custom post type called "Event".
 *
 * @see get_post_type_labels() for label keys.
 */
function custom_post_type_init() {
    $labels = array(
        'name'                  => _x( 'Events', 'Post type general name', 'cansa-centre' ),
        'singular_name'         => _x( 'Event', 'Post type singular name', 'cansa-centre' ),
        'menu_name'             => _x( 'Events', 'Admin Menu text', 'cansa-centre' ),
        'name_admin_bar'        => _x( 'Event', 'Add New on Toolbar', 'cansa-centre' ),
        'add_new'               => __( 'Add New', 'cansa-centre' ),
        'add_new_item'          => __( 'Add New Event', 'cansa-centre' ),
        'new_item'              => __( 'New Event', 'cansa-centre' ),
        'edit_item'             => __( 'Edit Event', 'cansa-centre' ),
        'view_item'             => __( 'View Event', 'cansa-centre' ),
        'all_items'             => __( 'All Events', 'cansa-centre' ),
        'search_items'          => __( 'Search Events', 'cansa-centre' ),
        'parent_item_colon'     => __( 'Parent Events:', 'cansa-centre' ),
        'not_found'             => __( 'No Events found.', 'cansa-centre' ),
        'not_found_in_trash'    => __( 'No Events found in Trash.', 'cansa-centre' ),
       // 'featured_image'        => _x( 'Event Cover Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'cansa-centre' ),
        //'set_featured_image'    => _x( 'Set cover image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'cansa-centre' ),
       // 'remove_featured_image' => _x( 'Remove cover image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'cansa-centre' ),
       // 'use_featured_image'    => _x( 'Use as cover image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'cansa-centre' ),
        'archives'              => _x( 'Event archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'cansa-centre' ),
        'insert_into_item'      => _x( 'Insert into Event', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'cansa-centre' ),
        'uploaded_to_this_item' => _x( 'Uploaded to this Event', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'cansa-centre' ),
        'filter_items_list'     => _x( 'Filter Events list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'cansa-centre' ),
        'items_list_navigation' => _x( 'Events list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'cansa-centre' ),
        'items_list'            => _x( 'Events list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'cansa-centre' ),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'Events' ), // added an s on end of Event to make the slug plural
        'capability_type'    => 'post',
        //'has_archive'        => true, we're using a WP query to pull the info in so we can leave has_archive as false
        'hierarchical'       => false,
        'menu_position'      => null,
        'menu_icon'          => 'dashicons-calendar-alt',
        'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ),
        'taxonomies'         => array('category', 'post_tag'),
    );

    register_post_type( 'Event', $args );
}

add_action( 'init', 'custom_post_type_init' );
