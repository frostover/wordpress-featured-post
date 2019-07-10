<?php
namespace WPEngineFeaturedPostREST;

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://nathanonline.us
 * @since             1.0.0
 * @package           WPEngine_Featured_Post
 *
 * @wordpress-plugin
 * Plugin Name:       WPEngine Featured Post w/ REST
 * Plugin URI:        http://nathanonline.us
 * Description:       Enables users to define Posts that will be labeled as 'Featured on WPEngine Blog' which will enable them to be accessed through a REST API.
 * Version:           1.0.0
 * Author:            Nathan Corbin
 * Author URI:        http://nathanonline.us
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wpengine-featured-post
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 */
define( 'WPENGINE_FEATURED_POST_VERSION', '1.0.0' );

/**
 * Plugin text domain
 */
define( 'WPENGINE_FEATURED_POST_TEXT_DOMAIN', 'wpengine-featured-post');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wpengine-featured-post.php';

/**
 * The loader plugin class.
 *
 * This is the loader class for the plugin
 *
 * @since      1.0.0
 * @package    WPEngine_Featured_Post
 * @subpackage WPEngine_Featured_Post
 * @author     Nathan Corbin <contact@nathanonline.us>
 */
class WPEngine_Featured_Post_Plugin {

	private $plugin;

	/**
	 * Construct the plugin.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		register_activation_hook( __FILE__, array($this, 'activate_wpengine_featured_post'));
		register_deactivation_hook( __FILE__, array($this, 'deactivate_wpengine_featured_post' ));

		// Assign the private plugin and begin execution of the plugin.
		$this->plugin = new WPEngine_Featured_Post();
		$this->plugin->run();
	}

	/**
	 * The code that runs during plugin activation.
	 * This action is documented in includes/class-wpengine-featured-post-activator.php
	 */
	public function activate_wpengine_featured_post() {
		require_once plugin_dir_path( __FILE__ ) . 'includes/class-wpengine-featured-post-activator.php';
		WPEngine_Featured_Post_Activator::activate();
	}

	/**
	 * The code that runs during plugin deactivation.
	 * This action is documented in includes/class-wpengine-featured-post-deactivator.php
	 */
	public function deactivate_wpengine_featured_post() {
		require_once plugin_dir_path( __FILE__ ) . 'includes/class-wpengine-featured-post-deactivator.php';
		WPEngine_Featured_Post_Deactivator::deactivate();
	}

}

// Start the plugin
$wpengine_featured_post = new WPEngine_Featured_Post();
