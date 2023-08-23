<?php
/**
 * @package giorgosTsikPlugin 
 * Create the admin Menu,admin page etc.
 * This class will use the API setting class
 * to add menu pages.
 */

namespace Inc\Pages;

use Inc\API\callbacks\AdminCallbacks;
use Inc\Base\BaseController;
use Inc\API\SettingApi;



class Admin extends BaseController
{


	public $pageBuilder;

	public $pages = array(); //initialize an empty page array.

	public $subpages = array();

	public $callbacks;

	//add action for the admin page
	public function register(){

		$this->callbacks =  new AdminCallbacks();
		
		$this->pageBuilder = new SettingApi();

		$this->setPages();

		$this->setSubPages();

		$this->setSettings();

		$this->setSections();

		$this->setFields();

		/*Using method chaining */
		$this->pageBuilder->addPages($this->pages)->withSubPages("Menu")->addSubPages($this->subpages)->register();//calls SettingApi's register method.

		/*Without using method chaining(You should have call addPages earlier): */
		//$this->pageBuilder->register();

	}

	/**
	 * Method to set the Pages.
	 *  */
	public function setPages(){

		/*Create the Menu pages */
		$this->pages = array(
			array(
				'page_title' => 'Giorghs Plugin', 
				'menu_title' => 'Giorghs', 
				'capability' => 'manage_options', 
				'menu_slug' => 'giorghs_plugin', 
				'callback' => 	array($this->callbacks, 'adminDashboardCallback'), 
				'icon_url' => 'dashicons-store', 
				'position' => 110
			)
		);

	}


	/**
	 * Method to set the subPages.
	 *  */
	public function setSubPages(){

		/*Create the subMenu: */

		$this->subpages = array(
			array(
				'parent_slug' => 'giorghs_plugin', 
				'page_title' => 'Custom Post Types', 
				'menu_title' => 'CPT', 
				'capability' => 'manage_options', 
				'menu_slug' => 'giorghs_cpt', //url
				'callback' => array($this->callbacks, 'adminCpt')
			),
			array(
				'parent_slug' => 'giorghs_plugin', 
				'page_title' => 'Custom Taxonomies', 
				'menu_title' => 'Taxonomies', 
				'capability' => 'manage_options', 
				'menu_slug' => 'giorghs_taxonomies', //url
				'callback' => array($this->callbacks, 'adminTaxonomy')
			),
			array(
				'parent_slug' => 'giorghs_plugin', 
				'page_title' => 'Custom Widgets', 
				'menu_title' => 'Widgets', 
				'capability' => 'manage_options', 
				'menu_slug' => 'giorghs_widgets', //url
				'callback' => array($this->callbacks, 'adminWidget') 
			)
		);

	}


	public function setSettings(){

		$settings = array(

						array(
							"option_group" => 'giorghs_option_group',
							"option_name"  => 'text1',
							"callback"     => array($this->callbacks ,'settingCallback')
						),
						array(
							"option_group" => 'giorghs_option_group',
							"option_name"  => 'text2'
						)
		);

		//set the settings of the SettingApi class
		$this->pageBuilder->setSettings($settings);

	}


	public function setSections(){

		$sections = array(
						array(
							"id"       => 'set1_id',                                  //The id of the section in the section page
							"title"    => 'Settings',								  //Title printed for the section
							"callback" => array($this->callbacks ,'sectionCallback'), //Callback function when section completed
							"page"     => 'giorghs_plugin'                            //main page slug

						)
		);

		//set the sections of the SettingApi class
		$this->pageBuilder->setSections($sections);
		
	}


	public function setFields(){

		$fields = array(
						array(
						'id' 	   => 'text1',                                   //id of the field
						'title'    => 'Text Example',							 //title printed of this field
						'callback' => array( $this->callbacks, 'fieldCallback' ),//callback func
						'page'     => 'giorghs_plugin',							 //main page slug
						'section'  => 'set1_id',                                 //section's id
						'args'     => array(                                     //args of the field
									'label_for' => 'text1',
									'class' => 'example-class'
								)
					    ),

					    array(
						'id' 	   => 'text2',                                    //id of the field
						'title'    => 'Fname',							          //title printed of this field
						'callback' => array( $this->callbacks, 'fieldCallback2' ),//callback func
						'page'     => 'giorghs_plugin',							  //main page slug
						'section'  => 'set1_id',                                  //section's id
						'args'     => array(                                      //args of the field
									'label_for' => 'text2',
									'class' => 'example-class'
								)
					    )
		);

		//set the fields of the SettingApi class
		$this->pageBuilder->setFields($fields);

	}
	
}