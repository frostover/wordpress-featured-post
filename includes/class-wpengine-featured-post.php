<?php
namespace WPEngineFeaturedPostREST;

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://nathanonline.us
 * @since      1.0.0
 *
 * @package    WPEngine_Featured_Post
 * @subpackage WPEngine_Featured_Post/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    WPEngine_Featured_Post
 * @subpackage WPEngine_Featured_Post/includes
 * @author     Nathan Corbin <contact@nathanonline.us>
 */
class WPEngine_Featured_Post {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      WPEngine_Featured_Post_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if(defined('WPENGINE_FEATURED_POST_VERSION')) {
			$this->version = WPENGINE_FEATURED_POST_VERSION;
		} else {
			$this->version = '1.0.0';
		}

		if(!defined('WPENGINE_FEATURED_POST_TEXT_DOMAIN')) {
			define( 'WPENGINE_FEATURED_POST_TEXT_DOMAIN', 'wpengine-featured-post');
		}

		$this->plugin_name = 'wpengine-featured-post';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_REST_API_hooks();
		$this->define_public_hooks();
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - WPEngine_Featured_Post_Loader. Orchestrates the hooks of the plugin.
	 * - WPEngine_Featured_Post_i18n. Defines internationalization functionality.
	 * - WPEngine_Featured_Post_Admin. Defines all hooks for the admin area.
	 * - WPEngine_Featured_Post_Settings. Loads custom WooCommerce settings.
	 * - WPEngine_Featured_Post_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wpengine-featured-post-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wpengine-featured-post-i18n.php';

		/**
		 * The class establishes the settings
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-wpengine-featured-post-settings.php';

		/**
		 * The class establishes the REST API
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'api/class-wpengine-featured-post-rest.php';

		$this->loader = new WPEngine_Featured_Post_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the WPEngine_Featured_Post_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new WPEngine_Featured_Post_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {
		$admin = new Admin\WPEngine_Featured_Post_Settings($this->get_plugin_name());

		// Add in meta content for post type
		add_action('init', array($admin, 'load_meta_data'));

		// Add in the page editor specific js and styling
		add_action('enqueue_block_editor_assets', array($admin, 'load_featured_post_meta'));

		// Add in filter for Posts filtering by featured type
		add_filter('views_edit-post', array($admin, 'load_custom_post_filter'));

		// Add in filter for parsing custom formatting for featured type
		add_filter('parse_query', array($admin, 'load_custom_post_filter_query'));
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

	}

	/**
	 * Register all of the hooks related to the REST API functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_REST_API_hooks() {
		$api = new API\WPEngine_Featured_Post_API($this->get_plugin_name());

		// Add in meta content for post type
		add_action('init', array($api, 'route_featured_post'));
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    WPEngine_Featured_Post_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}
}