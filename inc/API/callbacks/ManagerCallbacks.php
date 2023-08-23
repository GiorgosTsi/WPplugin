<?php 
/**
 * @package  giorgosTsikPlugin
 * Class to manage the callbacks of the settings page.
 */
namespace Inc\Api\Callbacks;

use Inc\Base\BaseController;

class ManagerCallbacks extends BaseController
{
	public function checkboxSanitize( $input )
	{
		return ( isset($input) ? true : false );
	}

	public function adminSectionManager()
	{
		echo 'Manage the Sections and Features of this Plugin by activating the checkboxes from the following list.';
	}

	public function checkboxField( $args )
	{
		$name = $args['label_for'];
		$classes = $args['class'];
		$checkbox = get_option( $name );
		echo '<input type="checkbox" name="' . $name . '" value="1" class="' . $classes . '" ' . ($checkbox ? 'checked' : '') . '>';
	}
}