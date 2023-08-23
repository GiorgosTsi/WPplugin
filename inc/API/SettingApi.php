<?php 
/**
 * @package  GiorgosTsikPlugin
 */

namespace Inc\Api;

class SettingApi
{

	public $admin_pages = array();//array of pages,like 2d array

	public $admin_sub_pages = array();//array of subPages,like 2d array


	/*Variables for the settings registration */

	public $settings = array();

	public $sections = array();

	public $fields = array();

	/**
	 * Method to add the admin Menu and the subMenu in the WP dashboard
	 * We dont need to add this class as a service class.
	 * Admin class who is a service class will call this register function.
	 *  */
	public function register()
	{

		// if we have pages to add , add them to the dashboard.
		if ( ! empty($this->admin_pages) ) {
			add_action( 'admin_menu', array( $this, 'addAdminMenu' ) );
		}

		// if we have settings for the settings page,add them
		if ( ! empty($this->settings) ) {
			add_action( 'admin_init', array( $this, 'registerCustomFields' ) );
		}

	}

	/**
	 * @param an array of pages
	 * @return $this , used for method chaining only.Its not obligatory to use it.
	 *  */
	public function addPages( array $pages )
	{
		$this->admin_pages = $pages;

		return $this;//used for method chaining.
	}


	/**
	 * @param an array of subpages
	 * @return $this , used for method chaining only.Its not obligatory to use it.
	 *  */
	public function addSubPages( array $subPages){

		//add all the extra input subPages
		$this->admin_sub_pages = array_merge( $this->admin_sub_pages, $subPages );

		return $this;
	}

	/**
	 * @param an array of settings
	 * @return $this , used for method chaining only.Its not obligatory to use it.
	 *  */
	public function setSettings( array $settings )
	{
		$this->settings = $settings;

		return $this;
	}


	/**
	 * @param an array of sections
	 * @return $this , used for method chaining only.Its not obligatory to use it.
	 *  */
	public function setSections( array $sections )
	{
		$this->sections = $sections;

		return $this;
	}


	/**
	 * @param an array of fields
	 * @return $this , used for method chaining only.Its not obligatory to use it.
	 *  */
	public function setFields( array $fields )
	{
		$this->fields = $fields;

		return $this;
	}


	/**
	 * This is a method which is called to declare the Main subPage.
	 * This method does not add any subPage.Its only to declare the subMenuMainPage
	 * Main subPage contains the name of the subMenu (like a title)
	 * And his callback redirects you to the main menu page.
	 * @param the title of the subMenu
	 * @return $this , used for method chaining.
	 *  */
	public function withSubPages(string $title){
		//add subMainMenuPage only if we have a main Page(Admin Menu) already

		if( empty($this->admin_pages) ) return $this;
	
		else 

			//get the main menu page
			$mainPage = $this->admin_pages[0];

			$subMainPage = array(
							array(
								'parent_slug' => $mainPage['menu_slug'], 
								'page_title' => $mainPage['page_title'], 
								'menu_title' => ($title) ? $title : $mainPage['menu_title'], 
								'capability' => $mainPage['capability'], 
								'menu_slug' => $mainPage['menu_slug'], 
								'callback' => $mainPage['callback']
							)
			);

			//add this subPage to the subPages array:
			$this->admin_sub_pages = $subMainPage;

			return $this;

	}

	public function addAdminMenu()
	{
		//for every page in the array, add it to the WP dashboard
		foreach ( $this->admin_pages as $page ) {

			add_menu_page( $page['page_title'], $page['menu_title'], $page['capability'], $page['menu_slug'], $page['callback'], $page['icon_url'], $page['position'] );

		}

		//for every subPage in the array , add it to the WP subMenu dashboard
		foreach ( $this->admin_sub_pages as $page ) {
			add_submenu_page( $page['parent_slug'], $page['page_title'], $page['menu_title'], $page['capability'], $page['menu_slug'], $page['callback'] );
		}
	}



	/**
	 * Method to create the settings field of the
	 * settings page of the plugin.
	 *  */
	public function registerCustomFields()
	{
		// register setting.Sanitize user's input and save these settings in the database.
		foreach ( $this->settings as $setting ) {
			register_setting( $setting["option_group"], $setting["option_name"], ( isset( $setting["callback"] ) ? $setting["callback"] : '' ) );
		}

		// add settings section.Create a section for this setting in the setting page.
		foreach ( $this->sections as $section ) {
			add_settings_section( $section["id"], $section["title"], ( isset( $section["callback"] ) ? $section["callback"] : '' ), $section["page"] );
		}

		// add settings field.Create custom fields(i.e text input) for every section.
		foreach ( $this->fields as $field ) {
			add_settings_field( $field["id"], $field["title"], ( isset( $field["callback"] ) ? $field["callback"] : '' ), $field["page"], $field["section"], ( isset( $field["args"] ) ? $field["args"] : '' ) );
		}
	}
}