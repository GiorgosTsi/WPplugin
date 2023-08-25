<?php
/**
 * @package giorgosTsikPlugin 
 */

namespace Inc\API\callbacks;



class CptCallbacks
{
	public function cptSectionManager()
	{
		echo 'Create as many Custom Post Types as you want.';
	}

	public function cptSanitize( $input )
	{
		$sanitized_input = array();

	    // Sanitize text input
	    if ( isset( $input['text_option'] ) ) {
	        $sanitized_input['text_option'] = sanitize_text_field( $input['text_option'] );
	    }

	    // Sanitize checkbox input
	    if ( isset( $input['checkbox_option'] ) ) {
	        $sanitized_input['checkbox_option'] = ( $input['checkbox_option'] === '1' ) ? '1' : '0';
	    }

	    return $sanitized_input;
	}

	public function textField( $args )
	{
		$name = $args['label_for'];
		$option_name = $args['option_name'];
		$input = get_option( $option_name );

		echo '<input type="text" class="regular-text" id="' . $name . '" name="' . $option_name . '[' . $name . ']" value="" placeholder="' . $args['placeholder'] . '">';
	}

	public function checkboxField( $args )
	{
		$name = $args['label_for'];
		$classes = $args['class'];
		$option_name = $args['option_name'];
		$checkbox = get_option( $option_name );

		echo '<input type="checkbox" name="' . $name . '" value="1" class="' . $classes . '" ' . ($checkbox ? 'checked' : '') . '>';
	}
}

