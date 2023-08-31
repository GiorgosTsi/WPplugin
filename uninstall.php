<?php

/**
 * Trigger this file on plugin uninstall
 * 
 * @package giorgosTsikPlugin 
 *  */


/*
We need to uninstall the plugin,when we need
to clear database's stored data.
 */

//security check:
//only wp should uninstall the plugin with the proper, secure way.
//we have to check if any user or any malicious plugin try to uninstall it manually.

if( !defined('WP_UNINSTALL_PLUGIN') )
	die;

//we have to delete all the posts of all custom post types created:

// Get all registered post types
$options = get_option( 'giorghs_plugin_cpt' ) ?: array(); //get the option saved for each cpt

foreach ($options as $option) {

	/*Get all the posts of each cpt */
	$posts = get_posts( array(
        'post_type' => $option['singular_name'],
        'numberposts' => -1,
        'post_status' => 'any',
    ) );
	// Loop through each custom post type and delete posts
    foreach ( $posts as $post ) {
        wp_delete_post( $post->ID, true ); // Set second parameter to true to force delete
    }
}


//second method using sql query

// global $wpdb;

// $wpdb->query("DELETE 
// 			  FROM wp_posts
// 			  WHERE post_type = 'athlimata'	");


// //delete also all extra info about these posts:
// $wpdv->query("DELETE
// 			  FROM wp_postmeta
// 			  WHERE post_id NOT IN( SELECT id
// 									FROM wp_posts )");

// $wpdv->query("DELETE
// 			  FROM wp_term_relationships
// 			  WHERE object_id NOT IN( SELECT id
// 									FROM wp_posts )");

