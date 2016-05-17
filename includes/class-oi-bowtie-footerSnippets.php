<?php
// OI FOOTER Snippets

function after_footer_get_meta( $value ) {
	global $post;

	$field = get_post_meta( $post->ID, $value, true );
	if ( ! empty( $field ) ) {
		return is_array( $field ) ? stripslashes_deep( $field ) : stripslashes( wp_kses_decode_entities( $field ) );
	} else {
		return false;
	}
}

function after_footer_add_meta_box() {
	add_meta_box(
		'after_footer-after-footer',
		__( 'Footer Code', 'after_footer' ),
		'after_footer_html',
		'post',
		'normal',
		'default'
	);
	add_meta_box(
		'after_footer-after-footer',
		__( 'Footer Code', 'after_footer' ),
		'after_footer_html',
		'page',
		'normal',
		'default'
	);
}
add_action( 'add_meta_boxes', 'after_footer_add_meta_box' );

function after_footer_html( $post) {
	wp_nonce_field( '_after_footer_nonce', 'after_footer_nonce' ); ?>

	<p>
		<label for="after_footer_footercode"><?php _e( 'Insert code before the closing BODY tag', 'after_footer' ); ?></label><br>
		<textarea name="after_footer_footercode" style="width:41%; min-height:115px; margin-top:15px" id="after_footer_footercode" ><?php echo after_footer_get_meta( 'after_footer_footercode' ); ?></textarea>
	
	</p><?php
}

function after_footer_save( $post_id ) {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
	if ( ! isset( $_POST['after_footer_nonce'] ) || ! wp_verify_nonce( $_POST['after_footer_nonce'], '_after_footer_nonce' ) ) return;
	if ( ! current_user_can( 'edit_post', $post_id ) ) return;

	if ( isset( $_POST['after_footer_footercode'] ) )
		update_post_meta( $post_id, 'after_footer_footercode', esc_attr( $_POST['after_footer_footercode'] ) );
}
add_action( 'save_post', 'after_footer_save' );

/*
	Usage: after_footer_get_meta( 'after_footer_footercode' )
*/
function footer_display() {
	$the_snippets = html_entity_decode( after_footer_get_meta( 'after_footer_footercode' ) );
echo $the_snippets;
echo '
';
}
add_action( 'wp_footer', 'footer_display', 9999 );