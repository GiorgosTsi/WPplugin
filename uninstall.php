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

//we have to delete all the posts of this custom post type:

$args = array(
			 'post_type' => 'Athlimata' ,
			 'numberposts' => -1); //means all the posts of this type
$allPosts = get_posts($args);

//First method to delete all posts using php:

foreach ($allPosts as $post) {
	wp_delete_post($post->ID,true);
}


//second method using sql query

global $wpdb;

$wpdb->query("DELETE 
			  FROM wp_posts
			  WHERE post_type = 'athlimata'	");


//delete also all extra info about these posts:
$wpdv->query("DELETE
			  FROM wp_postmeta
			  WHERE post_id NOT IN( SELECT id
									FROM wp_posts )");

$wpdv->query("DELETE
			  FROM wp_term_relationships
			  WHERE object_id NOT IN( SELECT id
									FROM wp_posts )");

