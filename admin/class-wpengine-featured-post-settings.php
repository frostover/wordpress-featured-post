<?php
namespace WPEngineFeaturedPostREST\Admin;

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://nathanonline.us
 * @since      1.0.0
 *
 * @package    WPEngine_Featured_Post
 * @subpackage WPEngine_Featured_Post/Admin
 * @author     Nathan Corbin <contact@nathanonline.us>
 */

class WPEngine_Featured_Post_Settings {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($plugin_name) {

		$this->plugin_name = $plugin_name;
		
	}

	/**
	 * Registers the meta checkbox for the post page
	 *
	 * @since   1.0.0
	 */
	public function load_featured_post_meta() {
		// Enqueue featured checkbox meta
		wp_enqueue_script(
			'wpengine-featured-post',
			plugins_url( '/js/wpengine-featured-post.js', __FILE__ ),
			[ 'wp-element', 'wp-components', 'wp-i18n', 'wp-plugins', 'wp-edit-post', 'wp-data' ],
			filemtime( plugin_dir_path( __FILE__ ) . 'admin/js/wpengine-featured-post.js' ) 
		);

		// Enqueue the styling for page template display
		wp_enqueue_style(
			'wpengine-featured-post-css',
			plugins_url( '/css/wpengine-featured-post.css', __FILE__ )
		);
	}

	/**
	 * Init the meta data for the featured post checkbox. Used by JS files as well.
	 *  
	 * @since   1.0.0
	 */
	public function load_meta_data() {
		register_meta('post', '_wpengine_featured_post_meta', array(
			'show_in_rest' => true,
			'type' => 'integer',
			'single' => true,
			'sanitize_callback' => 'sanitize_text_field',
			'auth_callback' => function() { 
				return current_user_can('edit_posts');
			}
		));
	}

	/**
	 * Load custom filter above the posts list view.
	 * 
	 * @param  array $views
	 * @return array
	 */
	public function load_custom_post_filter($views) {
		
		//Query the featured post media count
		$args = array(
			'meta_query' => array(
				array(
					'key' => '_wpengine_featured_post_meta',
					'value' => '1',
					'compare' => '=',
					'order' => 'desc',
					'orderby' => 'date',
				)
			)
		);
		$query = new \WP_Query($args);

		//Build the url for users to click on the posts page
		$url = admin_url('edit.php?post_type=post&wpengine-featured=1');
		$views['wpengine-featured-post'] = "<a href=\"$url\">WPEngine Featured ($query->found_posts)</a>";

		return $views;
	}

	/**
	 * Custom functionality to handle parsing featured post query
	 * 
	 * @param  array $query
	 * @return array
	 */
	public function load_custom_post_filter_query($query) {
		//Check if they are querying for the wpengine-filter
		if (is_admin() && 
			isset($_GET['post_type']) &&
			$_GET['post_type'] == 'post' &&
			isset( $_GET['wpengine-featured'] ) && 
			$_GET['wpengine-featured'] != '') {

			$query->query_vars['meta_key'] = '_wpengine_featured_post_meta';
			$query->query_vars['meta_value'] = '1';
			$query->query_vars['meta_compare'] = '=';
		}
	}

}




