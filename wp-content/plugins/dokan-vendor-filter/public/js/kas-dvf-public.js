
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://ideas.echopointer.com
 * @since      1.0.0
 *
 * @package    Kas_Dokan_Vendor_Filter
 * @subpackage Kas_Dokan_Vendor_Filter/public/js
 */


/** var array = string.split(',');
 * search and select from json.
 * 
 * @since 1.0.0
 */
	function kas_search(inField = '',nameKey, myArray){
		var arr = [];
	
	    for (var i=0; i < myArray.length; i++) {
	    	
	    	switch(inField) {
	        case "state":
	            if (myArray[i].state === nameKey) {
	            	arr.push(myArray[i]);    
	            }
	            break;
	        case "country":
	            if (myArray[i].country === nameKey) {
	            	arr.push(myArray[i]);    
	            }
	            break;
	        case "city":
	            if (myArray[i].city === nameKey) {
	            	arr.push(myArray[i]);    
	            }
	            break;
	        case "zip":
	            if (myArray[i].zip === nameKey) {
	            	arr.push(myArray[i]);    
	            }
	            break;
	        case "rating":
	            if (myArray[i].rating === nameKey) {
	            	arr.push(myArray[i]);    
	            }
	            break;
	        
	        case "category":
	        	if(myArray[i].category){
					var array = myArray[i].category.split(',');
					for (var j = 0; j < array.length; j++) {
						if(array[j] === nameKey){
							arr.push(myArray[i]);
						}
					}
	        	}
	            break;
	        default:
	        	arr.push(myArray[i]);
	    	}    	
	    }
	    return arr;
	}
	
	/**
	 * Remove Duplicates.
	 * 
	 * @since 1.0.0
	 */
	function kas_remove_dup(key,array){
		
		switch(key) {
	    case "state":
		
			var flags = [], UniqueNames = [], l = array.length, i;
			for( i=0; i<l; i++) {
				if( flags[array[i].state]) continue;
				flags[array[i].state] = true;
				UniqueNames.push(array[i].state);
			}		
				
	        break;
	    case "country":
			var flags = [], UniqueNames = [], l = array.length, i;
			for( i=0; i<l; i++) {
				if( flags[array[i].country]) continue;
				flags[array[i].country] = true;
				UniqueNames.push(array[i].country);
			}	
	        break;
	    case "city":
			var flags = [], UniqueNames = [], l = array.length, i;
			for( i=0; i<l; i++) {
				if( flags[array[i].city]) continue;
				flags[array[i].city] = true;
				UniqueNames.push(array[i].city);
			}
	        break;
	    case "zip":
			var flags = [], UniqueNames = [], l = array.length, i;
			for( i=0; i<l; i++) {
				if( flags[array[i].zip]) continue;
				flags[array[i].zip] = true;
				UniqueNames.push(array[i].zip);
			}
	        break;
	    case "rating":
			var flags = [], UniqueNames = [], l = array.length, i;
			for( i=0; i<l; i++) {
				if(array[i].rating.length){
					if( flags[array[i].rating]) continue;
					flags[array[i].rating] = true;
					UniqueNames.push(array[i].rating);
				}
			}
	        break;
	    
	    case "category":
	    	var arr = [];
	    	for (var i=0; i < array.length; i++) {
	        	if(array[i].category){
					var array2 = array[i].category.split(',');
					for (var j = 0; j < array2.length; j++) {
						
							arr.push(array2[j]);
						
					}
	        	}	    		
	    	}
	    	//alert(JSON.stringify(arr));

			var flags = [], UniqueNames = [], l = arr.length, i;
			for( i=0; i<l; i++) {
				if( flags[arr[i]]) continue;
				flags[arr[i]] = true;
				UniqueNames.push(arr[i]);
				
			}
			//alert(JSON.stringify(UniqueNames));
	        break;
	    default:
	    	var UniqueNames = array;
		}
	
		return UniqueNames;
	}

	/**
	 * create select options.
	 * 
	 * @since 1.0.0
	 */
	function kas_option_generator(str,key = '',val = '',myArray,str_explod = 0){
		var string = '';
		string += '<option value="">' + str + '</option>';
		if ( myArray.length != 0 ) {
			for (var x = 0; x < myArray.length; x++) {
				if(key.length && val.length){
					string += '<option value="' + myArray[x][key] + '">' + myArray[x][val] + '</option>';
				}else if(key.length){
					string += '<option value="' + myArray[x][key] + '">' + myArray[x][key] + '</option>';
				}else if(str_explod > 0){
				var array = myArray[x].split(',');
					for (var y = 0; y < array.length; y++) {
						string += '<option value="' + array[y] + '">' + array[y] + '</option>';
					}
				}else{
					string += '<option value="' + myArray[x] + '">' + myArray[x] + '</option>';
				}
			}
		}
		return string;
	}
	
	/**
	 * onChange make assotiative val selected.
	 * 
	 * @since 1.0.1
	 */
	function kas_SelectElement(key,valueToSelect){  
		
		switch(key) {
	    case "state":
	    	jQuery(".kas_state").val(valueToSelect);
	        break;
	    case "country":
	    	jQuery(".kas_country").val(valueToSelect);
	        break;
	    case "city":
	    	jQuery(".kas_city").val(valueToSelect);
	        break;
	    case "zip":
	    	jQuery(".kas_zip").val(valueToSelect);
	        break;
	    case "rating":
	    	jQuery(".kas_rating").val(valueToSelect);
	        break;
	    case "category":
	    	jQuery(".kas_category").val(valueToSelect);
	        break;
	    default:
	    	// something
		}	
	}
	
	
	/**
	 * set fields by country.
	 * 
	 * @since 1.1.1
	 */	
	function kas_set_by_country(){

		var kas_country_str = jQuery( ".kas_country" ).val();
		if(kas_country_str){
			var kas_resultObject = kas_search('country',kas_country_str, kas_searchList);
			// remove duplicates
			var state = kas_remove_dup('state', kas_resultObject);
			var city = kas_remove_dup('city', kas_resultObject);
			var zip = kas_remove_dup('zip', kas_resultObject);
			var category = kas_remove_dup('category', kas_resultObject);
			var rating = kas_remove_dup('rating', kas_resultObject);
			// create options
			var state = kas_option_generator('State..','','',state);
			var city = kas_option_generator('City..','','',city);	
			var zip = kas_option_generator('Zip..','','',zip);	
			var category = kas_option_generator('Vendor Category..','','',category,1);		
			var rating = kas_option_generator('Rating..','','',rating);		
			var store = kas_option_generator('Store Name..','store_link','store_name',kas_resultObject);				
			
			jQuery('.kas_state').html(state);
			jQuery('.kas_city').html(city);
			jQuery('.kas_zip').html(zip);
			jQuery('.kas_category').html(category);
			jQuery('.kas_rating').html(rating);
			jQuery('.kas_store').html(store);				
			
		}
	}	
	
	/**
	 * set fields by state.
	 * 
	 * @since 1.1.1
	 */	
	function kas_set_by_state(){
		var kas_state_str = jQuery( ".kas_state" ).val();		
		if(kas_state_str){
			
			var kas_resultObject = kas_search('state',kas_state_str, kas_searchList);	
			
			// remove duplicates
			var city = kas_remove_dup('city', kas_resultObject);
			var country = kas_remove_dup('country', kas_resultObject);
			var zip = kas_remove_dup('zip', kas_resultObject);
			var category = kas_remove_dup('category', kas_resultObject);
			var rating = kas_remove_dup('rating', kas_resultObject);
			
			if (jQuery(".kas_country").length){ 
				kas_SelectElement('country',country[0]);
			}
			// create options
			var city = kas_option_generator('City..','','',city);		
			var zip = kas_option_generator('Zip..','','',zip);		
			var category = kas_option_generator('Vendor Category..','','',category,1);		
			var rating = kas_option_generator('Rating..','','',rating);			
			var store = kas_option_generator('Store Name..','store_link','store_name',kas_resultObject);				
			
			jQuery('.kas_city').html(city);
			jQuery('.kas_zip').html(zip);
			jQuery('.kas_category').html(category);
			jQuery('.kas_rating').html(rating);
			jQuery('.kas_store').html(store);
		}
	}		
	
	
	
	/**
	 * set fields by city.
	 * 
	 * @since 1.1.1
	 */	
	function kas_set_by_city(){
		var kas_city_str = jQuery( ".kas_city" ).val();
			
		if(kas_city_str){
			
			var kas_resultObject = kas_search('city',kas_city_str, kas_searchList);
			var country = kas_remove_dup('country', kas_resultObject);	
			var state = kas_remove_dup('state', kas_resultObject);
			var zip = kas_remove_dup('zip', kas_resultObject);
			var category = kas_remove_dup('category', kas_resultObject);
			var rating = kas_remove_dup('rating', kas_resultObject);
			
			
			if (jQuery(".kas_country").length){ 
				kas_SelectElement('country',country[0]);
			}	
			if (jQuery(".kas_state").length){ 
				kas_SelectElement('state',state[0]);
			}
			
			// create options
			var zip = kas_option_generator('Zip..','','',zip);	
			var category = kas_option_generator('Vendor Category..','','',category,1);	
			var rating = kas_option_generator('Rating..','','',rating);	
			var store = kas_option_generator('Store Name..','store_link','store_name',kas_resultObject);				

			jQuery('.kas_zip').html(zip);
			jQuery('.kas_category').html(category);
			jQuery('.kas_rating').html(rating);
			jQuery('.kas_store').html(store);
	
		}
	}		

	
	
	/**
	 * set fields by zip.
	 * 
	 * @since 1.2.3
	 */	
	function kas_set_by_zip(){
		var kas_zip_str = jQuery( ".kas_zip" ).val();
			
		if(kas_zip_str){
			
			var kas_resultObject = kas_search('zip',kas_zip_str, kas_searchList);
			var country = kas_remove_dup('country', kas_resultObject);	
			var state = kas_remove_dup('state', kas_resultObject);	
			var city = kas_remove_dup('city', kas_resultObject);	
			var category = kas_remove_dup('category', kas_resultObject);	
			var rating = kas_remove_dup('rating', kas_resultObject);
			
			
			if (jQuery(".kas_country").length){ 
				kas_SelectElement('country',country[0]);
			}	
			if (jQuery(".kas_state").length){ 
				kas_SelectElement('state',state[0]);
			}	
			if (jQuery(".kas_city").length){ 
				kas_SelectElement('city',city[0]);
			}
			
			// create options
			var category = kas_option_generator('Vendor Category..','','',category,1);	
			var rating = kas_option_generator('Rating..','','',rating);	
			var store = kas_option_generator('Store Name..','store_link','store_name',kas_resultObject);				
			
			jQuery('.kas_category').html(category);
			jQuery('.kas_rating').html(rating);
			jQuery('.kas_store').html(store);
	
		}
	}		

	
	
	/**
	 * set fields by zip.
	 * 
	 * @since 1.2.4
	 */	
	function kas_set_by_category(){
		var kas_category_str = jQuery( ".kas_category" ).val();
			
		if(kas_category_str){
			
			var kas_resultObject = kas_search('category',kas_category_str, kas_searchList);
			var country = kas_remove_dup('country', kas_resultObject);	
			var state = kas_remove_dup('state', kas_resultObject);	
			var city = kas_remove_dup('city', kas_resultObject);	
			var zip = kas_remove_dup('zip', kas_resultObject);	
			var rating = kas_remove_dup('rating', kas_resultObject);
			
			
			if (jQuery(".kas_country").length){ 
				kas_SelectElement('country',country[0]);
			}	
			if (jQuery(".kas_state").length){ 
				kas_SelectElement('state',state[0]);
			}	
			if (jQuery(".kas_city").length){ 
				kas_SelectElement('city',city[0]);
			}	
			if (jQuery(".kas_zip").length){ 
				kas_SelectElement('zip',zip[0]);
			}
			
			// create options	
			var rating = kas_option_generator('Rating..','','',rating);	
			var store = kas_option_generator('Store Name..','store_link','store_name',kas_resultObject);				

			jQuery('.kas_rating').html(rating);
			jQuery('.kas_store').html(store);
	
		}
	}		

	
	
	/**
	 * set fields by rating.
	 * 
	 * @since 1.2.6
	 */	
	function kas_set_by_rating(){
		var kas_rating_str = jQuery( ".kas_rating" ).val();
			
		if(kas_rating_str){
			
			var kas_resultObject = kas_search('rating',kas_rating_str, kas_searchList);
			var country = kas_remove_dup('country', kas_resultObject);	
			var state = kas_remove_dup('state', kas_resultObject);	
			var city = kas_remove_dup('city', kas_resultObject);	
			var zip = kas_remove_dup('zip', kas_resultObject);	
			var category = kas_remove_dup('category', kas_resultObject);
			
			
			if (jQuery(".kas_country").length){ 
				kas_SelectElement('country',country[0]);
			}	
			if (jQuery(".kas_state").length){ 
				kas_SelectElement('state',state[0]);
			}	
			if (jQuery(".kas_city").length){ 
				kas_SelectElement('city',city[0]);
			}	
			if (jQuery(".kas_zip").length){ 
				kas_SelectElement('zip',zip[0]);
			}/*	
			if (jQuery(".kas_category").length){ 
				kas_SelectElement('category',category[0]);
			}*/
			
			// create options		
			var store = kas_option_generator('Store Name..','store_link','store_name',kas_resultObject);				

			jQuery('.kas_store').html(store);
	
		}
	}			

jQuery(document).ready(function(){
	
if(jQuery(".kas_search").length || jQuery('.kas_search_aio').length){
		switch(kas_select2_01) {
		    case 1:
				jQuery.fn.select2.defaults.set( "theme", "classic" );
					if(jQuery(".kas_country").length){
						jQuery(".kas_country").select2();
					}
					if(jQuery(".kas_state").length){
						jQuery(".kas_state").select2();
					}
					if(jQuery(".kas_city").length){
						jQuery(".kas_city").select2();
					}
					if(jQuery(".kas_zip").length){
						jQuery(".kas_zip").select2();
					}
					if(jQuery(".kas_category").length){
						jQuery(".kas_category").select2();
					}
					if(jQuery(".kas_store").length){
						jQuery(".kas_store").select2();
					}
					if(jQuery(".kas_aio").length){
						jQuery(".kas_aio").select2();
					}
		        break;
		    case 2:
		    		jQuery.fn.select2.defaults.set( "theme", "bootstrap" );
					if(jQuery(".kas_country").length){
						jQuery(".kas_country").select2();
					}
					if(jQuery(".kas_state").length){
						jQuery(".kas_state").select2();
					}
					if(jQuery(".kas_city").length){
						jQuery(".kas_city").select2();
					}
					if(jQuery(".kas_zip").length){
						jQuery(".kas_zip").select2();
					}
					if(jQuery(".kas_category").length){
						jQuery(".kas_category").select2();
					}
					if(jQuery(".kas_store").length){
						jQuery(".kas_store").select2();
					}
					if(jQuery(".kas_aio").length){
						jQuery(".kas_aio").select2();
					}
		        break;
		    case 3:
				jQuery.fn.select2.defaults.set( "theme", "custom" );
				if(jQuery(".kas_country").length){
					jQuery(".kas_country").select2();
				}
				if(jQuery(".kas_state").length){
					jQuery(".kas_state").select2();
				}
				if(jQuery(".kas_city").length){
					jQuery(".kas_city").select2();
				}
				if(jQuery(".kas_zip").length){
					jQuery(".kas_zip").select2();
				}
				if(jQuery(".kas_category").length){
					jQuery(".kas_category").select2();
				}
				if(jQuery(".kas_store").length){
					jQuery(".kas_store").select2();
				}
				if(jQuery(".kas_aio").length){
					jQuery(".kas_aio").select2();
				}
		    break;
		    default:
				if(jQuery(".kas_country").length){
					jQuery(".kas_country").select2();
				}
				if(jQuery(".kas_state").length){
					jQuery(".kas_state").select2();
				}
				if(jQuery(".kas_city").length){
					jQuery(".kas_city").select2();
				}
				if(jQuery(".kas_zip").length){
					jQuery(".kas_zip").select2();
				}
				if(jQuery(".kas_category").length){
					jQuery(".kas_category").select2();
				}
				if(jQuery(".kas_store").length){
					jQuery(".kas_store").select2();
				}
				if(jQuery(".kas_aio").length){
					jQuery(".kas_aio").select2();
				}
		}	
	
	/**
	 * onChange Country Dprodown.
	 * 
	 * @since 1.0.0
	 */
	if (jQuery(".kas_country").length){ 
		
		jQuery('.kas_country').on('change', function (){
			kas_set_by_country();
		});
	}

	/**
	 * onChange state Dropdown.
	 * 
	 * @since 1.0.0
	 */
	if (jQuery(".kas_state").length){ 
		jQuery('.kas_state').on('change', function (){
			kas_set_by_state();
		});
	}
	
	/**
	 * onChangeg city Dropdown.
	 * 
	 * @since 1.0.0
	 */
	if (jQuery(".kas_city").length){ 
		jQuery('.kas_city').on('change', function (){
			kas_set_by_city();
		});
	}
	
	/**
	 * onChangeg city Dropdown.
	 * 
	 * @since 1.2.3
	 */
	if (jQuery(".kas_zip").length){ 
		jQuery('.kas_zip').on('change', function (){
			kas_set_by_zip();
		});
	}
	
	/**
	 * onChangeg category Dropdown.
	 * 
	 * @since 1.2.4
	 */
	if (jQuery(".kas_category").length){ 
		jQuery('.kas_category').on('change', function (){
			kas_set_by_category();
		});
	}
	
	/**
	 * onChangeg city Dropdown.
	 * 
	 * @since 1.2.6
	 */
	if (jQuery(".kas_rating").length){ 
		jQuery('.kas_rating').on('change', function (){
			kas_set_by_rating();
		});
	}
	
	/**
	 * onChange store dropdown.
	 * 
	 * @since 1.0.0
	 */
	if (jQuery(".kas_store").length){ 
		jQuery('.kas_store').on('change', function (){
			
			var kas_store_str = jQuery( ".kas_store" ).val();
			kas_store_str = kas_store_str.replace(/\s+/g, '-').toLowerCase();
			// alert(kas_store_str);
			// redirect
			window.location = kas_store_str;
			jQuery('.kas_loader').css('display', 'block');

		});
	}
	
	/**
	 * onChange searchtype.
	 * 
	 * @since 1.2.6
	 */
	if (jQuery(".query_type").length){ 
		jQuery('.query_type').on('change', function (){
			
			var kas_type = jQuery( ".query_type" ).val();
		    if(kas_type.trim() === 'products'){
		    	//slider-range
		    	jQuery(".kas_price_range").css("display", "block");
		    	jQuery("#slider-range").css("display", "block");
			}else{
		    	jQuery(".kas_price_range").css("display", "none");
		    	jQuery("#slider-range").css("display", "none");
			}	
		    
		});
	}
	
	/**
	 * onChange single dropdown.
	 * 
	 * @since 1.0.0
	 */	
	if(jQuery(".kas_aio").length){
		jQuery('.kas_aio').on('change', function (){
			var kas_single_str = jQuery( ".kas_aio" ).val();
			kas_single_str = kas_single_str.replace(/\s+/g, '-').toLowerCase();
			// alert(kas_store_str);
			// redirect
			window.location = kas_single_str;
			jQuery('.kas_loader').css('display', 'block');
		});
	}	
	

	jQuery( ".kas_search" ).submit(function( event ) {
		jQuery('.kas_loader').css('display', 'block');
	});	
	
		if(st_country || st_state || st_city || st_zip || st_category || st_rating){
			if(st_country){
				jQuery('.kas_country').val(st_country).trigger('change');
			}
			if(st_state){
				jQuery('.kas_state').val(st_state).trigger('change');
			}
			if(st_city){
				jQuery('.kas_city').val(st_city).trigger('change');
			}
			if(st_zip){
				jQuery('.kas_zip').val(st_zip).trigger('change');
			}
			if(st_category){
				jQuery('.kas_category').val(st_category).trigger('change');
			}
			if(st_rating){
				jQuery('.kas_rating').val(st_rating).trigger('change');
			}
		}
}
});