<?php
// OI Header Snippets

function before_head_get_meta( $value ) {
	global $post;

	$field = get_post_meta( $post->ID, $value, true );
	if ( ! empty( $field ) ) {
		return is_array( $field ) ? stripslashes_deep( $field ) : stripslashes( wp_kses_decode_entities( $field ) );
	} else {
		return false;
	}
}

function before_head_add_meta_box() {
	add_meta_box(
		'before_head-before-head',
		__( 'Header Code', 'before_head' ),
		'before_head_html',
		'post',
		'normal',
		'default'
	);
	add_meta_box(
		'before_head-before-head',
		__( 'Header Code', 'before_head' ),
		'before_head_html',
		'page',
		'normal',
		'default'
	);
}
add_action( 'add_meta_boxes', 'before_head_add_meta_box' );

function before_head_html( $post) {
	wp_nonce_field( '_before_head_nonce', 'before_head_nonce' ); ?>

	<p>
		<label for="before_head_headercode"><?php _e( 'Insert code before the closing HEAD tag', 'before_head' ); ?></label><br>
		<textarea name="before_head_headercode" style="width:41%; min-height:115px; margin-top:15px" id="before_head_headercode" ><?php echo before_head_get_meta( 'before_head_headercode' ); ?></textarea>
	
	</p><?php
}

function before_head_save( $post_id ) {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
	if ( ! isset( $_POST['before_head_nonce'] ) || ! wp_verify_nonce( $_POST['before_head_nonce'], '_before_head_nonce' ) ) return;
	if ( ! current_user_can( 'edit_post', $post_id ) ) return;

	if ( isset( $_POST['before_head_headercode'] ) )
		update_post_meta( $post_id, 'before_head_headercode', esc_attr( $_POST['before_head_headercode'] ) );
}
add_action( 'save_post', 'before_head_save' );

/*
	Usage: before_head_get_meta( 'before_head_headercode' )
*/
function header_display() {
	$the_snippets = html_entity_decode( before_head_get_meta( 'before_head_headercode' ) );
echo $the_snippets;
echo '
';
}
add_action( 'wp_head', 'header_display', 12 );