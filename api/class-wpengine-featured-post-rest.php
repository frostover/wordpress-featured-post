<?php
namespace WPEngineFeaturedPostREST\API;

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

class WPEngine_Featured_Post_API {

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
	 * Registers the REST API Route to get the top 5 featured posts
	 * 
	 * @since  1.0.0
	 */
	public function route_featured_post() {
		register_rest_route('wp/v2', '/posts/wpengine-featured', array(
			'methods' => 'GET',
			'callback' => array($this, 'route_featured_post_callback'),
		));
	}

	/**
	 * Returns back the JSON data for the posts/featured url
	 *
	 * @return array The list of posts that are wpengine featured.
	 */
	public function route_featured_post_callback() {
		$args = array(
			'meta_query' => array(
				array(
					'key' => '_wpengine_featured_post_meta',
					'value' => '1',
					'compare' => '=',
					'posts_per_page' => '5',
					'nopaging' => true,
					'order' => 'desc',
					'orderby' => 'date',
					'post_status' => 'publish',
				)
			)
		);

		$query = new \WP_Query($args);
		return $query->posts;
	}

}