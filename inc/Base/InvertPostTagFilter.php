<?php
/**
 * @package giorgosTsikPlugin 
 * Creates an inverted post tag filter.
 */

namespace Inc\Base;

class InvertPostTagFilter
{
	
	public function register(){

		$checkbox = get_option('invert_post_tag_filter');

		//every time only one should be checked, not both.
		if(!$checkbox ) return;

		add_action( 'restrict_manage_posts', array($this,'ar_posts_add_invert_taxonomy_filters') );


		add_action( 'pre_get_posts', array($this, 'ar_exclude_posts_by_tag' ) );
	}




	/**
	 * Add inverted tag filter in the post page for the admin.
	 * 
	 *  */
	public function ar_posts_add_invert_taxonomy_filters(){
		
	    global $typenow;

	    $taxonomies = array('post_tag');  

	    if ( $typenow == 'post' ) {
	        // Get the selected tag for exclusion
	        $exclude_tag_slug = isset( $_GET['exclude_page_tag'] ) ? $_GET['exclude_page_tag'] : false;
	        $exclude_tag = get_term_by( 'slug', $exclude_tag_slug, 'post_tag' ); //get the tag slug.

	        foreach ( $taxonomies as $tax_slug ) {
	            $tax_obj = get_taxonomy( $tax_slug );// get post tag taxonomy object
	            $tax_name = $tax_obj->labels->name;  // get the human name of the tag => Tags
	            $terms = get_terms( $tax_slug );     // get all the tag names

	            if ( count( $terms ) > 0 ) {
	                echo "<select name='exclude_page_tag' id='$tax_slug' class='postform'>";
	                echo "<option value=''>Exclude $tax_name</option>";

	                foreach ( $terms as $term ) {
	                    echo '<option value="' . $term->slug . '"', $exclude_tag_slug === $term->slug ? ' selected="selected"' : '', '>' . $term->name . ' (' . $term->count . ')</option>';
	                }

	                echo "</select>";
	            }
	        }
	    }
	}


	/**
	 * @param $query
	 * $query parameter allows you to customize the WordPress main query for fetching posts. 
	 * In this case, the code uses it to exclude posts with a specific tag from the query 
	 * results when the inverted tag filter is applied in the admin area. */
	function ar_exclude_posts_by_tag( $query ) {

	    global $typenow;

	    if ( $typenow == 'post' && $query->is_main_query() ) {
	        $exclude_tag_slug = isset( $_GET['exclude_page_tag'] ) ? $_GET['exclude_page_tag'] : false;
	        $exclude_tag = get_term_by( 'slug', $exclude_tag_slug, 'post_tag' );

	        if ( $exclude_tag ) {
	            $query->set( 'tag__not_in', array( $exclude_tag->term_id ) );
	        }
	    }
	}
	
}