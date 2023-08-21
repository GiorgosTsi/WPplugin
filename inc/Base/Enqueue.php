<?php
/**
 * @package giorgosTsikPlugin 
 * class to enqueue the js script and 
 * css file inside the plugin
 */

namespace Inc\Base;

class Enqueue
{
	public  function register() {
		add_action('admin_enqueue_script',array($this,'enqueue'));
	}

	/**
	 * Inlude custom css and js files in your plugin.
	 * Used for the appearence of the plugin menu for the admin only.
	 *  */
	private function enqueue(){

		//enqueue css 
		wp_enqueue_style('GiorgosStyle', PLUGIN_URL . 'assets/mystyle.css' );
		//enqueue script
		wp_enqueue_script('GiorgosScripts', PLUGIN_URL . 'assets/myscript.js');
	}
}