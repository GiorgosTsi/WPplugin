<?php
/**
 * @package giorgosTsikPlugin 
 * Create the admin Menu,admin page etc.
 * This class will use the API setting class
 * to add menu pages.
 */

namespace Inc\Pages;

use Inc\Base\BaseController;
use Inc\API\SettingApi;



class Admin extends BaseController
{


	public $pageBuilder;

	public $pages = array(); //initialize an empty page array.

	public function __construct(){

		$this->pageBuilder = new SettingApi();

		
		/*Create the Menu pages */
		$this->pages = array(
			array(
				'page_title' => 'Giorghs Plugin', 
				'menu_title' => 'Giorghs', 
				'capability' => 'manage_options', 
				'menu_slug' => 'giorghs_plugin', 
				'callback' => 	function() { 
												require_once $this->plugin_path . '/templates/admin.php';
												 }, 
				'icon_url' => 'dashicons-store', 
				'position' => 110
			)
		);


	}

	//add action for the admin page
	public function register(){
		
		/*Using method chaining */
		$this->pageBuilder->addPages($this->pages)->register();//calls SettingApi's register method.

		/*Without using method chaining(You should have call addPages earlier): */
		//$this->pageBuilder->register();

	}

	// public function callback_for_plugin(){
	// 		require_once $this->plugin_path . '/templates/admin.php';
	// 	}

	// public function add_menu_pages(){
	// 	add_menu_page( 'Page Title', 'Giorghs', 'manage_options', 'giorghs_plugin', array($this,'callback_for_plugin'), 'dashicons-store', 110 );
	// }

	
	
}