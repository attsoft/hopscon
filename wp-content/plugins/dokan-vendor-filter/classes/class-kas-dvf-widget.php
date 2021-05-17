<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Get all required data from Dokan and woocommerce
 *
 *
 * @link       http://ideas.echopointer.com
 * @since      1.2.4
 *
 * @package    Kas_Dvf
 * @subpackage Kas_Dvf/classes
 */

/**
 *
 *
 * @since      1.2.4
 * @package    Kas_Dvf
 * @subpackage Kas_Dvf/classes
 * @author     Syed Muhammad Shafiq <shafiq_shaheen@hotmail.com>
 */
class Kas_Dvf_Widget extends WP_Widget {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.2.4
	 * @access   private
	 * @var      string    $kas_filter    The ID of this plugin.
	 */
	private $kas_filter;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.2.4
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Register widget with WordPress.
	 *
	 * @since    1.2.4
	 * @param      string    $kas_filter       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	function __construct( $kas_filter, $version ) {
		parent::__construct(
			$this->kas_filter, // Base ID
			esc_html__( 'Search Seller', $this->kas_filter ), // Name
			array( 'description' => esc_html__( 'Dokan Vendor Filter', $this->kas_filter ), ) // Args
		);
		$this->kas_filter = $kas_filter;
		$this->version = $version;
		$this->load_dependencies();		
	}
	
	

	/**
	 * Load the required dependencies for this class.
	 *
	 * Include the following files :
	 * 
	 * - Kas_Dvf_DokanData. Collect and get all required Dokan saller information.
	 *
	 *
	 * @since    1.0.6
	 * @access   private
	 */
	private function load_dependencies() {
		/**
		 * The class responsible for getting dokan data to menupulate fields
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'classes/class-kas-dvf-dokandata.php';

	}		
	
	

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
		}
		
		// get data from dokan
		
		$dokan_data = new Kas_Dvf_DokanData($this->kas_filter, $this->version);
		
		$kas_dokan_data = $dokan_data->kas_dokan_data();
		$kas_dokan_countries = $dokan_data->kas_dokan_countries();
		$kas_dokan_states = $dokan_data->kas_dokan_states();
		$kas_dokan_cities = $dokan_data->kas_dokan_cities();
		$kas_dokan_zips = $dokan_data->kas_dokan_zips();
		$kas_dokan_categories = $dokan_data->kas_dokan_category();
		$kas_dokan_stores = $dokan_data->kas_dokan_stores();
		
		$args = array(
			'data'	=> $kas_dokan_data,
            'countries' => $kas_dokan_countries,
            'states' => $kas_dokan_states,
            'cities' => $kas_dokan_cities,
			'zips'	=> $kas_dokan_zips,
			'categories'	=> $kas_dokan_categories,
            'stores' => $kas_dokan_stores,
		);
		
		$this->kas_widget_temp('form',$args);		
		
		//echo $args['after_widget'];
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'Dokan Vendor Filter', $this->kas_filter );
		?>
		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', $this->kas_filter ); ?></label> 
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<?php 
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

		return $instance;
	}
	
	/**
	 * Render Dokan vendor filter html.
	 *
	 * @since    1.2.4
	 */	
	public function kas_widget_temp($name = '', $args){
		switch ($name) {
			case 'form':
				include_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/kas_dokan_vendor_filter_widget.php';
				break;
			default:
				include_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/kas_dokan_vendor_filter_widget.php';
				break;
		}
	}	
}