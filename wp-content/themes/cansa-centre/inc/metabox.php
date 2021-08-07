<?php
/**
 * The template for displaying meta box in page/post
 *
 * This adds Select Sidebar, Header Featured Image Options, Single Page/Post Image
 * This is only for the design purpose and not used to save any content
 *
 * @package Cansa-Centre
 */

/**
 * Register meta box(es).
 */
function deneb_register_meta_boxes() {
	add_meta_box( 'cansa-centre-featured-image-options', esc_html__( 'Featured Image', 'cansa-centre' ), 'deneb_display_featured_image_options', array( 'post', 'page' ), 'side' );
}
add_action( 'add_meta_boxes', 'deneb_register_meta_boxes' );
 
/**
 * Meta box display callback.
 *
 * @param WP_Post $post Current post object.
 */
function deneb_display_featured_image_options( $post ) {
	wp_nonce_field( basename( __FILE__ ), 'deneb_custom_meta_box_nonce' );

	$featured_image_options = array(
		'default'                   => esc_html__( 'Default', 'cansa-centre' ),
		'disabled'                  => esc_html__( 'Disabled', 'cansa-centre' ),
		'post-thumbnail'            => esc_html__( 'Post Thumbnail (470x470)', 'cansa-centre' ),
		'cansa-centre-slider' => esc_html__( 'Slider Image (1920x954)', 'cansa-centre' ),
		'full'                      => esc_html__( 'Original Image Size', 'cansa-centre' ),
	);

	$meta_option = get_post_meta( $post->ID, 'cansa-centre-featured-image', true );

	if ( empty( $meta_option ) ){
		$meta_option = 'default';
	}
	
	?>
	<select name="cansa-centre-featured-image"> 
		<?php
		foreach ( $featured_image_options as $field => $label ) {
		?>
			<option value="<?php echo esc_attr( $field ); ?>" <?php selected( $field, $meta_option ); ?>><?php echo esc_html( $label ); ?></option>
		<?php
		} // endforeach.
		?>
	</select>
	<?php
}
 
/**
 * Save meta box content.
 *
 * @param int $post_id Post ID
 */
function deneb_save_meta_box( $post_id ) {
	global $post_type;

	$post_type_object = get_post_type_object( $post_type );

	if ( ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )                      // Check Autosave
	|| ( ! isset( $_POST['post_ID'] ) || $post_id != $_POST['post_ID'] )        // Check Revision
	|| ( ! in_array( $post_type, array( 'page', 'post' ) ) )                  // Check if current post type is supported.
	|| ( ! check_admin_referer( basename( __FILE__ ), 'deneb_custom_meta_box_nonce') )    // Check nonce - Security
	|| ( ! current_user_can( $post_type_object->cap->edit_post, $post_id ) ) )  // Check permission
	{
	  return $post_id;
	}

	$fields = array(
		'cansa-centre-featured-image',
	);

	foreach ( $fields as $field ) {
		$new = $_POST[ $field ];

		delete_post_meta( $post_id, $field );

		if ( '' == $new || array() == $new ) {
			return;
		} else {
			if ( ! update_post_meta ( $post_id, $field, sanitize_text_field( sanitize_key( $new ) ) ) ) {
				add_post_meta( $post_id, $field, sanitize_text_field( sanitize_key( $new ) ), true );
			}
		}
	} // end foreach
}
add_action( 'save_post', 'deneb_save_meta_box' );
