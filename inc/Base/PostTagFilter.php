<?php
/**
 * @package giorgosTsikPlugin 
 */

namespace Inc\Base;

class PostTagFilter
{
	
	public function register(){

		//if this option of the plugin is not checked, return.
		$checkbox = get_option('post_tag_filter');
		if(! $checkbox ) return;

		add_action( 'restrict_manage_posts', array($this,'ar_posts_add_taxonomy_filters') );
	}


	/**
	 * Add tag filter in the post page for the admin.
	 * 
	 *  */
	public function ar_posts_add_taxonomy_filters(){
		global $typenow;

		// An array of all the taxonomyies you want to display. Use the taxonomy name or slug
		$taxonomies = array('post_tag');  

		// must set this to the post type you want the filter(s) displayed on
		if ( $typenow == 'post' ) {  // if i want filter on page or a custom_post_type i set 'page' or the slug of the cpt.

			foreach ( $taxonomies as $tax_slug ) {
			    // note: the GET variale you want, is 'tag'. simply check at URL parameter.
			    //if admin has already select a tag,get it to show it as selected in the dropbox:
				$current_tax_slug = isset( $_GET['tag'] ) ? $_GET['tag'] : false;
				$tax_obj = get_taxonomy( $tax_slug ); //get the taxonomy object => tag_taxonomy object.
				$tax_name = $tax_obj->labels->name;   //get the 'human' name => Tags
				$terms = get_terms($tax_slug);        //get all the individual tags used on the posts. i.e beef .. etc.
				
				if ( count( $terms ) > 0) {
				        // The select name must be 'tag' ONLY.
					echo "<select name='tag' id='$tax_slug' class='postform'>";
					echo "<option value=''>$tax_name</option>";
					foreach ( $terms as $term ) {
						echo '<option value=' . $term->slug, $current_tax_slug == $term->slug ? ' selected="selected"' : '','>' . $term->name .' (' . $term->count .')</option>';
					}

					echo "</select>";
				}
			}
	}
	}


}