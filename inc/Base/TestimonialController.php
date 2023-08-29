<?php 
/**
 * @package  GiorgosTsikPlugin
 */
namespace Inc\Base;

use Inc\Api\SettingApi;
use Inc\Base\BaseController;
use Inc\Api\Callbacks\AdminCallbacks;

/**
* Class used to activate and deactivate the testimonial cpt tab from the dashboard.
*/
class TestimonialController extends BaseController{

	public $callbacks;

	public $settings;

	public function register(){

		/*Check if the cpt manager checkbox is checked
		  If its not return, dont show the subpage	
		 */
		$checkbox = get_option( 'testimonial_manager' );
		if(! $checkbox ) return;

		//if checkbox is checked, show the testimonial manager page

		$this->callbacks = new AdminCallbacks();

		$this->settings = new SettingApi();

		//create the new testimonial cpt.
		add_action( 'init', array( $this, 'testimonial_cpt' ) );
		

	}

	public function testimonial_cpt ()
	{
		$labels = array(
			'name' => 'Testimonials',
			'singular_name' => 'Testimonial'
		);

		$args = array(
			'labels' => $labels,
			'public' => true,
			'has_archive' => false,
			'menu_icon' => 'dashicons-testimonial',
			'exclude_from_search' => true,
			'publicly_queryable' => false,
			'supports' => array( 'title', 'editor' )
		);

		register_post_type ( 'testimonial', $args );
	}


}