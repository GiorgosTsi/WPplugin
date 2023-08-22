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

	public $subpages = array();

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
												echo " <h1>Main Page </h1>";
												//require_once $this->plugin_path . '/templates/admin.php';
												 }, 
				'icon_url' => 'dashicons-store', 
				'position' => 110
			)
		);



		/*Create the subMenu: */

		$this->subpages = array(
			array(
				'parent_slug' => 'giorghs_plugin', 
				'page_title' => 'Custom Post Types', 
				'menu_title' => 'CPT', 
				'capability' => 'manage_options', 
				'menu_slug' => 'giorghs_cpt', //url
				'callback' => function() { echo '<h1>CPT Manager</h1>'; }
			),
			array(
				'parent_slug' => 'giorghs_plugin', 
				'page_title' => 'Custom Taxonomies', 
				'menu_title' => 'Taxonomies', 
				'capability' => 'manage_options', 
				'menu_slug' => 'giorghs_taxonomies', //url
				'callback' => function() { echo '<h1>Taxonomies Manager</h1>'; }
			),
			array(
				'parent_slug' => 'giorghs_plugin', 
				'page_title' => 'Custom Widgets', 
				'menu_title' => 'Widgets', 
				'capability' => 'manage_options', 
				'menu_slug' => 'giorghs_widgets', //url
				'callback' => function() { echo '<h1>Widgets Manager</h1>'; }
			)
		);



	}

	//add action for the admin page
	public function register(){
		
		/*Using method chaining */
		$this->pageBuilder->addPages($this->pages)->withSubPages("Menu")->addSubPages($this->subpages)->register();//calls SettingApi's register method.

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