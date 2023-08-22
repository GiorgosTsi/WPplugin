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
	
}