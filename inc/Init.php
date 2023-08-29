<?php
/**
 * @package giorgosTsikPlugin 
 */

namespace Inc;

class Init
{
	/**
	 * Store all the classes inside an array
	 * @return array Full list of classes
	 */
	public static function get_services() 
	{
		return [
			Pages\Dashboard::class, //dashboard should be instantiated first.Main page should be created,before subpages.
			Base\Enqueue::class,    //enqueues all the css and js scripts to our code
			Base\SettingLinks::class, //setting the plugin's links
			Base\CustomPostTypeController::class, //creates cpt managers subpage
			Base\PostTagFilter::class,
			Base\PageTagFilter::class,
			Base\InvertPostTagFilter::class,
			// Base\CustomTaxonomyController::class ,
			// Base\WidgetController::class,
			// Base\GalleryController::class,
			// Base\TestimonialController::class,
			// Base\TemplateController::class,
			// Base\AuthController::class,
			// Base\MembershipController::class,
			// Base\ChatController::class
		];
	}

	/**
	 * Loop through the classes, initialize them, 
	 * and call the register() method if it exists
	 * @return
	 */
	public static function register_services() 
	{
		foreach ( self::get_services() as $class ) {
			$service = self::instantiate( $class );
			if ( method_exists( $service, 'register' ) ) {
				$service->register();
			}
		}
	}

	/**
	 * Initialize the class
	 * @param  class $class    class from the services array
	 * @return class instance  new instance of the class
	 */
	private static function instantiate( $class )
	{
		$service = new $class();

		return $service;
	}
}