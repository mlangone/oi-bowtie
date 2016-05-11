<?php
// OI Seo 
function tes_mb_create() {
 
    add_meta_box(
        'tes-meta', 
        'Search Engine Listing', 
        'tes_mb_function', 
        'post', 
        'normal', 
        'high'
    );
 
    add_meta_box(
        'tes-meta', 
        'Search Engine Listing', 
        'tes_mb_function', 
        'page', 
        'normal', 
        'high'
    );
}
add_action('add_meta_boxes', 'tes_mb_create');
function tes_mb_function($post) {
 
    //retrieve the metadata values if they exist
    $tes_meta_title = get_post_meta( $post->ID, '_tes_meta_title', true );
    $tes_meta_description = get_post_meta( $post->ID, '_tes_meta_description', true );
 
    // Add an nonce field so we can check for it later when validating
    wp_nonce_field( 'tes_inner_custom_box', 'tes_inner_custom_box_nonce' );
 
    echo '<div style="margin: 10px 100px; text-align: center">
    <table>
        <tr>
            <td><strong>Title Tag:</strong></td><td>
            <input style="padding: 6px 4px; width: 300px" type="text" name="tes_meta_title" value="' . esc_attr($tes_meta_title) . '" />
            </td>
        </tr>
        <tr>
            <td><strong>Meta Description:</strong></td><td>           <textarea  rows="3" cols="50" name="tes_meta_description">' . esc_attr($tes_meta_description) . '</textarea></td>
        </tr>
    </table>
</div>';
 
}
function tes_mb_save_data($post_id) {
 
    /*
     * We need to verify this came from the our screen and with proper authorization,
     * because save_post can be triggered at other times.
     */
 
    // Check if our nonce is set.
    if ( ! isset( $_POST['tes_inner_custom_box_nonce'] ) )
        return $post_id;
 
    $nonce = $_POST['tes_inner_custom_box_nonce'];
 
    // Verify that the nonce is valid.
    if ( ! wp_verify_nonce( $nonce, 'tes_inner_custom_box' ) )
        return $post_id;
 
    // If this is an autosave, our form has not been submitted, so we don't want to do anything.
    if ( defined( 'DOING_AUTOSAVE') && DOING_AUTOSAVE )
        return $post_id;
 
    // Check the user's permissions.
    if ( 'page' == $_POST['post_type'] ) {
 
        if ( ! current_user_can( 'edit_page', $post_id ) )
            return $post_id;
    } else {
 
        if ( ! current_user_can( 'edit_post', $post_id ) )
            return $post_id;
    }
 
    /* OK, its safe for us to save the data now. */
 
    // If old entries exist, retrieve them
    $old_title = get_post_meta( $post_id, '_tes_meta_title', true );
    $old_description = get_post_meta( $post_id, '_tes_meta_description', true );
 
    // Sanitize user input.
    $title = sanitize_text_field( $_POST['tes_meta_title'] );
    $description = sanitize_text_field( $_POST['tes_meta_description'] );
 
    // Update the meta field in the database.
    update_post_meta( $post_id, '_tes_meta_title', $title, $old_title );
    update_post_meta( $post_id, '_tes_meta_description', $description, $old_description );
}
add_action( 'save_post', 'tes_mb_save_data' );
add_filter( 'wp_title', 'ml_display_title', 20, 2 );
function tes_mb_display() {
 
    global $post;
     
    // retrieve the metadata values if they exist
    $tes_meta_title = get_post_meta( $post->ID, '_tes_meta_title', true );
    $tes_meta_description = get_post_meta( $post->ID, '_tes_meta_description', true );
// Echo out what we are doing 
echo '<!-- OI Seo Meta -->
<meta name="title" content="' . $tes_meta_title . '" />
<meta name="description" content="' . $tes_meta_description . '" />
<meta property="og:title" content="' . $tes_meta_title . '" />
<meta property="og:description" content="' . $tes_meta_description . '" />
<!-- /OI SEO -->
    ';
}
add_action( 'wp_head', 'tes_mb_display', 2 );