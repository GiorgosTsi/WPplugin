<?php 
/**
 * @package  giorgosTsikPlugin
 * We create that parent class, to define here
 * the constants we defined in the main file.
 * This class will be extended by any class who
 * needs any of this constants.
 */
namespace Inc\Base;

class BaseController
{

	public $plugin_path;

	public $plugin_url;

	public $plugin;

	public $managers = array();

	public function __construct() {
		$this->plugin_path = plugin_dir_path( dirname( __FILE__, 2 ) );
		$this->plugin_url = plugin_dir_url( dirname( __FILE__, 2 ) );
		$this->plugin = plugin_basename( dirname( __FILE__, 3 ) ). '/giorgosTsik-plugin.php';

		/*Used to avoid repetition on Admin.php while adding settings. */
		$this->managers = array(
			'cpt_manager' => 'Activate CPT Manager',
			'post_tag_filter'=>'Tag Filter in Posts',
			'page_tag_filter'=>'Tag Filter on Pages',
			'taxonomy_manager' => 'Activate Taxonomy Manager',
			'media_widget' => 'Activate Widget Manager',
			'gallery_manager' => 'Activate Gallery Manager',
			'testimonial_manager' => 'Activate Testimonial Manager',
			'templates_manager' => 'Activate Templates Manager',
			'login_manager' => 'Activate Ajax Login/Signup',
			'membership_manager' => 'Activate Membership Manager',
			'chat_manager' => 'Activate Chat Manager'
		);
	}
}