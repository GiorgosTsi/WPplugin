<?php
/**
 * @package giorgosTsikPlugin 
 */

namespace Inc\API\callbacks;

use Inc\Base\BaseController;


class AdminCallbacks extends BaseController
{

	public function adminDashboardCallback(){

		require_once $this->plugin_path . '/templates/admin.php';
	}

	public function adminCpt()
	{
		require_once $this->plugin_path . '/templates/cpt.php';
	}

	public function adminTaxonomy()
	{
		require_once $this->plugin_path . '/templates/taxonomy.php';
	}

	public function adminWidget()
	{
		require_once $this->plugin_path . '/templates/widget.php';
	}


	public function settingCallback($input){

		return $input;
	}
	
	public function sectionCallback(){
		echo 'Section 1 settings:';
	}

	public function fieldCallback(){

		$value = esc_attr( get_option( 'text1' ) );
		echo '<input type="text" class="regular-text" name="text1" value="' . $value . '" placeholder="Write Here!">';
	}

	public function fieldCallback2(){

		$value = esc_attr( get_option( 'text2' ) );
		echo '<input type="text" class="regular-text" name="text2" value="' . $value . '" placeholder="Write Here!">';
	}
}