<?php

/**
 * Register all actions and filters for the plugin
 *
 * @link       http://onlineimage.com
 * @since      1.0.0
 *
 * @package    Oi_Bowtie
 * @subpackage Oi_Bowtie/includes
 */

/**
 * Register all actions and filters for the plugin.
 *
 * Maintain a list of all hooks that are registered throughout
 * the plugin, and register them with the WordPress API. Call the
 * run function to execute the list of actions and filters.
 *
 * @package    Oi_Bowtie
 * @subpackage Oi_Bowtie/includes
 * @author     Langone-Saul <langone@onlineimage.com>
 */
class Oi_Bowtie_Loader {

	/**
	 * The array of actions registered with WordPress.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      array    $actions    The actions registered with WordPress to fire when the plugin loads.
	 */
	protected $actions;

	/**
	 * The array of filters registered with WordPress.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      array    $filters    The filters registered with WordPress to fire when the plugin loads.
	 */
	protected $filters;

	/**
	 * Initialize the collections used to maintain the actions and filters.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->actions = array();
		$this->filters = array();

	}

	/**
	 * Add a new action to the collection to be registered with WordPress.
	 *
	 * @since    1.0.0
	 * @param    string               $hook             The name of the WordPress action that is being registered.
	 * @param    object               $component        A reference to the instance of the object on which the action is defined.
	 * @param    string               $callback         The name of the function definition on the $component.
	 * @param    int                  $priority         Optional. he priority at which the function should be fired. Default is 10.
	 * @param    int                  $accepted_args    Optional. The number of arguments that should be passed to the $callback. Default is 1.
	 */
	public function add_action( $hook, $component, $callback, $priority = 10, $accepted_args = 1 ) {
		$this->actions = $this->add( $this->actions, $hook, $component, $callback, $priority, $accepted_args );
	}

	/**
	 * Add a new filter to the collection to be registered with WordPress.
	 *
	 * @since    1.0.0
	 * @param    string               $hook             The name of the WordPress filter that is being registered.
	 * @param    object               $component        A reference to the instance of the object on which the filter is defined.
	 * @param    string               $callback         The name of the function definition on the $component.
	 * @param    int                  $priority         Optional. he priority at which the function should be fired. Default is 10.
	 * @param    int                  $accepted_args    Optional. The number of arguments that should be passed to the $callback. Default is 1
	 */
	public function add_filter( $hook, $component, $callback, $priority = 10, $accepted_args = 1 ) {
		$this->filters = $this->add( $this->filters, $hook, $component, $callback, $priority, $accepted_args );
	}

	/**
	 * A utility function that is used to register the actions and hooks into a single
	 * collection.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @param    array                $hooks            The collection of hooks that is being registered (that is, actions or filters).
	 * @param    string               $hook             The name of the WordPress filter that is being registered.
	 * @param    object               $component        A reference to the instance of the object on which the filter is defined.
	 * @param    string               $callback         The name of the function definition on the $component.
	 * @param    int                  $priority         The priority at which the function should be fired.
	 * @param    int                  $accepted_args    The number of arguments that should be passed to the $callback.
	 * @return   array                                  The collection of actions and filters registered with WordPress.
	 */
	private function add( $hooks, $hook, $component, $callback, $priority, $accepted_args ) {

		$hooks[] = array(
			'hook'          => $hook,
			'component'     => $component,
			'callback'      => $callback,
			'priority'      => $priority,
			'accepted_args' => $accepted_args
		);

		return $hooks;

	}

	/**
	 * Register the filters and actions with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {

		foreach ( $this->filters as $hook ) {
			add_filter( $hook['hook'], array( $hook['component'], $hook['callback'] ), $hook['priority'], $hook['accepted_args'] );
		}

		foreach ( $this->actions as $hook ) {
			add_action( $hook['hook'], array( $hook['component'], $hook['callback'] ), $hook['priority'], $hook['accepted_args'] );
		}

	}


}

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


