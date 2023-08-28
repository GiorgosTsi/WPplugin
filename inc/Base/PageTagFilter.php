<?php
/**
 * @package giorgosTsikPlugin 
 * Add tag filter in the 'Pages' page for the admin.
 * Firstly we have to add custom taxonomy.
 * Pages do not have tag filter by default.
 */

namespace Inc\Base;

class PageTagFilter
{
	
	public function register(){

		//if this option of the plugin is not checked, return.
		$checkbox = get_option('page_tag_filter');
		if(! $checkbox ) return;

		/*Firstly create custom taxonomy for the pages: */
		add_action('init',array($this , 'custom_taxonomy_for_pages' ) );

		/*Then add the filter to this new taxonomy */


		/*There is not equivalent hook for pages, like restrict_manage_pages*/
		add_action( 'restrict_manage_posts', array($this,'ar_pages_add_taxonomy_filters') );
	}

	/**
	 * Create custom taxonomy, for pages.
	 *  */
	public function custom_taxonomy_for_pages() {

	    register_taxonomy('page_tag', 'page', array(
	        'label' => __('Tags'),
	        'labels' => array('labels' => 'Page Tags'),
	        'rewrite' => array('slug' => 'page_tag'), //url
	        'hierarchical' => false,
	    	)
		);
	}


	/**
	 * Add tag filter in the 'Pages' page for the admin.
	 * 
	 *  */
	public function ar_pages_add_taxonomy_filters(){
		global $typenow;

		// An array of all the taxonomyies you want to display. Use the taxonomy name or slug
		$taxonomies = array('page_tag');  

		// must set this to the post type you want the filter(s) displayed on
		if ( $typenow == 'page' ) {  // if i want filter on page or a custom_post_type i set 'page' or the slug of the cpt.

			foreach ( $taxonomies as $tax_slug ) {
			    // note: the GET variale you want, is 'tag'. simply check at URL parameter.
			    //if admin has already select a tag,get it to show it as selected in the dropbox:
				$current_tax_slug = isset( $_GET['tag'] ) ? $_GET['tag'] : false;
				$tax_obj = get_taxonomy( $tax_slug ); //get the taxonomy object => tag taxonomy object.
				$tax_name = $tax_obj->labels->name;   //get the 'human' name => Tags
				$terms = get_terms($tax_slug);        //get all the individual tags used on the posts. i.e beef .. etc.
				
				if ( count( $terms ) > 0) {
				        
					echo "<select name='page_tag' id='$tax_slug' class='postform'>";
					echo "<option value=''>$tax_name</option>";
					foreach ( $terms as $term ) {
						echo '<option value=' . $term->slug, $current_tax_slug == $term->slug ? ' selected="selected"' : '','>' . $term->name .' (' . $term->count .')</option>';
					}

					echo "</select>";
				}
				else{
					echo 'No tags found';
				}
			}
	}
	}


}