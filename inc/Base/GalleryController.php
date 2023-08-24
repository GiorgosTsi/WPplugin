<?php 
/**
 * @package  GiorgosTsikPlugin
 */
namespace Inc\Base;

use Inc\Api\SettingApi;
use Inc\Base\BaseController;
use Inc\Api\Callbacks\AdminCallbacks;

/**
* Class used to activate and deactivate the taxonomy tab from the dashboard.
* Also creates the subpage for the taxonomy tab.
*/
class GalleryController extends BaseController{

	public $callbacks;

	public $subpages = array();

	public $settings;


	public function register(){

		/*Check if the cpt manager checkbox is checked
		  If its not return, dont show the subpage	
		 */
		$checkbox = get_option( 'gallery_manager' );
		if(! $checkbox ) return;

		//if checkbox is checked, show the cpt manager page

		$this->callbacks = new AdminCallbacks();

		$this->setSubPages();

		$this->settings = new SettingApi();

		//add subpage to the dashboard of the plugin:
		$this->settings->addSubPages($this->subpages)->register();

	}

	public function setSubpages()
	{
		$this->subpages = array(
			array(
				'parent_slug' => 'giorghs_plugin', 
	 			'page_title' => 'Gallery Manager', 
	 			'menu_title' => 'Gallery Manager', 
	 			'capability' => 'manage_options', 
	 			'menu_slug' => 'giorghs_gallery', //url
	 			'callback' => array($this->callbacks, 'adminGallery')
			)
		);
	}



}