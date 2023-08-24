<?php 
/**
 * @package  GiorgosTsikPlugin
 */
namespace Inc\Base;

use Inc\Api\SettingApi;
use Inc\Base\BaseController;
use Inc\Api\Callbacks\AdminCallbacks;

/**
* Class used to activate and deactivate the cpt tab from the dashboard.
* Also creates the subpage for the cpt tab.
*/
class CustomPostTypeController extends BaseController{

	public $callbacks;

	public $subpages = array();

	public $settings;


	public function register(){

		/*Check if the cpt manager checkbox is checked
		  If its not return, dont show the subpage	
		 */
		$checkbox = get_option( 'cpt_manager' );
		if(! $checkbox ) return;

		//if checkbox is checked, show the cpt manager page

		$this->callbacks = new AdminCallbacks();

		$this->setSubPages();

		$this->settings = new SettingApi();

		//add subpage to the dashboard of the plugin:
		$this->settings->addSubPages($this->subpages)->register();

		add_action('init', array($this,'activate') );
	}

	public function activate(){
		register_post_type( 'giorghs_product',
			array(
				'labels' => array(
					'name' => 'Products',
					'singular_name' => 'Product'
				),
				'public' => true,
				'has_archive' => true,
			)
		);
	}

	public function setSubpages()
	{
		$this->subpages = array(
			array(
				'parent_slug' => 'giorghs_plugin', 
	 			'page_title' => 'Custom Post Types', 
	 			'menu_title' => 'CPT', 
	 			'capability' => 'manage_options', 
	 			'menu_slug' => 'giorghs_cpt', //url
	 			'callback' => array($this->callbacks, 'adminCpt')
			)
		);
	}



}