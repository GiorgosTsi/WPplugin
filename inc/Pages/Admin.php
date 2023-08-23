<?php
/**
 * @package giorgosTsikPlugin 
 * Create the admin Menu,admin page etc.
 * This class will use the API setting class
 * to add menu pages.
 */

namespace Inc\Pages;

use Inc\API\callbacks\ManagerCallbacks;
use Inc\API\callbacks\AdminCallbacks;
use Inc\Base\BaseController;
use Inc\API\SettingApi;



class Admin extends BaseController
{


	public $pageBuilder;

	public $pages = array(); //initialize an empty page array.

	public $subpages = array();

	public $callbacks;

	public $callbacks_mngr;

	//add action for the admin page
	public function register(){

		$this->callbacks =  new AdminCallbacks();

		$this->callbacks_mngr = new ManagerCallbacks();
		
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
		/*
		Setting format:
			arg1) string, the option group 
			arg2) the option name.
			arg3) callback function which is gonna be called when the get_option(option_name) method is called.
		 */

		$settings = array(
			array(
				'option_group' => 'giorghs_option_group',
				'option_name' => 'cpt_manager',
				'callback' => array( $this->callbacks_mngr, 'checkboxSanitize' )
			),
			array(
				'option_group' => 'giorghs_option_group',
				'option_name' => 'taxonomy_manager',
				'callback' => array( $this->callbacks_mngr, 'checkboxSanitize' )
			),
			array(
				'option_group' => 'giorghs_option_group',
				'option_name' => 'media_widget',
				'callback' => array( $this->callbacks_mngr, 'checkboxSanitize' )
			),
			array(
				'option_group' => 'giorghs_option_group',
				'option_name' => 'gallery_manager',
				'callback' => array( $this->callbacks_mngr, 'checkboxSanitize' )
			),
			array(
				'option_group' => 'giorghs_option_group',
				'option_name' => 'testimonial_manager',
				'callback' => array( $this->callbacks_mngr, 'checkboxSanitize' )
			),
			array(
				'option_group' => 'giorghs_option_group',
				'option_name' => 'templates_manager',
				'callback' => array( $this->callbacks_mngr, 'checkboxSanitize' )
			),
			array(
				'option_group' => 'giorghs_option_group',
				'option_name' => 'login_manager',
				'callback' => array( $this->callbacks_mngr, 'checkboxSanitize' )
			),
			array(
				'option_group' => 'giorghs_option_group',
				'option_name' => 'membership_manager',
				'callback' => array( $this->callbacks_mngr, 'checkboxSanitize' )
			),
			array(
				'option_group' => 'giorghs_option_group',
				'option_name' => 'chat_manager',
				'callback' => array( $this->callbacks_mngr, 'checkboxSanitize' )
			)
		);

		//set the settings of the SettingApi class
		$this->pageBuilder->setSettings($settings);

	}


	public function setSections(){
		/*
		Section format:
			arg1) id, the id of the section 
			arg2) Title printed for the section
			arg3) Callback function when section is printed
			arg4) main page slug
		 */

		$sections = array(
			array(
				'id' => 'giorghs_admin_index',
				'title' => 'Settings Manager',
				'callback' => array( $this->callbacks_mngr, 'adminSectionManager' ),
				'page' => 'giorghs_plugin'
			)
		);


		//set the sections of the SettingApi class
		$this->pageBuilder->setSections($sections);
		
	}


	public function setFields(){

		/*
		Fields format:
			arg1) id, the id of the field
			arg2) title printed of this field
			arg3) callback func
			arg4) main page slug
			arg5) to id tou section sto opoio anhkei
			arg6) args of callback function.We need 'label for' to be identical with the option_name.
				  so inside the checkboxField function to know if the checkbox is checked or no.
		 */

		$fields = array(
			array(
				'id' => 'cpt_manager',
				'title' => 'Activate CPT Manager',
				'callback' => array( $this->callbacks_mngr, 'checkboxField' ),
				'page' => 'giorghs_plugin',
				'section' => 'giorghs_admin_index',
				'args' => array(
					'label_for' => 'cpt_manager',
					'class' => 'ui-toggle'
				)
			),
			array(
				'id' => 'taxonomy_manager',
				'title' => 'Activate Taxonomy Manager',
				'callback' => array( $this->callbacks_mngr, 'checkboxField' ),
				'page' => 'giorghs_plugin',
				'section' => 'giorghs_admin_index',
				'args' => array(
					'label_for' => 'taxonomy_manager',
					'class' => 'ui-toggle'
				)
			),
			array(
				'id' => 'media_widget',
				'title' => 'Activate Media Widget',
				'callback' => array( $this->callbacks_mngr, 'checkboxField' ),
				'page' => 'giorghs_plugin',
				'section' => 'giorghs_admin_index',
				'args' => array(
					'label_for' => 'media_widget',
					'class' => 'ui-toggle'
				)
			),
			array(
				'id' => 'gallery_manager',
				'title' => 'Activate Gallery Manager',
				'callback' => array( $this->callbacks_mngr, 'checkboxField' ),
				'page' => 'giorghs_plugin',
				'section' => 'giorghs_admin_index',
				'args' => array(
					'label_for' => 'gallery_manager',
					'class' => 'ui-toggle'
				)
			),
			array(
				'id' => 'testimonial_manager',
				'title' => 'Activate Testimonial Manager',
				'callback' => array( $this->callbacks_mngr, 'checkboxField' ),
				'page' => 'giorghs_plugin',
				'section' => 'giorghs_admin_index',
				'args' => array(
					'label_for' => 'testimonial_manager',
					'class' => 'ui-toggle'
				)
			),
			array(
				'id' => 'templates_manager',
				'title' => 'Activate Templates Manager',
				'callback' => array( $this->callbacks_mngr, 'checkboxField' ),
				'page' => 'giorghs_plugin',
				'section' => 'giorghs_admin_index',
				'args' => array(
					'label_for' => 'templates_manager',
					'class' => 'ui-toggle'
				)
			),
			array(
				'id' => 'login_manager',
				'title' => 'Activate Ajax Login/Signup',
				'callback' => array( $this->callbacks_mngr, 'checkboxField' ),
				'page' => 'giorghs_plugin',
				'section' => 'giorghs_admin_index',
				'args' => array(
					'label_for' => 'login_manager',
					'class' => 'ui-toggle'
				)
			),
			array(
				'id' => 'membership_manager',
				'title' => 'Activate Membership Manager',
				'callback' => array( $this->callbacks_mngr, 'checkboxField' ),
				'page' => 'giorghs_plugin',
				'section' => 'giorghs_admin_index',
				'args' => array(
					'label_for' => 'membership_manager',
					'class' => 'ui-toggle'
				)
			),
			array(
				'id' => 'chat_manager',
				'title' => 'Activate Chat Manager',
				'callback' => array( $this->callbacks_mngr, 'checkboxField' ),
				'page' => 'giorghs_plugin',
				'section' => 'giorghs_admin_index',
				'args' => array(
					'label_for' => 'chat_manager',
					'class' => 'ui-toggle'
				)
			)
		);

		//set the fields of the SettingApi class
		$this->pageBuilder->setFields($fields);

	}
	
}