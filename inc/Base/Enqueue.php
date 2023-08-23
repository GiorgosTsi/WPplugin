<?php
/**
 * @package giorgosTsikPlugin 
 * class to enqueue the js script and 
 * css file inside the plugin
 */

namespace Inc\Base;

use Inc\Base\BaseController;


class Enqueue extends BaseController
{
	public  function register() {
		add_action('admin_enqueue_scripts',array($this,'enqueue'));
	}

	/**
	 * Inlude custom css and js files in your plugin.
	 * Used for the appearence of the plugin menu for the admin only.
	 *  */
	public function enqueue(){

		//enqueue css 
		wp_enqueue_style('GiorgosStyle', $this->plugin_url . 'assets/mystyle.css' );
		//enqueue script
		wp_enqueue_script('GiorgosScripts', $this->plugin_url . 'assets/myscript.js');
	}
}