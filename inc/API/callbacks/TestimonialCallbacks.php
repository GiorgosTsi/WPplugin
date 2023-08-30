<?php
/**
 * @package giorgosTsikPlugin 
 */

namespace Inc\API\callbacks;

use Inc\Base\BaseController;

class TestimonialCallbacks extends BaseController
{
	public function shortcodePage(){

		require_once("$this->plugin_path/templates/testimonial.php");	
	}
	

}