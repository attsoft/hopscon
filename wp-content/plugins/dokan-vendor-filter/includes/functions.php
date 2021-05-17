<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://ideas.echopointer.com
 * @since      1.0.0
 *
 * @package    Kas_Dvf
 * @subpackage Kas_Dvf/includes
 *
 * Locate template.
 *
 * Locate the called template.
 * Search Order:
 * 1. /themes/theme/dokan/filter/$template_name
 * 2. /themes/theme/$template_name
 * 3. /plugins/dokan-vendor-filter/templates/$template_name.
 *
 * @since 1.0.0
 *
 * @param 	string 	$template_name			Template to load.
 * @param 	string 	$string $template_path	Path to templates.
 * @param 	string	$default_path			Default path to template files.
 * @return 	string 							Path to the template file.
 */
	function kas_dvf_locate_template( $template_name, $template_path = '', $default_path = '' ) {
		// Set variable to search in woocommerce-plugin-templates folder of theme.
		if ( ! $template_path ) :
			$template_path = 'dokan/filter';
		endif;
		// Set default plugin templates path.
		if ( ! $default_path ) :
			$default_path = plugin_dir_path( dirname( __FILE__ ) ) . 'templates/'; // Path to the template folder
		endif;
		// Search template file in theme folder.
		$template = locate_template( array(
			$template_path . $template_name,
			$template_name
		) );
		// Get plugins template file.
		if ( ! $template ) :
			$template = $default_path . $template_name;
		endif;
		return apply_filters( 'kas_dvf_locate_template', $template, $template_name, $template_path, $default_path );
	}
/**
 * Get template.
 *
 * Search for the template and include the file.
 *
 * @since 1.0.0
 *
 * @see kas_dvf_locate_template()
 *
 * @param string 	$template_name			Template to load.
 * @param array 	$args					Args passed for the template file.
 * @param string 	$string $template_path	Path to templates.
 * @param string	$default_path			Default path to template files.
 */
	function kas_dvf_get_template( $template_name, $args = array(), $tempate_path = '', $default_path = '' ) {
		if ( is_array( $args ) && isset( $args ) ) :
			extract( $args );
		endif;
		$template_file = kas_dvf_locate_template( $template_name, $tempate_path, $default_path );
		if ( ! file_exists( $template_file ) ) :
			_doing_it_wrong( __FUNCTION__, sprintf( '<code>%s</code> does not exist.', $template_file ), '1.0.0' );
			return;
		endif;
		include $template_file;
	}

/**
 * search for given value in array
 * @since 1.0.2
 */
function kas_search_in_array($search, $array_key, $array) {
	$ret_arr = array();
	$total = count($array);

	for ($i = 0; $i < $total; $i++) {
		switch ($array_key) {
			case 'country':
				if ($array[$i]['country'] === $search) {
					array_push($ret_arr,$array[$i]);
				}
				break;
			case 'state':
				if ($array[$i]['state'] === $search) {
					array_push($ret_arr,$array[$i]);
				}
				break;
			case 'city':
				if ($array[$i]['city'] === $search) {
					array_push($ret_arr,$array[$i]);
				}
				break;
			case 'zip':
				if ($array[$i]['zip'] === $search) {
					array_push($ret_arr,$array[$i]);
				}
				break;
			
			case 'rating':
				if ($array[$i]['rating'] === $search) {
					array_push($ret_arr,$array[$i]);
				}
				break;
			case 'category':
				if (!empty($array[$i]['category'])) {
					$catag = explode( ',',$array[$i]['category']);
					array_unique($catag);
					foreach ($catag as $cat){
						if ($cat === $search) {
							array_push($ret_arr,$array[$i]);
						}
					}
				}
				break;
			default:
				return NULL;
				break;
		}
	}
	return $ret_arr;
}


/**
 * Unique for any field like id, name or num. 
 * 
 * @since 1.0.2
 */
function unique_multidim_array($array, $key) {
    $temp_array = array();
    $i = 0;
    $key_array = array();
   
    foreach($array as $val) {
        if (!in_array($val[$key], $key_array)) {
            $key_array[$i] = $val[$key];
            $temp_array[$i] = $val;
        }
        $i++;
    }
    return $temp_array;
}

function dksort($array, $case){
    if(array_key_exists($case,$array)){
        $a[$case] = $array[$case];
        foreach($array as $key=>$val){
            if($case==$key){

            }else{
                $a[$key] = $array[$key];
            }
        }
    }

    return $a;
}



