<?php 
/**
 * @package  GiorgosTsikPlugin
 */
namespace Inc\Base;

use Inc\Api\SettingApi;
use Inc\Base\BaseController;
use Inc\Api\callbacks\TaxonomyCallbacks;
use Inc\Api\Callbacks\AdminCallbacks;

/**
* Class used to activate and deactivate the taxonomy tab from the dashboard.
* Also creates the subpage for the taxonomy tab.
*/
class CustomTaxonomyController extends BaseController{

	public $callbacks;

	public $subpages = array();

	public $settings;

	public $tax_callbacks;

	public $taxonomies;


	public function register(){

		/*Check if the cpt manager checkbox is checked
		  If its not return, dont show the subpage	
		 */
		$checkbox = get_option( 'taxonomy_manager' );
		if(! $checkbox ) return;

		//if checkbox is checked, show the cpt manager page

		$this->callbacks = new AdminCallbacks();

		$this->tax_callbacks = new TaxonomyCallbacks();

		$this->settings = new SettingApi();

		$this->setSubPages();

		$this->setSettings();

		$this->setSections();

		$this->setFields();

		$this->settings->addSubPages( $this->subpages )->register();

		$this->storeCustomTaxonomies();

		if ( ! empty( $this->taxonomies ) ) {
			add_action( 'init', array( $this, 'registerCustomTaxonomy' ));
		}

	}

	public function setSubpages()
	{
		$this->subpages = array(
			array(
				'parent_slug' => 'giorghs_plugin', 
	 			'page_title' => 'Custom Taxonomies', 
	 			'menu_title' => 'Taxonomies', 
	 			'capability' => 'manage_options', 
	 			'menu_slug' => 'giorghs_taxonomies', //url
	 			'callback' => array($this->callbacks, 'adminTaxonomy')
			)
		);
	}

	public function setSettings()
	{
		$args = array(
			array(
				'option_group' => 'giorghs_plugin_tax_settings',
				'option_name' => 'giorghs_plugin_tax',
				'callback' => array($this->tax_callbacks, 'taxSanitize')
			)
		);

		$this->settings->setSettings( $args );
	}

	public function setSections()
	{
		$args = array(
			array(
				'id' => 'giorghs_tax_index',
				'title' => 'Custom Taxonomy Manager',
				'callback' => array($this->tax_callbacks, 'taxSectionManager'),
				'page' => 'giorghs_taxonomies'
			)
		);

		$this->settings->setSections( $args );
	}

	public function setFields()
	{
		$args = array(
			array(
				'id' => 'taxonomy',
				'title' => 'Custom Taxonomy ID',
				'callback' => array($this->tax_callbacks, 'textField'),
				'page' => 'giorghs_taxonomies',
				'section' => 'giorghs_tax_index',
				'args' => array(
					'option_name' => 'giorghs_plugin_tax',
					'label_for' => 'taxonomy',
					'placeholder' => 'eg. genre',
					'array' => 'taxonomy'
				)
			),
			array(
				'id' => 'singular_name',
				'title' => 'Singular Name',
				'callback' => array( $this->tax_callbacks, 'textField' ),
				'page' => 'giorghs_taxonomies',
				'section' => 'giorghs_tax_index',
				'args' => array(
					'option_name' => 'giorghs_plugin_tax',
					'label_for' => 'singular_name',
					'placeholder' => 'eg. Genre',
					'array' => 'taxonomy'
				)
			),
			array(
				'id' => 'hierarchical',
				'title' => 'Hierarchical',
				'callback' => array( $this->tax_callbacks, 'checkboxField' ),
				'page' => 'giorghs_taxonomies',
				'section' => 'giorghs_tax_index',
				'args' => array(
					'option_name' => 'giorghs_plugin_tax',
					'label_for' => 'hierarchical',
					'class' => 'ui-toggle',
					'array' => 'taxonomy'
				)
			),
			array(
				'id' => 'objects',
				'title' => 'Post Types',
				'callback' => array( $this->tax_callbacks, 'checkboxPostTypesField' ),
				'page' => 'giorghs_taxonomies',
				'section' => 'giorghs_tax_index',
				'args' => array(
					'option_name' => 'giorghs_plugin_tax',
					'label_for' => 'objects',
					'class' => 'ui-toggle',
					'array' => 'taxonomy'
				)
			)
		);

		$this->settings->setFields( $args );
	}

	public function storeCustomTaxonomies()
	{
		$options = get_option( 'giorghs_plugin_tax' ) ?: array();

		foreach ($options as $option) {
			$labels = array(
				'name'              => $option['singular_name'],
				'singular_name'     => $option['singular_name'],
				'search_items'      => 'Search ' . $option['singular_name'],
				'all_items'         => 'All ' . $option['singular_name'],
				'parent_item'       => 'Parent ' . $option['singular_name'],
				'parent_item_colon' => 'Parent ' . $option['singular_name'] . ':',
				'edit_item'         => 'Edit ' . $option['singular_name'],
				'update_item'       => 'Update ' . $option['singular_name'],
				'add_new_item'      => 'Add New ' . $option['singular_name'],
				'new_item_name'     => 'New ' . $option['singular_name'] . ' Name',
				'menu_name'         => $option['singular_name'],
			);

			$this->taxonomies[] = array(
				'hierarchical'      => isset($option['hierarchical']) ? true : false,
				'labels'            => $labels,
				'show_ui'           => true,
				'show_admin_column' => true,
				'query_var'         => true,
				'rewrite'           => array( 'slug' => $option['taxonomy'] ),
				'objects'           => isset($option['objects']) ? $option['objects'] : null
			);

		}
	}

	public function registerCustomTaxonomy()
	{
		foreach ($this->taxonomies as $taxonomy) {
			$objects = isset($taxonomy['objects']) ? array_keys($taxonomy['objects']) : null;
			register_taxonomy( $taxonomy['rewrite']['slug'], $objects, $taxonomy );
		}
	}



}