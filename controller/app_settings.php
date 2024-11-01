<?php 

class AppSettingsController {
	
    public function __construct(){
       $this->namespace     = 'api/tc_settings';				
	}
	
	public function tc_app_routes() {

        register_rest_route( $this->namespace, '/app_all_settings', array(
            array(
                'methods'   => 'GET',
                'callback'  => array( $this, 'app_all_settings' ),
				'permission_callback' => '__return_true'
            ),
        ));
		
		register_rest_route( $this->namespace, '/app_all_banners', array(
            array(
                'methods'   => 'GET',
                'callback'  => array( $this, 'app_all_banners' ),
				'permission_callback' => '__return_true'
            ),
        ));
		
		register_rest_route( $this->namespace, '/app_product_review', array(
            array(
                'methods'   => 'POST',
                'callback'  => array( $this, 'app_product_review' ),
				'permission_callback' => '__return_true'
            ),
        ));
		
		register_rest_route( $this->namespace, '/app_filter_products', array(
            array(
                'methods'   => 'POST',
                'callback'  => array( $this, 'app_filter_products' ),
				'permission_callback' => '__return_true'
            ),
        ));
		
		register_rest_route( $this->namespace, '/app_get_attributes', array(
            array(
                'methods'   => 'POST',
                'callback'  => array( $this, 'app_get_attributes' ),
				'permission_callback' => '__return_true'
            ),
        ));
		
		register_rest_route( $this->namespace, '/app_data_link', array(
            array(
                'methods'   => 'POST',
                'callback'  => array( $this, 'app_data_link' ),
				'permission_callback' => '__return_true'
            ),
        ));
		
		register_rest_route( $this->namespace, '/app_get_tax', array(
            array(
                'methods'   => 'POST',
                'callback'  => array( $this, 'app_get_tax' ),
				'permission_callback' => '__return_true'
            ),
        ));
		
		register_rest_route( $this->namespace, '/app_vendor_info', array(
            array(
                'methods'   => 'POST',
                'callback'  => array( $this, 'app_vendor_info' ),
				'permission_callback' => '__return_true'
            ),
        ));
		
		register_rest_route( $this->namespace, '/app_vendor_products', array(
            array(
                'methods'   => 'POST',
                'callback'  => array( $this, 'app_vendor_products' ),
				'permission_callback' => '__return_true'
            ),
        ));
		
		register_rest_route( $this->namespace, '/app_featured_dokan_vendors_list', array(
            array(
                'methods'   => 'POST',
                'callback'  => array( $this, 'app_featured_dokan_vendors_list' ),
				'permission_callback' => '__return_true'
            ),
        ));
		
		register_rest_route( $this->namespace, '/app_vendor_bank_info', array(
            array(
                'methods'   => 'POST',
                'callback'  => array( $this, 'app_vendor_bank_info' ),
				'permission_callback' => '__return_true'
            ),
        ));
		
		register_rest_route( $this->namespace, '/app_all_currencies', array(
            array(
                'methods'   => 'POST',
                'callback'  => array( $this, 'app_all_currencies' ),
				'permission_callback' => '__return_true'
            ),
        ));
		
		register_rest_route( $this->namespace, '/app_geofencing_posts', array(
            array(
                'methods'   => 'GET',
                'callback'  => array( $this, 'app_geofencing_posts' ),
				'permission_callback' => '__return_true'
            ),
        ));
		
		register_rest_route( $this->namespace, '/app_featured_wcvendors_list', array(
            array(
                'methods'   => 'GET',
                'callback'  => array( $this, 'app_featured_wcvendors_list' ),
				'permission_callback' => '__return_true'
            ),
        ));	
		
		register_rest_route( $this->namespace, '/app_all_pro_vendors_info', array(
            array(
                'methods'   => 'GET',
                'callback'  => array( $this, 'app_all_pro_vendors_info' ),
				'permission_callback' => '__return_true'
            ),
        ));
		
		register_rest_route( $this->namespace, '/app_single_pro_vendor_store_info', array(
            array(
                'methods'   => 'POST',
                'callback'  => array( $this, 'app_single_pro_vendor_store_info' ),
				'permission_callback' => '__return_true'
            ),
        ));
		
		register_rest_route( $this->namespace, '/app_single_pro_vendor_products', array(
            array(
                'methods'   => 'POST',
                'callback'  => array( $this, 'app_single_pro_vendor_products' ),
				'permission_callback' => '__return_true'
            ),
        ));
		
    }
	
  	public function app_all_settings(){
		global $wpdb; 

		if(get_option( 'tc_ecommerce_app_settings')) { 
			$all_settings = get_option( 'tc_ecommerce_app_settings');
		}
		$all_settings['privacy_page'] = nl2br($all_settings['privacy_page']);	
		$all_settings['refund_page']  = nl2br($all_settings['refund_page']);
		$all_settings['terms_page']   = nl2br($all_settings['terms_page']);	
		$all_settings['about_page']   = nl2br($all_settings['about_page']);
		$all_settings['custom_css_for_checkout'] = stripslashes($all_settings['custom_css_for_checkout']);	
		$all_settings['checkout_process'] = get_option('woocommerce_enable_guest_checkout');	
		
		if(isset($get_cur)){
			foreach($get_cur as $dcur ){ 
				if($dcur['is_etalon'] == 1){
					foreach($dcur as $key => $value){ 
						$all_settings['currency'][$key] = esc_attr($value);					
					}
			 	}
		  	 }
		}else{
			$all_settings['currency']['name'] 	  = get_option('woocommerce_currency');
			$all_settings['currency']['position'] = get_option('woocommerce_currency_pos');
		}
		
			if (class_exists('SitePress')) {  
		 	$languages = apply_filters( 'wpml_active_languages', NULL, 'orderby=id&order=desc' );
			foreach( $languages as $la  ) {
			    if($la['active'] == 1){
    			    foreach($la as $key => $value){
        				$all_settings['language'][$key] = esc_attr($value);
    			    }
			    }
			}
		}else{
			$all_settings['language']['name'] = get_locale();
		}
		
		return $all_settings;		
		}
		
	public function app_all_banners(){
        global $wpdb; 	
		$get_data_qry =  "SELECT * FROM `".TCVC_APP_BANNERS_SETTINGS."` order by `banners_order` asc";
		$all_banners  = $wpdb->get_results($get_data_qry);		
		return array('data'=>$all_banners);		
    }
	
	public function app_product_review(){		
		$get_data	 	= file_get_contents('php://input');
        $arguments 		= json_decode($get_data, TRUE);
		
		$product_id		= $arguments['product_id'];
		$rate_star		= $arguments['rate_star'];
		$author_name	= $arguments['author_name'];
		$author_email	= $arguments['author_email'];
		$author_content	= $arguments['author_content'];	
		$ratestar 		= floatval($rate_star);	
		
		if(!isset($product_id)){ return new WP_Error('empty_product_id', __('<strong>ERROR</strong>: Empty Product Id.')); }
		if(!isset($rate_star)){ return new WP_Error('empty_rating', __('<strong>ERROR</strong>: Empty rating values.')); }
		if ( $ratestar < 1 || $ratestar > 5 ){ return new WP_Error('invalid_rating', __('<strong>ERROR</strong>: Please choose rating 1 to 5.')); }
		if(!isset($author_name)){ return new WP_Error('empty_author', __('<strong>ERROR</strong>: Empty Author Name.')); }
		if(!isset($author_email)){ return new WP_Error('empty_email', __('<strong>ERROR</strong>: Empty Author Email.')); }
		if(!is_email($author_email)){return new WP_Error('invalid_email', __('<strong>ERROR</strong>: Invalid Author Email.')); }
		if(!isset($author_content)){ return new WP_Error('empty_content', __('<strong>ERROR</strong>: Empty Author Content.')); }
					

			
		if(isset($arguments['user_id'])){	
			$user_id        = $arguments['user_id'];
		}else {
			$user_id ='';
		}
		
		$checkcontent = str_replace(" ","",$author_content);
		$lengcontent  = strlen($checkcontent);
		if ( $lengcontent == 0 ) {
				return new WP_Error('require_valid_comment', __('<strong>ERROR</strong>: Please Write  a Message.'));
			}						
				
		$checkapproved  = get_option('comment_moderation');	
		$checkwhitelist = get_option('comment_whitelist');	
		
		if($checkapproved == 1){
				$approved = 0;
		}else{
			if($checkwhitelist == 1){
				if(!empty($author_email)){
					global  $wpdb;
					$table  = $wpdb->prefix.'comments';
					$checks = $wpdb->get_results("SELECT * FROM $table WHERE comment_author_email = '$author_email' AND comment_approved = 1",OBJECT);
					if(!empty($checks)){
						$approved = 1;
					}else{
						$approved = 0;
					}
				}else{
					$approved = 0;
				}
			}else{
				$approved = 1;		
			}
		}
		
		$author_ip = sanitize_text_field($_SERVER['REMOTE_ADDR']);
		$user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? sanitize_text_field($_SERVER['HTTP_USER_AGENT']) : false;		
			
		$productid	= $product_id;
		$product 	= wc_get_product($productid);
		$reviews_allowed = $product->get_reviews_allowed();
		$time = current_time('mysql');	
		if(isset($reviews_allowed)){
			
			$data = array(
					'comment_post_ID' => $productid,
					'comment_author' => $author_name,
					'comment_author_email' => $author_email,
					'comment_author_url' => '',
					'comment_content' => $author_content,
					'comment_type' => '',
					'comment_parent' => 0,
					'comment_karma' => 1,
					'user_id' => $user_id,
					'comment_author_IP' => $author_ip,
					'comment_agent' => $user_agent,
					'comment_date' => $time,
					'comment_approved' => $approved,
					'comment_meta' => array(
						'rating' => $ratestar,
						'verified' => 0
					)
				);		
				
			wp_insert_comment($data);
			
			$reviews_done =  array(
				'status' => 'ok',
				'message' => 'Added a comment successfully.'
			);			
			return $reviews_done;			
		}else{
			$json_api->error("This Products is not allowed to comment.", 403);
			return new WP_Error('Comment_not_allow', __('<strong>ERROR</strong>: This Product not allow comment.'));
		}		
	 } 
	 
	public function app_filter_products(){
		$get_data	 	= file_get_contents('php://input');
        $arguments 		= json_decode($get_data, TRUE);
				
		$metaquery 	   = array();
		$taxquery 	   = array();	

		$page	   	   = $arguments['page'];
		$order	   	   = $arguments['order'];
		$orderby	   = $arguments['orderby'];	

		if(isset($order)) {$order_li = $order;}else{$order_li = 'desc';}
		if(isset($orderby)) {$orderby_li = $orderby;}else{$orderby_li = 'date';}
		if(isset($page)){$post_per_page = $page;}else{$post_per_page = '1';}

		$url           = parse_url(sanitize_text_field($_SERVER['REQUEST_URI']));
		$querya        = wp_parse_args($url['query']);
		
		$tquery     = array('taxonomy' => 'product_visibility' , 'field' => 'name'  , 'terms' => 'exclude-from-catalog' , 'operator' => 'NOT IN',);
		$taxquery[] = $tquery;
		
		foreach($querya as $key => $value){
			if($key != 'insecure'){ 
				if($key == 'min_price'){
					$mquery = array('key' => '_price','value' => $value, 'type' => 'numeric', 'compare' => '>=');
					$metaquery[]= $mquery;
				}
				if($key == 'max_price') {
					$mquery = array('key' => '_price','value' => $value, 'type' => 'numeric', 'compare' => '<=');
					$metaquery[] = $mquery;
				}
				if($key == 'on_sale') {
					$mquery = array('key' => '_sale_price', 'value' => 0, 'type' => 'numeric', 'compare' => '>');
					$metaquery[] = $mquery;
				}	
				if($key == 'cat_id') { $cat_id = $value;
					$cquery = array('taxonomy'  => 'product_cat', 'field' => 'id', 'terms' => $cat_id);
					$taxquery[] = $cquery;					
				}
				if($key == 'featured') {
					$fquery  = array('taxonomy' => 'product_visibility' , 'field' => 'name'  , 'terms' => 'featured' , 'operator' => 'IN');
					$taxquery[] = $fquery;
				}
								
				$fil_att = explode('_',$key);
				
				if ($fil_att[0] == 'pa') { $get_val = explode(",",$value);
					$tquery  = array('taxonomy' => $key , 'field' => 'slug'  , 'terms' => $get_val);
					$taxquery[] = $tquery;
				}
			}
		}			
		
		$args = array(
			'post_type'              => array('product'),
			'orderby'                => $orderby_li,
			'order'                  => $order_li,		
			'paged' 		 		 => $post_per_page,
			'posts_per_page'		 => 10,
			'post_status' 			 => 'publish',
			'meta_query'             => $metaquery,
			'tax_query'				 => $taxquery,
		);	
		 
		$loop = new WP_Query( $args );
		
	 	$count = $loop->post_count;	
		$product_ids = array(); 
		while ( $loop->have_posts() ) : $loop->the_post();
				$product_ids[] =  $loop->post->ID;
		endwhile; 		
		
		return array('data'=>$product_ids); 
	}
	
	public function app_get_attributes(){
		
		global $woocommerce, $post, $product , $wpdb;
		
		$metaquery 	   = array();
		$taxquery 	   = array();
		
		$url           = parse_url(sanitize_text_field($_SERVER['REQUEST_URI']));
		$querya        = wp_parse_args($url['query']);
		
		$tquery     = array('taxonomy' => 'product_visibility' , 'field' => 'name'  , 'terms' => 'exclude-from-catalog' , 'operator' => 'NOT IN',);
		$taxquery[] = $tquery;		
						
		foreach($querya as $key => $value){
			if($key != 'insecure'){ 
				if($key == 'min_price'){
					$mquery = array('key' => '_price','value' => $value, 'type' => 'numeric', 'compare' => '>=');
					$metaquery[]= $mquery;
				}
				if($key == 'max_price') {
					$mquery = array('key' => '_price','value' => $value, 'type' => 'numeric', 'compare' => '<=');
					$metaquery[] = $mquery;
				}
				if($key == 'on_sale') {
					$mquery = array('key' => '_sale_price', 'value' => 0, 'type' => 'numeric', 'compare' => '>');
					$metaquery[] = $mquery;
				}	
				if($key == 'cat_id') { $cat_id = $value;
					$cquery = array('taxonomy'  => 'product_cat', 'field' => 'id', 'terms' => $cat_id);
					$taxquery[] = $cquery;					
				}
				if($key == 'featured') {
					$fquery  = array('taxonomy' => 'product_visibility' , 'field' => 'name'  , 'terms' => 'featured' , 'operator' => 'IN');
					$taxquery[] = $fquery;
				}
								
				$fil_att = explode('_',$key);
				
				if ($fil_att[0] == 'pa') { $get_val = explode(",",$value);
					$tquery  = array('taxonomy' => $key , 'field' => 'slug'  , 'terms' => $get_val);
					$taxquery[] = $tquery;
				}
			}
		}	
		
		$args = array(
			'post_type' 		=> 'product',
			'orderby'   		=> 'title',				
			'posts_per_page' 	=> -1,
			'post_status' 		=> 'publish',
			'meta_query'        => $metaquery,
			'tax_query'			=> $taxquery,
		);
		
		
		 
		$loop   = new WP_Query( $args );			
	 	$count  = $loop->post_count;	
		$attributes_lists  	= array();
		$attrib_list_array  = array();
		$price_lists = array();
		while ( $loop->have_posts() ) : $loop->the_post(); 
		global $product; 	
		
		if($product->is_on_sale()){$have_on_sale = "True";}
		if($product->is_featured()){$have_featured = "True";}
		if($product->is_type( 'variable')){
			$all_children_id = $product->get_children();
			if(isset($all_children_id)){
				foreach($all_children_id as $key => $value){
					if($product->is_on_sale()){
						$price_lists[] = get_post_meta($value , '_sale_price' , true);
					}else{
						$price_lists[] = get_post_meta($value , '_regular_price' , true);
					}
				}
			}
		}else {
			if($product->is_on_sale()){
				$price_lists[] = get_post_meta($loop->post->ID , '_sale_price' , true);
			}else{
				$price_lists[] = get_post_meta($loop->post->ID , '_regular_price' , true);
			}
		}
		
		if($product->is_type( 'variable')){ 		
			$pid[] = $loop->post->ID;			
			$attributes_lists = get_post_meta($loop->post->ID , '_product_attributes' , true);			
			foreach($attributes_lists as $attrib_names){
				if($attrib_names['is_taxonomy'] == 1){
					$attrib_list_array[] = $attrib_names['name'];
				}
			}			
		}				
		endwhile;	
		
			
		$attrib_unique_val_list = array();
		$attribute = array();
		
		$price_lists =  array_filter($price_lists);
		sort($price_lists); 
		$pricelength = count($price_lists)-1;
		$min_price = $price_lists[0];
		$max_price = $price_lists[$pricelength];
		
		$count_products    = count($pid);
		$count_attribut    = count($attrib_list_array);
		$attrib_unique_val = array_unique($attrib_list_array);
		
		if(!isset($have_on_sale) && $have_on_sale == ""){$have_on_sale = "False";}
		if(!isset($have_featured) && $have_featured == ""){$have_on_sale = "False";}
		
		$attrib_unique_val_list['min_price']		  =	$min_price;
		$attrib_unique_val_list['max_price']		  =	$max_price;
		$attrib_unique_val_list['on_sale']			  =	$have_on_sale;
		$attrib_unique_val_list['featured']			  =	$have_featured;
		
			
		if($count_products >= 1){				
			foreach($attrib_unique_val as $att_name){		
				$terms_all = array();
				foreach($pid as $pro_id){
					$terms_all[] = wp_get_post_terms($pro_id , $att_name);				
				}			
				 $aterms    = array();
				 $aterm_lst = array();
				foreach($terms_all as $term_data){
					foreach($term_data as $terms_uni){
						if(in_array($terms_uni->name, $aterms)){
						}
						else{
							$aterms[]    = $terms_uni->name;
							$aterm_lst[] = $terms_uni;
						}
					}
				}
				$str_ex = explode('pa_' , $att_name); 
				$all_attributes_list_here = wc_get_attribute_taxonomies();
				foreach($all_attributes_list_here as $atti_lst_match){
					if($atti_lst_match->attribute_name == $str_ex[1]){
						$att_label = $atti_lst_match->attribute_label; 
					}
				}
				$attribute_list['attribute_name']     = $att_label;
				$attribute_list['attribute_slug']     = $att_name;
				$attribute_list['attribute_terms']    = $aterm_lst;
				$attrib_unique_val_list['attributes'][] = $attribute_list;
				
			}		
		}else {
			$attrib_unique_val_list['status'] = "ok";
			$attrib_unique_val_list['message'] = "Sorry No Attribute Found";
		}
		
		return $attrib_unique_val_list;		
	}
	
	public function app_data_link(){
		global $wpdb;		
		$data_link = addslashes(file_get_contents("php://input"));
		$insert_data_link = "insert into `".TCVC_APP_ORDER_DATA."` set `data_link`='".$data_link."'";		
		$wpdb->query($insert_data_link);
		if(isset($wpdb->insert_id)){ $data_id = $wpdb->insert_id; }	
		return $data_id;
	}
	
	public function app_get_tax(){
		global $wpdb , $woocommerce , $product;
		
		$calculate_tax = get_option('woocommerce_calc_taxes');
		
		if(isset($calculate_tax) && $calculate_tax == 'yes'){
		
		    $gorder = sanitize_text_field($_GET['order']);
			if(isset($gorder)){
				$order_data = urldecode($gorder);	
				$order_data = "[".stripslashes($gorder)."]";
				$order_data = json_decode($order_data,false);
			}
			
			foreach($order_data[0] as $key => $value){
				$$key = sanitize_text_field($value);
			}
			
			if (isset($shipping_ids)) {
				foreach($shipping_ids as $ship_id){
					$shipping_methods = $ship_id->method_id;
					$shipping_rate    = $ship_id->rate;
				}
			}
			
			$tax_based_on  = get_option('woocommerce_tax_based_on');
			
			$tax = new WC_Tax();
			if(isset($tax_based_on) && $tax_based_on == 'shipping'){
				$country_code = $shipping_info->country;
				$post_code    = $shipping_info->postcode;
				$city_code    = $shipping_info->city;
				$state_code   = $shipping_info->state;
			}elseif(isset($tax_based_on) && $tax_based_on == 'billing') {
				$country_code = $billing_info->country;
				$post_code    = $billing_info->postcode;
				$city_code    = $billing_info->city;
				$state_code   = $billing_info->state;			
			}elseif(isset($tax_based_on) && $tax_based_on == 'base'){ 
				$default_cou  = get_option('woocommerce_default_country');
				$get_co_st    = explode(':',$default_cou);
				$country_code = $get_co_st[0];
				$post_code    = get_option('woocommerce_store_postcode');
				$city_code    = get_option('woocommerce_store_city');
				$state_code   = $get_co_st[1];							
			}
			
			$prices_inc_tax   = get_option('woocommerce_prices_include_tax');
			
			if(isset($prices_inc_tax) && $prices_inc_tax == 'yes'){
					$default_st_add    = get_option('woocommerce_default_country');
					$get_cou_sta       = explode(':',$default_st_add);
					$country_code_base = $get_cou_sta[0];
					$post_code_base    = get_option('woocommerce_store_postcode');
					$city_code_base    = get_option('woocommerce_store_city');
					$state_code_base   = $get_cou_sta[1];		
				}	
			
			$rates_base = $tax->find_rates( array( 'country' => $country_code_base , 'city' => $city_code_base , 'postcode' => $post_code_base , 'state' => $state_code_base) );
			//print_r($rates_base);			
			$count_base_rates = count($rates_base);
				
			if(isset($count_base_rates) && $count_base_rates >= 1){
				
				foreach( $rates_base as $rate_ba ){
					$tax_rate_name_base  = $rate_ba['label'];
					$tax_rate_value_base = $rate_ba['rate'];
					$tax_ship_value_base = $rate_ba['shipping'];
				}
			}
				
						
			$rates = $tax->find_rates( array( 'country' => $country_code , 'city' => $city_code , 'postcode' => $post_code , 'state' => $state_code) );	
			//print_r($rates);		
			$count_rates = count($rates);
			
			if(isset($count_rates) && $count_rates >= 1){
				
				foreach( $rates as $rate ){
					$tax_rate_name  = $rate['label'];
					$tax_rate_value = $rate['rate'];
					$tax_ship_value = $rate['shipping'];
				}
						
			
				$total_tax = "";
				if(isset($prices_inc_tax) && $prices_inc_tax == 'no'){
					foreach ($products as $single_item) { 
						$product_id  = $single_item->product_id;	
						$product_qt  = $single_item->quantity;
						$product_pri = $single_item->price;	
						$product_vr  = $single_item->variation_id;
						
						if(isset($product_vr)){
							$product_id = $product_vr;
						}							
					
						$sin_product = wc_get_product($product_id); 
										
						$tax_status   = $sin_product->tax_status;
						$tax_class    = $sin_product->tax_class;
					
						if($tax_status == "taxable"){
							if(isset($tax_class) && $tax_class != "" && $tax_class != 'null'){
								$pro_taxes = $tax->get_rates($tax_class); 
								foreach($pro_taxes as $sprotax){
									$tax_rate_value1 =  $sprotax['rate'];					
								}
								$total_tax += ($product_pri*$product_qt)*$tax_rate_value1/100;
							}else {
								$total_tax += ($product_pri*$product_qt)*$tax_rate_value/100;
							}
						}else{
							$total_tax += ($product_pri*$product_qt)*$tax_rate_value/100;
						}						
					}	
					
					if(isset($tax_ship_value) && $tax_ship_value == "yes"){
						$total_tax += $shipping_rate*$tax_rate_value/100;
					}							
				}
				elseif(isset($prices_inc_tax) && $prices_inc_tax == 'yes'){ 
				
					foreach ($products as $single_item) { 
						$product_id = $single_item->product_id;	
						$product_qt = $single_item->quantity;
						$product_pri = $single_item->price;	
						$product_vr = $single_item->variation_id;
						
						if(isset($product_vr)){
							$product_id = $product_vr;
						}								
					
						$sin_product = wc_get_product($product_id); 
										
						$tax_status   = $sin_product->tax_status;
						$tax_class    = $sin_product->tax_class;
						
						if(isset($tax_based_on) && $tax_based_on == 'base'){
							if($tax_status == "taxable"){
								if(isset($tax_class) && $tax_class != "" && $tax_class != 'null'){
									$pro_taxes = $tax->get_rates($tax_class); 
									foreach($pro_taxes as $sprotax){
											$tax_rate_value1 =  $sprotax['rate'];					
									}
									$total_tax += ($product_pri*$product_qt) - (($product_pri / (( $tax_rate_value1/100)+1))*$product_qt);
								}else {
									$total_tax += ($product_pri*$product_qt) - (($product_pri / (( $tax_rate_value/100)+1))*$product_qt);
								}
							}else{
								$total_tax += ($product_pri*$product_qt) - (($product_pri / (( $tax_rate_value/100)+1))*$product_qt);
							}							
						}
						elseif(isset($tax_based_on) && ($tax_based_on == 'billing' || $tax_based_on == 'shipping' )){
							
							if($tax_status == "taxable"){
								if(isset($tax_class) && $tax_class != "" && $tax_class != 'null'){
									$pro_taxes = $tax->get_rates($tax_class); 
									foreach($pro_taxes as $sprotax){
											$tax_rate_value2 =  $sprotax['rate'];					
									}
									
									$pro_taxes_base = $tax->get_rates($tax_class); 
									foreach($pro_taxes_base as $sbaseprotax){
											$tax_rate_value1 =  $sbaseprotax['rate'];					
									}
									
									$product_price_cal = (($product_pri / (( $tax_rate_value2/100)+1))*$product_qt);
									$total_tax += ($product_price_cal*$product_qt) * $tax_rate_value1/100;
								}else {
									$product_price_cal = (($product_pri / (( $tax_rate_value_base/100)+1))*$product_qt);
									$total_tax += ($product_price_cal*$product_qt) * $tax_rate_value/100;
								}
							}else{
								$product_price_cal = (($product_pri / (( $tax_rate_value_base/100)+1))*$product_qt);
								$total_tax += ($product_price_cal*$product_qt) * $tax_rate_value/100;
							}							
						}
					}
					
					if(isset($tax_based_on) && $tax_based_on == 'base'){
						if(isset($tax_ship_value_base) && $tax_ship_value_base == "yes"){
							$total_tax += $shipping_rate*$tax_rate_value/100;
						}
					}elseif(isset($tax_based_on) && ($tax_based_on == 'billing' || $tax_based_on == 'shipping' )){
						if(isset($tax_ship_value_base) && $tax_ship_value_base == "yes"){
							$total_tax += $shipping_rate*$tax_rate_value_base/100;
						}
					}
					
									
				}
				
				return round($total_tax ,2);		
			
			}else {
				return new WP_Error('tax_rates', __('<strong>ERROR</strong>: Tax rates not defined.'));
			}		
		}else{
			return new WP_Error('tax_rates', __('<strong>ERROR</strong>: Please Enable tax rates and calculations in woocommerce settings.'));
		}	
	}
	
	public function app_vendor_info(){
		global $wpdb , $post , $product , $woocommerce;
		
		$gen_data 	= file_get_contents('php://input');
        $arguments 	= json_decode($gen_data, TRUE);
		
		$product_id = $arguments['product_id'];			
	    if(!isset($product_id)){return new WP_Error('product_id', __('<strong>ERROR</strong>: Product Id Required.'));}	
		
		$postdata = get_postdata($product_id);
		$authorID = $postdata['Author_ID'];

		  $user_id  				= get_userdata($authorID);
		  $fuser['user_id']   		= $user_id->ID;
		  $fuser['username']  		= $user_id->user_login;
		  $fuser['first_name'] 		= $user_id->first_name;
		  $fuser['last_name']  		= $user_id->last_name;
		  $fuser['user_email']  	= $user_id->user_email;
		  $fuser['user_nicename']  	= $user_id->user_nicename;
		  $fuser['display_name']  	= $user_id->display_name;
		  $allm       				= array_map( function( $a ){ return $a[0]; }, get_user_meta( $user_id->ID ) ); 
	      $banner_id  				= get_user_meta ($user_id->ID , 'wp_user_avatar');
		  $fuser['banner']  		= wp_get_attachment_url( $banner_id[0] );
          $fuser['meta']    		= $allm;
		  $fusers[] 				= $fuser;
		
		   return array('data'=>$fusers);			
	}
	
	public function app_vendor_products(){
		global $wpdb;
		
		$gen_data 	 = file_get_contents('php://input');
        $arguments 	 = json_decode($gen_data, TRUE);
		
		$post_author = $arguments['post_author'];
		$page  		 = $arguments['page'];
		
		if(!isset($post_author)){return new WP_Error('post_author', __('<strong>ERROR</strong>: Post Author Required.'));}		
		if(isset($page)){$post_per_page = $page;}else{$post_per_page = '1';}

		$args = array(
			'post_type'              => array('product'),		
			'posts_per_page'  		 => 10,
			'post_status' 			 => 'publish',
			'author'			     => $post_author,
			'paged' 		 		 => $post_per_page
		);	
		 
		$loop_vendor = new WP_Query( $args );
			
		$product_ids = array(); 
		while ( $loop_vendor->have_posts() ) : $loop_vendor->the_post();
				$product_ids[] =  $loop_vendor->post->ID;
		endwhile; 		
		
		return  array('data'=>$product_ids);
 
	}
	
	public function app_featured_dokan_vendors_list(){
		global  $wpdb;
		$args = array(
			'role'     => 'seller',
			'order'    => 'ASC',
			'meta_key' => 'dokan_feature_seller',
			'meta_value' => 'yes'
		);
		$users = get_users( $args );
		foreach($users as $user_id){
	      $fuser['user_id']    = $user_id->ID;
		  $fuser['username']   = $user_id->user_login;
		  $fuser['first_name'] = $user_id->first_name;
		  $fuser['last_name']  = $user_id->last_name;
		  $fuser['user_email']  = $user_id->user_email;
		  $fuser['user_nicename']  = $user_id->user_nicename;
		  $fuser['display_name']  = $user_id->display_name;
		  $allm       = get_user_meta ($user_id->ID , 'dokan_profile_settings');
	      $banner_id  = $allm[0]['banner'];
		  $fuser['banner']  = wp_get_attachment_url( $banner_id );
          $fuser['meta']    = $allm;
		  $fusers[] = $fuser;
	    }

		
			return array('data'=>$fusers);		
	}
	
	public function app_vendor_bank_info(){
		global $wpdb;
		
		$gen_data 	 = file_get_contents('php://input');
        $arguments 	 = json_decode($gen_data, TRUE);
		
		$vendor_id	 = $arguments['vendor_id'];
		$ac_name	 = $arguments['ac_name'];
		$ac_number	 = $arguments['ac_number'];
		$bank_name	 = $arguments['bank_name'];
		$iban	 	 = $arguments['iban'];
		$swift	 	 = $arguments['swift'];	
		$bank_addr   = $arguments['bank_addr'];	
		$routing_number  = $arguments['routing_number'];			

		if(!isset($vendor_id)){return new WP_Error('empty_vendor_id', __('<strong>ERROR</strong>: Vendor Id Required.'));}
		if(!isset($ac_name)){return new WP_Error('empty_account_name', __('<strong>ERROR</strong>: Account Title is Required.'));}
		if(!isset($ac_number)){return new WP_Error('empty_account_number', __('<strong>ERROR</strong>: Account Number is Required.'));}
		if(!isset($bank_name)){return new WP_Error('empty_bank_name', __('<strong>ERROR</strong>: Bank Name is Required.'));}
		if(!isset($iban)){return new WP_Error('Iban', __('<strong>ERROR</strong>: International Bank Number is Required.'));}
		if(!isset($swift)){return new WP_Error('swift_code', __('<strong>ERROR</strong>: Swift Bank Code is Required.'));}
		
		$bank  =  array();
		$payment = array();

		$bank['ac_name'] 		= $ac_name;
		$bank['ac_number'] 		= $ac_number;
		$bank['bank_name'] 		= $bank_name;
		$bank['bank_addr'] 		= $bank_addr;
		$bank['routing_number'] = $routing_number;
		$bank['iban'] 			= $iban;
		$bank['swift'] 			= $swift;			  
		$payment['bank'] 		= $bank;		

		$pometa               	= get_user_meta( $vendor_id, 'dokan_profile_settings', true );  
		$uns 					= maybe_unserialize($pometa);

		$uns['payment'] = $payment;      
		maybe_serialize($uns);

		$done = update_user_meta( $vendor_id, 'dokan_profile_settings',$uns );
		  
		if($done){
			$response = array("status" => "ok" , "message" => "User Info Updated Successfully");
		}else {
			$response = array("status" => "ok" , "message" => "Sorry! Here is Something Wrong");
		}
		return  $response;
	 
		}	
		
	public function app_all_currencies(){
		
		global  $wpdb;
		$get_all_curr = get_option( 'woocs');			
		$display_curr_all = array();
			
		foreach($get_all_curr as $gcurr){
			$display_curr_all[] = $gcurr;
		}		
		return  array('data'=>$display_curr_all);
	}
	
	public function app_geofencing_posts() {
		global $wpdb , $post;
		$args = array( 'post_type' => 'geofencing', 'posts_per_page' => 10 );
		$geofencing_ie_data = array();
		$the_query_ie_geo_fencing = new WP_Query( $args ); 
			if ( $the_query_ie_geo_fencing->have_posts() ) : 	
				 while ( $the_query_ie_geo_fencing->have_posts() ) : $the_query_ie_geo_fencing->the_post(); 	
					$geofencing_ie_data_dis['id'] = get_the_id(); 
					$geofencing_ie_data_dis['title'] = get_the_title();
					$geofencing_ie_data_dis['content'] =  apply_filters('the_content', get_the_content()); 
					$geofencing_ie_data_dis['latitude'] = get_post_meta(get_the_id() , 'ae_gf_latitude' , 'false'); 
					$geofencing_ie_data_dis['longitude'] = get_post_meta(get_the_id() , 'ae_gf_longitude' , 'false'); 
					$geofencing_ie_data_dis['radius'] = get_post_meta(get_the_id() , 'ae_gf_radius' , 'false'); 
					$geofencing_ie_data[] = $geofencing_ie_data_dis;
				endwhile;		
		 endif; 
		 return array('data'=>$geofencing_ie_data);
	}
	
	public function app_featured_wcvendors_list(){
		global  $wpdb;
		$args = array(
			'role'     => 'vendor',
			'order'    => 'ASC',
			'meta_key' => 'feature_wcvendor',
			'meta_value' => 'yes'
		);
		$users = get_users( $args );
		foreach($users as $user_id){
	      $fuser['user_id']    = $user_id->ID;
		  $fuser['username']   = $user_id->user_login;
		  $fuser['first_name'] = $user_id->first_name;
		  $fuser['last_name']  = $user_id->last_name;
		  $fuser['user_email']  = $user_id->user_email;
		  $fuser['user_nicename']  = $user_id->user_nicename;
		  $fuser['display_name']  = $user_id->display_name;
		  $allm       = array_map( function( $a ){ return $a[0]; }, get_user_meta( $user_id->ID ) ); 
	      $banner_id  = get_user_meta ($user_id->ID , 'wp_user_avatar');
		  $fuser['banner']  = wp_get_attachment_url( $banner_id[0] );
          $fuser['meta']    = $allm;
		  $fusers[] = $fuser;
	    }		
			return array('data'=>$fusers);		}	
	
	public function app_all_pro_vendors_info(){
		global $wpdb , $post , $product , $woocommerce;
		
		$gen_data 	= file_get_contents('php://input');
        $arguments 	= json_decode($gen_data, TRUE);
		
		$vendors = get_terms( ['taxonomy' => 'wcpv_product_vendors'] );		
	   return $vendors;
	}
	
	public function app_single_pro_vendor_store_info(){
		global $wpdb , $post , $product , $woocommerce;
		
		$gen_data 	= file_get_contents('php://input');
        $arguments 	= json_decode($gen_data, TRUE);
		$vendor_id  = $arguments['vendor_id'];
		
		$terms_data = get_term_meta( $vendor_id );
		$store_info = unserialize( $terms_data['vendor_data'][0] );

	   return $store_info;
	}
	
	public function app_single_pro_vendor_products(){
		global $wpdb , $post , $product , $woocommerce;
		
		$gen_data 	= file_get_contents('php://input');
        $arguments 	= json_decode($gen_data, TRUE);
		$vendor_id  = $arguments['vendor_id'];
		$page		= $arguments['page'];	
		$args = array(
			'post_type'              => array('product'),		
			'posts_per_page'  		 => 10,
			'post_status' 			 => 'publish',
			'tax_query' => array(
                array(
                    'taxonomy' => 'wcpv_product_vendors',
                    'field' => 'term_id',
                    'terms' => absint($vendor_id)
                )
            ),
			'paged' 	 => $page
		);	
		 
		$loop_vendor = new WP_Query( $args );			
		$product_ids = array(); 
		while ( $loop_vendor->have_posts() ) : $loop_vendor->the_post();
				$product_ids[] =  $loop_vendor->post->ID;
		endwhile; 				
		return  $product_ids;
	}	
 
 } ?>