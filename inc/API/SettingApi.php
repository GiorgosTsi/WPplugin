<?php 
/**
 * @package  GiorgosTsikPlugin
 */

namespace Inc\Api;

class SettingApi
{

	public $admin_pages = array();//array of pages,like 2d array


	//we dont need to add this class as a service class.
	//Admin class will call his register function.
	public function register()
	{

		if ( ! empty($this->admin_pages) ) {
			add_action( 'admin_menu', array( $this, 'addAdminMenu' ) );
		}
	}

	/**
	 * @param an array of pages
	 * @return $this for method chaining only.Its not obligatory to use it.
	 *  */
	public function addPages( array $pages )
	{
		$this->admin_pages = $pages;

		return $this;//used for method chaining.
	}


	public function addAdminMenu()
	{
		//for every page in the array, add it to the WP dashboard
		foreach ( $this->admin_pages as $page ) {

			add_menu_page( $page['page_title'], $page['menu_title'], $page['capability'], $page['menu_slug'], $page['callback'], $page['icon_url'], $page['position'] );

		}
	}
}