<?php
/**
 * @package giorgosTsikPlugin 
 * Create the admin Menu,admin page etc.
 */

namespace Inc\Pages;

class Admin
{

	//add action for the admin page
	public function register(){
		
		add_action('admin_menu', array( $this , 'add_menu_pages') );

	}

	public function add_menu_pages(){
		add_menu_page( 'Page Title', 'Giorghs', 'manage_options', 'giorghs_plugin', array($this,'callback_for_plugin'), 'dashicons-store', 110 );
	}

	public function callback_for_plugin(){
		require_once PLUGIN_PATH . '/templates/admin.php';
	}
	
}