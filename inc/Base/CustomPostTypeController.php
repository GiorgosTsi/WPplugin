<?php 
/**
 * @package  GiorgosTsikPlugin
 */
namespace Inc\Base;

use Inc\Api\SettingApi;
use Inc\Base\BaseController;
use Inc\Api\Callbacks\AdminCallbacks;
use Inc\Api\Callbacks\CptCallbacks;

/**
* Class used to activate and deactivate the cpt tab from the dashboard.
* Also creates the subpage for the cpt tab.
*/
class CustomPostTypeController extends BaseController{

	public $callbacks;

	public $subpages = array();

	public $settings;

	public $custom_post_types = array();

	public $cpt_callbacks;

	public function register(){

		/*Check if the cpt manager checkbox is checked
		  If its not return, dont show the subpage	
		 */
		$checkbox = get_option( 'cpt_manager' );
		if(! $checkbox ) return;

		//if checkbox is checked, show the cpt manager page

		$this->settings = new SettingApi();

		$this->callbacks = new AdminCallbacks();

		$this->cpt_callbacks = new CptCallbacks();

		$this->setSubpages();

		$this->setSettings();

		$this->setSections();

		$this->setFields();

		$this->settings->addSubPages( $this->subpages )->register();

		$this->storeCustomPostTypes();

		if ( ! empty( $this->custom_post_types ) ) {
			add_action( 'init', array( $this, 'registerCustomPostTypes' ) );
		}
		else die();

	}



	public function setSubpages()
	{
		$this->subpages = array(
			array(
				'parent_slug' => 'giorghs_plugin', 
	 			'page_title' => 'Custom Post Types', 
	 			'menu_title' => 'CPT', 
	 			'capability' => 'manage_options', 
	 			'menu_slug' => 'giorghs_cpt', //url
	 			'callback' => array($this->callbacks, 'adminCpt')
			)
		);
	}


	public function setSettings(){

		$args = array(
			array(
				'option_group' => 'giorghs_plugin_cpt_settings',
				'option_name' => 'post_type_id_setting',
				'callback' => array( $this->cpt_callbacks, 'cptSanitize' )
			),
			array(
				'option_group' => 'giorghs_plugin_cpt_settings',
				'option_name' => 'singular_name_setting',
				'callback' => array( $this->cpt_callbacks, 'cptSanitize' )
			),
			array(
				'option_group' => 'giorghs_plugin_cpt_settings',
				'option_name' => 'plural_name_setting',
				'callback' => array( $this->cpt_callbacks, 'cptSanitize' )
			),
			array(
				'option_group' => 'giorghs_plugin_cpt_settings',
				'option_name' => 'public_setting',
				'callback' => array( $this->cpt_callbacks, 'cptSanitize' )
			),
			array(
				'option_group' => 'giorghs_plugin_cpt_settings',
				'option_name' => 'has_archive_setting',
				'callback' => array( $this->cpt_callbacks, 'cptSanitize' )
			)

		);

		$this->settings->setSettings($args);
	}

	public function setSections(){

		$args = array(
			array(
				'id' => 'giorghs_cpt_section_index',
				'title' => 'Custom Post Type Manager',
				'callback' => array( $this->cpt_callbacks, 'cptSectionManager' ),
				'page' => 'giorghs_cpt'
			)
		);

		$this->settings->setSections($args);
	}
	
	public function setFields(){


		$args = array(
			array(
				'id' => 'post_type',
				'title' => 'Custom Post Type ID',
				'callback' => array( $this->cpt_callbacks, 'textField' ),
				'page' => 'giorghs_cpt',
				'section' => 'giorghs_cpt_section_index',
				'args' => array(
					'option_name' => 'post_type_id_setting',
					'label_for' => 'post_type',
					'placeholder' => 'eg. product'
				)
			),
			array(
				'id' => 'singular_name',
				'title' => 'Singular Name',
				'callback' => array( $this->cpt_callbacks, 'textField' ),
				'page' => 'giorghs_cpt',
				'section' => 'giorghs_cpt_section_index',
				'args' => array(
					'option_name' => 'singular_name_setting',
					'label_for' => 'singular_name',
					'placeholder' => 'eg. Product'
				)
			),
			array(
				'id' => 'plural_name',
				'title' => 'Plural Name',
				'callback' => array( $this->cpt_callbacks, 'textField' ),
				'page' => 'giorghs_cpt',
				'section' => 'giorghs_cpt_section_index',
				'args' => array(
					'option_name' => 'plural_name_setting',
					'label_for' => 'plural_name',
					'placeholder' => 'eg. Products'
				)
			),
			array(
				'id' => 'public',
				'title' => 'Public',
				'callback' => array( $this->cpt_callbacks, 'checkboxField' ),
				'page' => 'giorghs_cpt',
				'section' => 'giorghs_cpt_section_index',
				'args' => array(
					'option_name' => 'public_setting',
					'label_for' => 'public',
					'class' => 'ui-toggle'
				)
			),
			array(
				'id' => 'has_archive',
				'title' => 'Archive',
				'callback' => array( $this->cpt_callbacks, 'checkboxField' ),
				'page' => 'giorghs_cpt',
				'section' => 'giorghs_cpt_section_index',
				'args' => array(
					'option_name' => 'has_archive_setting',
					'label_for' => 'has_archive',
					'class' => 'ui-toggle'
				)
			)
		);
		$this->settings->setFields($args);
	}

	public function storeCustomPostTypes()
	{
		$options = array(
					'post_type'=> get_option('post_type_id_setting'),
					'plural_name'=> get_option('singular_name_setting'),
					'singular_name'=> get_option('plural_name_setting'),
					'public'=> get_option('public_setting'),
					'has_archive'=> get_option('has_archive')
		);

		if(is_array(get_option('singular_name_setting'))){
			return;
		 
		}
		else{
				$this->custom_post_types[] = array(
		    'post_type'             => get_option('post_type_id_setting'),
		    'name'                  => get_option('plural_name_setting'),
		    'singular_name'         => get_option('singular_name_setting'),
		    'menu_name'             => get_option('plural_name_setting'),
		    'name_admin_bar'        => get_option('singular_name_setting'),
		    'archives'              => get_option('singular_name_setting') . " Archives",
		    'attributes'            => get_option('singular_name_setting') . " Attributes",
		    'parent_item_colon'     => "Parent"  . get_option('singular_name_setting'),
		    'all_items'             => "All"  . get_option('plural_name_setting'),
		    'add_new_item'          => "Add New"  . get_option('singular_name_setting'),
		    'add_new'               => "Add New",
		    'new_item'              => "New"   . get_option('singular_name_setting'),
		    'edit_item'             => "Edit"  . get_option('singular_name_setting'),
		    'update_item'           => "Update"  . get_option('singular_name_setting'),
		    'view_item'             => "View"  . get_option('singular_name_setting'),
		    'view_items'            => "View"  . get_option('plural_name_setting'),
		    'search_items'          => "Search"  . get_option('plural_name_setting'),
		    'not_found'             => "No"  . get_option('singular_name_setting') . " Found",
		    'not_found_in_trash'    => "No"  . get_option('singular_name_setting') .  " Found in Trash",
		    'featured_image'        => "Featured Image",
		    'set_featured_image'    => "Set Featured Image",
		    'remove_featured_image' => "Remove Featured Image",
		    'use_featured_image'    => "Use Featured Image",
		    'insert_into_item'      => "Insert into"  . get_option('singular_name_setting'),
		    'uploaded_to_this_item' => "Upload to this"  . get_option('singular_name_setting'),
		    'items_list'            => get_option('plural_name_setting') .  " List",
		    'items_list_navigation' => get_option('plural_name_setting') .  " List Navigation",
		    'filter_items_list'     => "Filter" . get_option('plural_name_setting') .  " List",
		    'label'                 => get_option('singular_name_setting'),
		    'description'           => get_option('plural_name_setting') . " Custom Post Type",
		    'supports'              => array( 'title', 'editor', 'thumbnail' ),
		    'taxonomies'            => array( 'category', 'post_tag' ),
		    'hierarchical'          => false,
		    'public'                => get_option('public_setting'),
		    'show_ui'               => true,
		    'show_in_menu'          => true,
		    'menu_position'         => 5,
		    'show_in_admin_bar'     => true,
		    'show_in_nav_menus'     => true,
		    'can_export'            => true,
		    'has_archive'           => get_option('has_archive'),
		    'exclude_from_search'   => false,
		    'publicly_queryable'    => true,
		    'capability_type'       => 'post'
			);
		}


		//die();
		
		// foreach ($options as $option) {

			// $this->custom_post_types[] = array(
			// 	'post_type'             => $options['post_type'],
			// 	'name'                  => $options['plural_name'],
			// 	'singular_name'         => $options['singular_name'],
			// 	'menu_name'             => $options['plural_name'],
			// 	'name_admin_bar'        => $options['singular_name'],
			// 	'archives'              => $options['singular_name'] .  " Archives",
			// 	'attributes'            => $options['singular_name'] .  " Attributes",
			// 	'parent_item_colon'     => "Parent"  . $options['singular_name'],
			// 	'all_items'             => "All"  . $options['plural_name'],
			// 	'add_new_item'          => "Add New"  . $options['singular_name'],
			// 	'add_new'               => "Add New",
			// 	'new_item'              => "New"   . $options['singular_name'],
			// 	'edit_item'             => "Edit"  . $options['singular_name'],
			// 	'update_item'           => "Update"  . $options['singular_name'],
			// 	'view_item'             => "View"  . $options['singular_name'],
			// 	'view_items'            => "View"  . $options['plural_name'],
			// 	'search_items'          => "Search"  . $options['plural_name'],
			// 	'not_found'             => "No"  . $options['singular_name'] . " Found",
			// 	'not_found_in_trash'    => "No"  . $options['singular_name'] .  "Found in Trash",
			// 	'featured_image'        => "Featured Image",
			// 	'set_featured_image'    => "Set Featured Image",
			// 	'remove_featured_image' => "Remove Featured Image",
			// 	'use_featured_image'    => "Use Featured Image",
			// 	'insert_into_item'      => "Insert into"  . $options['singular_name'],
			// 	'uploaded_to_this_item' => "Upload to this"  . $options['singular_name'],
			// 	'items_list'            => $options['plural_name'] .  "List",
			// 	'items_list_navigation' => $options['plural_name'] .  "List Navigation",
			// 	'filter_items_list'     => "Filter" . $options['plural_name'] .  "List",
			// 	'label'                 => $options['singular_name'],
			// 	'description'           => $options['plural_name'] . "Custom Post Type",
			// 	'supports'              => array( 'title', 'editor', 'thumbnail' ),
			// 	'taxonomies'            => array( 'category', 'post_tag' ),
			// 	'hierarchical'          => false,
			// 	'public'                => $options['public'],
			// 	'show_ui'               => true,
			// 	'show_in_menu'          => true,
			// 	'menu_position'         => 5,
			// 	'show_in_admin_bar'     => true,
			// 	'show_in_nav_menus'     => true,
			// 	'can_export'            => true,
			// 	'has_archive'           => $options['has_archive'],
			// 	'exclude_from_search'   => false,
			// 	'publicly_queryable'    => true,
			// 	'capability_type'       => 'post'
			// );
		// }
	// $this->custom_post_types[] = array(
    // 'post_type'             => get_option('post_type_id_setting'),
    // 'name'                  => get_option('plural_name_setting'),
    // 'singular_name'         => get_option('singular_name_setting'),
    // 'menu_name'             => get_option('plural_name_setting'),
    // 'name_admin_bar'        => get_option('singular_name_setting'),
    // 'archives'              => implode("", get_option('singular_name_setting')) . " Archives",
    // 'attributes'            => implode("", get_option('singular_name_setting')) . " Attributes",
    // 'parent_item_colon'     => "Parent"  .implode("", get_option('singular_name_setting')),
    // 'all_items'             => "All"  . implode("", get_option('plural_name_setting')),
    // 'add_new_item'          => "Add New"  . implode("", get_option('singular_name_setting')),
    // 'add_new'               => "Add New",
    // 'new_item'              => "New"   . implode("", get_option('singular_name_setting')),
    // 'edit_item'             => "Edit"  . implode("", get_option('singular_name_setting')),
    // 'update_item'           => "Update"  . implode("", get_option('singular_name_setting')),
    // 'view_item'             => "View"  .implode("", get_option('singular_name_setting')),
    // 'view_items'            => "View"  . implode("", get_option('plural_name_setting')),
    // 'search_items'          => "Search"  .implode("", get_option('plural_name_setting')),
    // 'not_found'             => "No"  .implode("", get_option('singular_name_setting')) . " Found",
    // 'not_found_in_trash'    => "No"  . implode("", get_option('singular_name_setting')) .  " Found in Trash",
    // 'featured_image'        => "Featured Image",
    // 'set_featured_image'    => "Set Featured Image",
    // 'remove_featured_image' => "Remove Featured Image",
    // 'use_featured_image'    => "Use Featured Image",
    // 'insert_into_item'      => "Insert into"  . implode("", get_option('singular_name_setting')),
    // 'uploaded_to_this_item' => "Upload to this"  . implode("", get_option('singular_name_setting')),
    // 'items_list'            => implode("", get_option('plural_name_setting')) .  " List",
    // 'items_list_navigation' => implode("", get_option('plural_name_setting')) .  " List Navigation",
    // 'filter_items_list'     => "Filter" . implode("", get_option('plural_name_setting')) .  " List",
    // 'label'                 => get_option('singular_name_setting'),
    // 'description'           => implode("", get_option('plural_name_setting')) . " Custom Post Type",
    // 'supports'              => array( 'title', 'editor', 'thumbnail' ),
    // 'taxonomies'            => array( 'category', 'post_tag' ),
    // 'hierarchical'          => false,
    // 'public'                => get_option('public_setting'),
    // 'show_ui'               => true,
    // 'show_in_menu'          => true,
    // 'menu_position'         => 5,
    // 'show_in_admin_bar'     => true,
    // 'show_in_nav_menus'     => true,
    // 'can_export'            => true,
    // 'has_archive'           => get_option('has_archive'),
    // 'exclude_from_search'   => false,
    // 'publicly_queryable'    => true,
    // 'capability_type'       => 'post'
	// );
}


	public function registerCustomPostTypes()
	{
		foreach ($this->custom_post_types as $post_type) {
			register_post_type( $post_type['post_type'],
				array(
					'labels' => array(
						'name'                  => $post_type['name'],
						'singular_name'         => $post_type['singular_name'],
						'menu_name'             => $post_type['menu_name'],
						'name_admin_bar'        => $post_type['name_admin_bar'],
						'archives'              => $post_type['archives'],
						'attributes'            => $post_type['attributes'],
						'parent_item_colon'     => $post_type['parent_item_colon'],
						'all_items'             => $post_type['all_items'],
						'add_new_item'          => $post_type['add_new_item'],
						'add_new'               => $post_type['add_new'],
						'new_item'              => $post_type['new_item'],
						'edit_item'             => $post_type['edit_item'],
						'update_item'           => $post_type['update_item'],
						'view_item'             => $post_type['view_item'],
						'view_items'            => $post_type['view_items'],
						'search_items'          => $post_type['search_items'],
						'not_found'             => $post_type['not_found'],
						'not_found_in_trash'    => $post_type['not_found_in_trash'],
						'featured_image'        => $post_type['featured_image'],
						'set_featured_image'    => $post_type['set_featured_image'],
						'remove_featured_image' => $post_type['remove_featured_image'],
						'use_featured_image'    => $post_type['use_featured_image'],
						'insert_into_item'      => $post_type['insert_into_item'],
						'uploaded_to_this_item' => $post_type['uploaded_to_this_item'],
						'items_list'            => $post_type['items_list'],
						'items_list_navigation' => $post_type['items_list_navigation'],
						'filter_items_list'     => $post_type['filter_items_list']
					),
					'label'                     => $post_type['label'],
					'description'               => $post_type['description'],
					'supports'                  => $post_type['supports'],
					'taxonomies'                => $post_type['taxonomies'],
					'hierarchical'              => $post_type['hierarchical'],
					'public'                    => $post_type['public'],
					'show_ui'                   => $post_type['show_ui'],
					'show_in_menu'              => $post_type['show_in_menu'],
					'menu_position'             => $post_type['menu_position'],
					'show_in_admin_bar'         => $post_type['show_in_admin_bar'],
					'show_in_nav_menus'         => $post_type['show_in_nav_menus'],
					'can_export'                => $post_type['can_export'],
					'has_archive'               => $post_type['has_archive'],
					'exclude_from_search'       => $post_type['exclude_from_search'],
					'publicly_queryable'        => $post_type['publicly_queryable'],
					'capability_type'           => $post_type['capability_type']
				)
			);
		}
	}


}