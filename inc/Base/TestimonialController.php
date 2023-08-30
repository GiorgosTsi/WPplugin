<?php 
/**
 * @package  GiorgosTsikPlugin
 */
namespace Inc\Base;

use Inc\Api\SettingApi;
use Inc\Base\BaseController;
use Inc\Api\Callbacks\AdminCallbacks;

/**
* Class used to activate and deactivate the testimonial cpt tab from the dashboard.
*/
class TestimonialController extends BaseController{

	public $callbacks;

	public $settings;

	public function register(){

		/*Check if the cpt manager checkbox is checked
		  If its not return, dont show the subpage	
		 */
		$checkbox = get_option( 'testimonial_manager' );
		if(! $checkbox ) return;

		//if checkbox is checked, show the testimonial manager page


		$this->callbacks = new AdminCallbacks();

		$this->settings = new SettingApi();

		//create the new testimonial cpt.
		add_action( 'init', array( $this, 'testimonial_cpt' ) );

		//add meta boxes.
		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );

		//save meta boxes data.
		add_action( 'save_post', array( $this, 'save_meta_box' ) );

		//set new columns in the cpt page.
		add_action( 'manage_testimonial_posts_columns', array( $this, 'set_custom_columns' ) );

		//set the data on the custom columns.
		add_action( 'manage_testimonial_posts_custom_column', array( $this, 'set_custom_columns_data' ), 10, 2 );

		//set the custom columns to be sortable (alphabetically) 
		add_filter( 'manage_edit-testimonial_sortable_columns', array( $this, 'set_custom_columns_sortable' ) );

	}

	public function testimonial_cpt ()
	{
		$labels = array(
			'name' => 'Testimonials',
			'singular_name' => 'Testimonial'
		);

		$args = array(
			'labels' => $labels,
			'public' => true,
			'has_archive' => false,
			'menu_icon' => 'dashicons-testimonial',
			'exclude_from_search' => true,
			'publicly_queryable' => false,
			'supports' => array( 'title', 'editor' )
		);

		register_post_type ( 'testimonial', $args );
	}

	public function add_meta_boxes()
	{
		add_meta_box(
			'testimonial_author',
			'Testimonial Options',
			array( $this, 'render_features_box' ),
			'testimonial',
			'side',
			'default'
		);
	}

	public function render_features_box($post)
	{
		wp_nonce_field( 'giorghs_testimonial', 'giorghs_testimonial_nonce' );

		$data = get_post_meta( $post->ID, '_giorghs_testimonial_key', true );
		$name = isset($data['name']) ? $data['name'] : '';
		$email = isset($data['email']) ? $data['email'] : '';
		$approved = isset($data['approved']) ? $data['approved'] : false;
		$featured = isset($data['featured']) ? $data['featured'] : false;
		?>
		<p>
			<label class="meta-label" for="giorghs_testimonial_author">Author Name</label>
			<input type="text" id="giorghs_testimonial_author" name="giorghs_testimonial_author" class="widefat" value="<?php echo esc_attr( $name ); ?>">
		</p>
		<p>
			<label class="meta-label" for="giorghs_testimonial_email">Author Email</label>
			<input type="email" id="giorghs_testimonial_email" name="giorghs_testimonial_email" class="widefat" value="<?php echo esc_attr( $email ); ?>">
		</p>
		<div class="meta-container">
			<label class="meta-label w-50 text-left" for="giorghs_testimonial_approved">Approved</label>
			<div class="text-right w-50 inline">
				<div class="ui-toggle inline"><input type="checkbox" id="giorghs_testimonial_approved" name="giorghs_testimonial_approved" value="1" <?php echo $approved ? 'checked' : ''; ?>>
					<label for="giorghs_testimonial_approved"><div></div></label>
				</div>
			</div>
		</div>
		<div class="meta-container">
			<label class="meta-label w-50 text-left" for="giorghs_testimonial_featured">Featured</label>
			<div class="text-right w-50 inline">
				<div class="ui-toggle inline"><input type="checkbox" id="giorghs_testimonial_featured" name="giorghs_testimonial_featured" value="1" <?php echo $featured ? 'checked' : ''; ?>>
					<label for="giorghs_testimonial_featured"><div></div></label>
				</div>
			</div>
		</div>
		<?php
	}


	public function save_meta_box($post_id)
	{
		if (! isset($_POST['giorghs_testimonial_nonce'])) {
			return $post_id;
		}

		$nonce = $_POST['giorghs_testimonial_nonce'];
		if (! wp_verify_nonce( $nonce, 'giorghs_testimonial' )) {
			return $post_id;
		}

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post_id;
		}

		if (! current_user_can( 'edit_post', $post_id ) ) {
			return $post_id;
		}

		$data = array(
			'name' => sanitize_text_field( $_POST['giorghs_testimonial_author'] ),
			'email' => sanitize_text_field( $_POST['giorghs_testimonial_email'] ),
			'approved' => isset($_POST['giorghs_testimonial_approved']) ? 1 : 0,
			'featured' => isset($_POST['giorghs_testimonial_featured']) ? 1 : 0,
		);
		update_post_meta( $post_id, '_giorghs_testimonial_key', $data );
	}

	public function set_custom_columns($columns)
	{
		$title = $columns['title'];
		$date = $columns['date'];
		unset( $columns['title'], $columns['date'] );

		$columns['name'] = 'Author Name';
		$columns['title'] = $title;
		$columns['approved'] = 'Approved';
		$columns['featured'] = 'Featured';
		$columns['date'] = $date;

		return $columns;
	}


	public function set_custom_columns_data($column, $post_id)
	{
		$data = get_post_meta( $post_id, '_giorghs_testimonial_key', true );
		$name = isset($data['name']) ? $data['name'] : '';
		$email = isset($data['email']) ? $data['email'] : '';
		$approved = isset($data['approved']) && $data['approved'] === 1 ? '<strong>YES</strong>' : 'NO';
		$featured = isset($data['featured']) && $data['featured'] === 1 ? '<strong>YES</strong>' : 'NO';

		switch($column) {
			case 'name':
				echo '<strong>' . $name . '</strong><br/><a href="mailto:' . $email . '">' . $email . '</a>';
				break;

			case 'approved':
				echo $approved;
				break;

			case 'featured':
				echo $featured;
				break;
		}
	}

	public function set_custom_columns_sortable($columns)
	{
		$columns['name'] = 'name';
		$columns['approved'] = 'approved';
		$columns['featured'] = 'featured';

		return $columns;
	}


}