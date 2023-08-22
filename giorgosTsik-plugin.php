<?php
/**
 *@package giorgosTsikPlugin 
 */
/* 
Plugin Name: giorgosTsik Plugin
Plugin URL: http://giorgos-site.local/plugin
Description: This is my first attempt on writting a custom Plugin
Version: 1.0.0
Author: Giorgos Tsikritzakis
Author URL:
License: GPLv2 or later
Text Domain:giorgosTsik-Plugin 
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.

Copyright 2005-2015 Automattic, Inc.
*/

if( !defined('ABSPATH') ){
	die;
}

// Require once the Composer Autoload
if ( file_exists( dirname( __FILE__ ) . '/vendor/autoload.php' ) ) {
	require_once dirname( __FILE__ ) . '/vendor/autoload.php';
}

/**
 * The code that runs during plugin activation
 */
function activate_giorghs_plugin() {
	Inc\Base\Activate::activate();
}

register_activation_hook( __FILE__, 'activate_giorghs_plugin' );

/**
 * The code that runs during plugin deactivation
 */
function deactivate_giorghs_plugin() {
	Inc\Base\Deactivate::deactivate();
}

register_deactivation_hook( __FILE__, 'deactivate_giorghs_plugin' );


/**
 * Initialize all the core classes of the plugin
 */
if ( class_exists( 'Inc\\Init' ) ) {
	Inc\Init::register_services();
}



// Initial code
// use Inc\Base\Activate;
// use Inc\Base\Deactivate;
// use Inc\Init;
// use Inc\Pages\Admin;

// class GiorgosTsikPlugin
// {

// 	//Constructor:
// 	public function __construct(){
// 		add_action('init',array($this,'custom_post_type'));//call this function on init
// 	}

// 	//add action for the admin enqueue scripts
// 	public function register(){
		
// 		add_action('admin_enqueue_script',array($this,'enqueue'));
		
// 		add_action('admin_menu', array( $this , 'add_menu_pages') );

// 		add_filter('plugin_action_links_' . plugin_basename( __FILE__ ),array($this,'add_plugin_link'));
		
// 	}

// 	/**
// 	 * @param the array of action links of this plugin
// 	 * @return the new array of action links,with the new link added.
// 	 *  */
// 	public function add_plugin_link($links){
// 		$settings = '<a href="admin.php?page=giorghs_plugin">Settings</a>';
// 		array_push( $links, $settings );

// 		$about = '<a href="https://computerpro-web.com/" >About Me </a>';
// 		array_push($links,$about);
		
//     return $links;
// 	}

// 	public function add_menu_pages(){
// 		add_menu_page( 'Page Title', 'Giorghs', 'manage_options', 'giorghs_plugin', array($this,'callback_for_plugin'), 'dashicons-store', 110 );
// 	}

// 	public function callback_for_plugin(){
// 		require_once plugin_dir_path(__FILE__) . '/templates/admin.php';
// 	}

// 	public function activate(){
// 		//call the static method of activate class:
// 		  //require_once plugin_dir_path( __FILE__ ) . 'inc/Activate.php';
// 		Activate::activate();
// 	}

// 	public function custom_post_type(){

// 		$args = array(
// 									'public' => true,
// 									'label'  => 'Athlitika');
// 		register_post_type('Athlimata',$args);
// 	}

// 	/**
// 	 * Inlude custom css and js files in your plugin.
// 	 * Used for the appearence of the plugin menu for the admin only.
// 	 *  */
// 	private function enqueue(){

// 		//enqueue css 
// 		wp_enqueue_style('GiorgosStyle', plugins_url('/assets/mystyle.css',__FILE__));
// 		//enqueue script
// 		wp_enqueue_script('GiorgosScripts', plugins_url('/assets/myscript.js',__FILE__));
// 	}


// }




// if(class_exists('GiorgosTsikPlugin')){
// 	$instance = new GiorgosTsikPlugin();
// 	$instance->register();
// }

// //activation:
// /*means that on activation will use the $instance for initialization and
//   will execute the activate function of this instance*/
// register_activation_hook(__FILE__, array( $instance , 'activate' ) );

// //deactivation:
// /*means that on deactivation
//   will execute the deactivate static function of this class:*/
// register_deactivation_hook(__FILE__, array( 'Inc\Base\Deactivate' , 'deactivate' ) );

// //deletion:
// //function in uninstall hook should be static

// //register_uninstall_hook(__FILE__, array( $instance , 'delete' ));

// /*
// Instead of this uninstall hook we can create a uninstall.php file
// with the code for uninstall there,so we dont need that static function.
//  */

