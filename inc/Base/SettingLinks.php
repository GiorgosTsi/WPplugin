<?php
/**
 * @package giorgosTsikPlugin 
 */

namespace Inc\Base;

class SettingLinks
{
	public function register() {
		add_filter('plugin_action_links_' . PLUGIN ,array($this,'add_plugin_link'));
	}

	/**
	 * @param the array of action links of this plugin
	 * @return the new array of action links,with the new link added.
	 *  */
	public function add_plugin_link( $links ){
		$settings = '<a href="admin.php?page=giorghs_plugin">Settings</a>';
		array_push( $links, $settings );

		$about = '<a href="https://computerpro-web.com/" >About Me </a>';
		array_push($links,$about);
		
    	return $links;
	}
}