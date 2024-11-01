<?php
class AppUserController {

    public function __construct() {
        $this->namespace     = 'api/tc_user';
    }
 
    public function tc_user_routes() {

        register_rest_route( $this->namespace, '/register', array(
            array(
                'methods'   => 'POST',
                'callback'  => array( $this, 'register' ),
				'permission_callback' => '__return_true'
            ),
        ));
		
		register_rest_route( $this->namespace, '/generate_cookie', array(
            array(
                'methods'   => 'POST',
                'callback'  => array( $this, 'generate_cookie' ),
				'permission_callback' => '__return_true'
            ),
        ));
		
		register_rest_route( $this->namespace, '/validate_cookie', array(
            array(
                'methods'   => 'POST',
                'callback'  => array( $this, 'validate_cookie' ),
				'permission_callback' => '__return_true'
            ),
        ));
		
		register_rest_route( $this->namespace, '/fb_connect', array(
            array(
                'methods'   => 'POST',
                'callback'  => array( $this, 'fb_connect' ),
				'permission_callback' => '__return_true'
            ),
        ));
		
		register_rest_route( $this->namespace, '/send_mail', array(
            array(
                'methods'   => 'POST',
                'callback'  => array( $this, 'send_mail' ),
				'permission_callback' => '__return_true'
            ),
        ));
		
		register_rest_route( $this->namespace, '/forgot_password', array(
            array(
                'methods'   => 'POST',
                'callback'  => array( $this, 'forgot_password' ),
				'permission_callback' => '__return_true'
            ),
        ));
		
		register_rest_route( $this->namespace, '/update_user_profile', array(
            array(
                'methods'   => 'POST',
                'callback'  => array( $this, 'update_user_profile' ),
				'permission_callback' => '__return_true'
            ),
        ));
		
		register_rest_route( $this->namespace, '/reward_points_settings', array(
            array(
                'methods'   => 'POST',
                'callback'  => array( $this, 'reward_points_settings' ),
				'permission_callback' => '__return_true'
            ),
        ));
		
		register_rest_route( $this->namespace, '/tc_reward_points', array(
            array(
                'methods'   => 'POST',
                'callback'  => array( $this, 'tc_reward_points' ),
				'permission_callback' => '__return_true'
            ),
        ));
		
		register_rest_route( $this->namespace, '/tc_register_device', array(
            array(
                'methods'   => 'POST',
                'callback'  => array( $this, 'tc_register_device' ),
				'permission_callback' => '__return_true'
            ),
        ));
		
		register_rest_route( $this->namespace, '/tc_coupon_notification', array(
            array(
                'methods'   => 'POST',
                'callback'  => array( $this, 'tc_coupon_notification' ),
				'permission_callback' => '__return_true'
            ),
        ));
		
		register_rest_route( $this->namespace, '/tc_notification_update', array(
            array(
                'methods'   => 'POST',
                'callback'  => array( $this, 'tc_notification_update' ),
				'permission_callback' => '__return_true'
            ),
        ));
		
    }	
	
	public function register() {
        $gen_user		= file_get_contents('php://input');
        $arguments  	= json_decode($gen_user, TRUE);
        $username		= $arguments["username"];
		$password		= $arguments["password"];
        $email	 		= $arguments["email"];
		
        $first_name  	= $arguments["first_name"];
        $last_name   	= $arguments["last_name"];
		$user_pass   	= $arguments["user_pass"];
        $display_name 	= $arguments["display_name"];
        
        $username		= sanitize_user($username);
        $email 			= sanitize_email($email);
		
		$timeinsec 		= 1296000;
		$notify			= 'both';
		
		if(username_exists($username) || $username == 'admin'){
			return new WP_Error('user_exist', __('<strong>ERROR</strong>: This username already exist.'));
		 }
		if(email_exists($email)){return new WP_Error('email_exist', __('<strong>ERROR</strong>: This email already exist.'));}
		if(!is_email($email)){return new WP_Error('email_validity', __('<strong>ERROR</strong>: This email not valid.'));}
		
		$userdata = array(
			'first_name'		=>	$first_name,
			'last_name'			=>	$last_name,
			'user_login'		=>	$username,
			'user_email'		=>	$email,
			'user_pass'			=>  $password,
			'display_name'		=>  $display_name,
			'user_nicename'		=>  $first_name.' '.$last_name,
			'nickname'			=>  $username,
			'role'				=>  get_option('default_role')
		);
		
		$user_id 			= 	wp_insert_user($userdata);
		if(is_wp_error($user_id)){return new WP_Error('insert_error', __('<strong>ERROR</strong>: This email already exist.'));}
		$result 			= 	wp_new_user_notification($user_id);
		$expire_time		=   time() + apply_filters('auth_cookie_expiration', $timeinsec, $user_id, true);		
		$cookie				= 	wp_generate_auth_cookie($user_id ,$expire_time , 'logged_in' );		
		$user_cookie_info   =   array('cookie'=>$cookie , 'user_id' =>$user_id);
		return $userdata;       
    }
	
	public function generate_cookie() {
        $gen_cookie 	= file_get_contents('php://input');
        $arguments 		= json_decode($gen_cookie, TRUE);
        if(!isset($arguments["username"]) || !isset($arguments["password"])){
            return new WP_Error('incorrect_credential', __('<strong>ERROR</strong>: Incorrect UserName OR PassWord.'));
        }
        $username 		= $arguments["username"];
        $password 		= $arguments["password"];
		$timeinsec 		= 1296000;
		
		$user_data 		= wp_authenticate($username , $password);		
		if(is_wp_error($user_data)){ return new WP_Error('invalid_credential', __('<strong>ERROR</strong>: InValid UserName OR PassWord.'));}

        $expire_time	=   time() + apply_filters('auth_cookie_expiration', $timeinsec, $user_data->id, true);
		$cookie			= 	wp_generate_auth_cookie($user_data->id ,$expire_time , 'logged_in' );
        $all_user_data 	= array(
		"cookie" 		=> $cookie,
		"user" 			=> array(
			"id" 			=> $user_data->ID,
			"username" 		=> $user_data->user_login,
			"nicename" 		=> $user_data->user_nicename,
			"email" 		=> $user_data->user_email,
			"display_name" 	=> $user_data->display_name,
			"first_name" 	=> $user_data->user_firstname,
			"last_name" 	=> $user_data->last_name,
			"nickname" 		=> $user_data->nickname,
			"description" 	=> $user_data->user_description,
			),
		);
		return $all_user_data;
    }	
	
	public function validate_cookie() {
        $have_cookie 		= file_get_contents('php://input');
        $arguments 			= json_decode($have_cookie, TRUE);
		$cookie_value		= $arguments['cookie'];	
		$validate 			= wp_validate_auth_cookie($cookie_value, 'logged_in') ? true : false;
		return $validate;		
    }
	
	public function fb_connect(){ 
		$aa_token 		= file_get_contents('php://input');
		$arguments 		= json_decode($aa_token, TRUE);		
		$access_token 	= $arguments['access_token'];
		
		$app_fields 	= 'id,name,first_name,last_name,email,picture';
		
		$app_args = array(
				'timeout'     => '5',
				'redirection' => '5',
				'httpversion' => '1.0',
		);
		
		if (!isset($access_token)) {return new WP_Error('access_token', __('<strong>ERROR</strong>: Need a valid access_token from Facebook API.'));}
	
		$url_con = 'https://graph.facebook.com/me/?fields='.$app_fields.'&access_token='.$access_token;
		
		$response1  = wp_remote_post( $url_con , $app_args );
		$response1  = wp_remote_retrieve_body($response1);
				
        $have_result = json_decode($response1, true);
			
		if (isset($have_result['email']) && $have_result['email'] != "") {			
			
			$have_email = email_exists($have_result['email']);
			if ($have_email){
				$user_data 		= get_user_by('email',$have_result['email']);
				$have_user_id 	= $user_data->ID;
				$have_user_name = $user_data->user_login;
			}
			
			if (!isset($have_user_id) && $have_email == false ) {
				$user_name = strtolower($have_result['first_name'].'.'.$have_result['last_name']);
				while (username_exists($user_name)) {
					$i++;
					$user_name = strtolower($have_result['first_name'].'.'.$have_result['last_name']).'.'.$i;
				}
				
				$gen_password = wp_generate_password($length = 12, $include_standard_special_chars = false);
				$userdata = array(
					'user_login' 	=> $user_name,
					'user_email' 	=> $have_result['email'],
					'user_pass' 	=> $gen_password,
					'display_name' 	=> $have_result['name'],
					'first_name' 	=> $have_result['first_name'],
					'last_name' 	=> $have_result['last_name']
				);
				$have_insert_id = wp_insert_user($userdata);
				$have_user_id   = $have_insert_id;
				
				if ($have_insert_id) $user_account = 'user registered.';
			} else {
				if ($have_user_id) $user_account = 'user logged in.';
			}
			
			$timeinsec 	= 1296000; /* 15*24*60*60 */
			$expire_time= time() + apply_filters('auth_cookie_expiration', $timeinsec, $have_user_id, true);
			$cookie	= wp_generate_auth_cookie($have_user_id ,$expire_time , 'logged_in' );
			
			$response['msg'] 		= $user_account;
			$response['id'] 		= $have_user_id;
			$response['cookie'] 	= $cookie;
			$response['user_login'] = $user_name;
			$response['user'] 		= $have_result;
			
			
		} else {
			$response['msg'] = "Your 'access_token' not valid. Get extended permission while joining the Facebook app.";
		}
        
        return $response;
    }	
	
	public function send_mail(){

		$have_data 		= file_get_contents('php://input');
        $arguments 		= json_decode($have_data, TRUE);
		$email			= $arguments['email'];
		$name			= $arguments['name'];
		$message		= $arguments['message'];
		
		if(!isset($email)){return new WP_Error('empty_email', __('<strong>ERROR</strong>: Email is required.'));}
		if(!is_email($email)){return new WP_Error('validity_email', __('<strong>ERROR</strong>:Not a Valid email.'));}
		if(!isset($name)){return new WP_Error('user_name', __('<strong>ERROR</strong>:Name id Required.'));}
		if(!isset($message)){return new WP_Error('user_message', __('<strong>ERROR</strong>:Message id Required.'));}
		
		$content = $message. "\r\n\r\n";
		$content.="Name :".$name."\r\n\r\n";
		$content.="Email : ".$user_email."\r\n\r\n";
		
		$title	= "Contact Us";
		
		if(get_option( 'tc_ecommerce_app_settings')) { 
			$all_settings = get_option( 'tc_ecommerce_app_settings');
		}		
		$to_email = $all_settings['contact_us_email'];
		
		if(!wp_mail($to_email, $title, $content)){
			return new WP_Error('user_message', __('<strong>ERROR</strong>:Your host may have disabled the mail.'));
		}else{
			return "Mail has been sent successfully. ";
		}	
		
	}
	
	public function forgot_password(){

		global  $wpdb , $wp_hasher;

		require_once ABSPATH . 'wp-includes/class-phpass.php';
		
		$have_data 		= file_get_contents('php://input');
        $arguments 		= json_decode($have_data, TRUE);
		$email			= $arguments['email'];
		
		if(!isset($email)){return new WP_Error('empty_email', __('<strong>ERROR</strong>: Email is required.'));}
		if(!is_email($email)){return new WP_Error('validity_email', __('<strong>ERROR</strong>:Not a Valid email.'));}
		if(!email_exists($email)){return new WP_Error('validity_email', __('<strong>ERROR</strong>:This Email not exist.'));}

	    $user_data 		 = get_user_by( 'email', trim( $email ) );
		$user_login 	 = $user_data->user_login;
		$user_id 		 = $user_data->id;	
		$get_key  		 = wp_generate_password( 20, false );
		$wp_hasher  	 = new PasswordHash(8, TRUE);
		$hashed_id  	 = $wp_hasher->HashPassword($get_key);		

		$sql_update = "UPDATE `".$wpdb->prefix."users` SET `user_activation_key` = '".$hashed_id."' WHERE ID =".$user_id;
		$wpdb->query($sql_update);		

		$title		= "Password Reset";		

		$content = __('Someone requested the password be reset for the following account:') . "\r\n\r\n";
		$content .= network_home_url( '/' ) . "\r\n\r\n";
		$content .= sprintf(__('Username: %s'), $user_login) . "\r\n\r\n";
		$content .= __('If this was a mistake, just ignore this email and nothing will happen.') . "\r\n\r\n";
		$content .= __('To reset your password, visit the following address:') . "\r\n\r\n";
		$content .= '<' . network_site_url("wp-login.php?action=rp&key=$get_key&login=" . rawurlencode($user_login), 'login') . ">\r\n";		

		if(!wp_mail($user_email, $title, $content)){
			return new WP_Error('user_message', __('<strong>ERROR</strong>:Your host may have disabled the mail.'));
		}else{
			return "A mail sent to your Email for reset password. ";
		}
	}
	
	public function update_user_profile(){
		global  $wpdb;
				
		$have_data 		= file_get_contents('php://input');
        $arguments 		= json_decode($have_data, TRUE);
		$user_id		= $arguments['user_id'];
		$email			= $arguments['email'];
		
		if(!isset($user_id)){return new WP_Error('user_id', __('<strong>ERROR</strong>: user_id var is required.')); }					
		$user 	 = 	get_userdata( $user_id );		
		if ( !$user ) { return new WP_Error('user_id', __('<strong>ERROR</strong>: user_id var is required.')); }
		if ( isset($email) && !email_exists($email) && $email !== $user->user_email) {
			return new WP_Error('invalid_email', __('<strong>ERROR</strong>: Email is not valid.'));
		}	
		
		$new_user 	= array( 'ID' 	=> $user_id );
		$billing  	= array();
		$shipping 	= array();		
		
		if ( isset( $arguments['password'] )){ 			$new_user['user_pass'] 			= $arguments['password']; }		
		if ( isset( $arguments['email'] )){   			$new_user['user_email'] 		= $arguments['email']; }
		if ( isset( $arguments['first_name'] )){ 		$new_user['first_name'] 		= $arguments['first_name']; }
		if ( isset( $arguments['last_name'] )){ 		$new_user['last_name'] 			= $arguments['last_name']; }
		if ( isset( $arguments['nickname'] )){ 			$new_user['nickname'] 			= $arguments['nickname']; }
		if ( isset( $arguments['user_nicename'] )){ 	$new_user['user_nicename'] 		= $arguments['user_nicename']; }		
		if ( isset( $arguments['dislay_name'] )){ 		$new_user['display_name'] 		= $arguments['dislay_name']; }		
		if ( isset( $arguments['user_url'] )){ 			$new_user['user_url'] 			= $arguments['user_url']; }
		if ( isset( $arguments['description'] )){ 		$new_user['description'] 		= $arguments['description']; }		
		
		if(isset( $arguments['billing_first_name'] )){  $billing['billing_first_name']  =  $arguments['billing_first_name']; }		
		if(isset( $arguments['billing_last_name'] )){   $billing['billing_last_name']   =  $arguments['billing_last_name']; }		
		if(isset( $arguments['billing_company'] )){     $billing['billing_company'] 	=  $arguments['billing_company']; }		
		if(isset( $arguments['billing_address_1'] )){   $billing['billing_address_1']   =  $arguments['billing_address_1']; }		
		if(isset( $arguments['billing_address_2'] )){   $billing['billing_address_2']   =  $arguments['billing_address_2']; }		
		if(isset( $arguments['billing_city'] )){	    $billing['billing_city'] 	    =  $arguments['billing_city']; }		
		if(isset( $arguments['billing_postcode'] )){    $billing['billing_postcode']    =  $arguments['billing_postcode']; }		
		if(isset( $arguments['billing_country'] )){     $billing['billing_country'] 	=  $arguments['billing_country'];}		
		if(isset( $arguments['billing_state'] )){ 	    $billing['billing_state'] 	    =  $arguments['billing_state']; }		
		if(isset( $arguments['billing_phone'] )){	    $billing['billing_phone'] 	    =  $arguments['billing_phone']; }		
		if(isset( $arguments['billing_email'] )){	    $billing['billing_email'] 	    =  $arguments['billing_email']; }		
		
		if(isset( $arguments['shipping_first_name'] )){ $shipping['shipping_first_name'] =  $arguments['shipping->first_name']; }		
		if(isset( $arguments['shipping_last_name'] )){	$shipping['shipping_last_name']  =  $arguments['shipping->last_name']; }		
		if(isset( $arguments['shipping_company'] )){    $shipping['shipping_company']    =  $arguments['shipping->company']; }		
		if(isset( $arguments['shipping_address_1'] )){  $shipping['shipping_address_1']  =  $arguments['shipping->address_1']; }		
		if(isset( $arguments['shipping_address_2'] )){  $shipping['shipping_address_2']  =  $arguments['shipping->address_2']; }		
		if(isset( $arguments['shipping_city'] )){       $shipping['shipping_city']       =  $arguments['shipping->city']; }		
		if(isset( $arguments['shipping_postcode'] )){   $shipping['shipping_postcode']   =  $arguments['shipping->postcode']; }		
		if(isset( $arguments['shipping_country'] )){    $shipping['shipping_country'] 	 =  $arguments['shipping->country']; }		
		if(isset( $arguments['shipping_state'] )){      $shipping['shipping_state'] 	 =  $arguments['shipping->state']; }				
		
		$user_id = wp_update_user( $new_user );		
			
		if ( is_wp_error( $user_id ) ) {
			return new WP_Error('user_exist', __('<strong>ERROR</strong>: There was an error, probably that user does not exist.'));
		}
		
		foreach($billing  as $key => $value){ update_user_meta( $user_id, $key, $value); }		
		foreach($shipping as $key => $value){ update_user_meta( $user_id, $key, $value); }
			
		$user_output 	= get_userdata( $user_id );	
		$user_output	= $user_output->data;
		$user_meta 		= array_map( function( $a ){ return $a[0]; }, get_user_meta( $user_id ) );
		
		$user_output->billing->first_name   	= $user_meta['billing_first_name']; 
		$user_output->billing->last_name  		= $user_meta['billing_last_name']; 
		$user_output->billing->company  		= $user_meta['billing_company']; 
		$user_output->billing->address_1  		= $user_meta['billing_address_1']; 
		$user_output->billing->address_2 		= $user_meta['billing_address_2']; 
		$user_output->billing->city  			= $user_meta['billing_city']; 
		$user_output->billing->postcode  		= $user_meta['billing_postcode']; 
		$user_output->billing->country  		= $user_meta['billing_country']; 
		$user_output->billing->state  			= $user_meta['billing_state']; 
		$user_output->billing->phone 			= $user_meta['billing_phone']; 
		$user_output->billing->email  			= $user_meta['billing_email']; 
		
		$user_output->shipping->first_name      = $user_meta['shipping_first_name']; 
		$user_output->shipping->last_name       = $user_meta['shipping_last_name']; 
		$user_output->shipping->company  		= $user_meta['shipping_company']; 
		$user_output->shipping->address_1  	    = $user_meta['shipping_address_1']; 
		$user_output->shipping->address_2 		= $user_meta['shipping_address_2']; 
		$user_output->shipping->city  			= $user_meta['shipping_city']; 
		$user_output->shipping->postcode  		= $user_meta['shipping_postcode']; 
		$user_output->shipping->country  		= $user_meta['shipping_country']; 
		$user_output->shipping->state  		    = $user_meta['shipping_state']; 
		
		return $user_meta;
		
	}
	
	public function reward_points_settings(){

		global $wpdb;

		$wc_points_settings = array();

		$earn_data = explode(':' ,get_option( 'wc_points_rewards_earn_points_ratio'));
		$rede_data = explode(':' ,get_option( 'wc_points_rewards_redeem_points_ratio'));

		$wc_points_settings['wc_points_rewards_earn_points_ratio'][earnPoint]       = $earn_data[0];
		$wc_points_settings['wc_points_rewards_earn_points_ratio'][equalTo]         = $earn_data[1];
		$wc_points_settings['wc_points_rewards_redeem_points_ratio'][redeemPoint]   = $rede_data[0];
		$wc_points_settings['wc_points_rewards_redeem_points_ratio'][equalTo]    	= $rede_data[1];
		$wc_points_settings['wc_points_rewards_cart_max_discount']    	= get_option( 'wc_points_rewards_cart_max_discount');
		$wc_points_settings['wc_points_rewards_max_discount']  		  	= get_option( 'wc_points_rewards_max_discount');
		$wc_points_settings['wc_points_rewards_points_expiry']  	  	= get_option( 'wc_points_rewards_points_expiry');
		$wc_points_settings['wc_points_rewards_account_signup_points']	= get_option( 'wc_points_rewards_account_signup_points');
		$wc_points_settings['wc_points_rewards_write_review_points']  	= get_option( 'wc_points_rewards_write_review_points');				

		return  array('data'=>$wc_points_settings);	
	}	
	
	public function tc_reward_points(){
		global  $wpdb;		
		$have_data 		= file_get_contents('php://input');
        $arguments 		= json_decode($have_data, TRUE);
		$user_id		= $arguments['user_id'];
			
		if(!isset($user_id)){return new WP_Error('user_id', __('<strong>ERROR</strong>:user_id is required.'));}

		$table_points 	= $wpdb->prefix."wc_points_rewards_user_points_log"; 
		$get_points 	= "select *  from `".$table_points."` where `user_id`=".$user_id;
		$have_points = $wpdb->get_results($get_points);		

		return  array('data'=>$have_points);	
	}	
	
	public function tc_register_device(){
		global $wpdb;
		
		$have_data 		= file_get_contents('php://input');
        $arguments 		= json_decode($have_data, TRUE);
		$device_id		= $arguments['device_id'];
		$user_id        = $arguments['user_id'];
		$update_date    = date("Y-m-d h:i:s");
		$register_date  = date("Y-m-d h:i:s");
			
		if(!isset($user_id)){return new WP_Error('user_id', __('<strong>ERROR</strong>:Device_id is required.'));}			
			
		if($user_id){
			$update_android_devide_user = "UPDATE `".TCVC_NOTIFICATION_DEVICES."` set `user_id`='".$user_id."' , `status`='1' , `update_date`='".$update_date."'  where `device_id`='".$device_id."'";
			 if($wpdb->query($update_android_devide_user)){
				$msg = "User Upated Successfully";
			 }
		}else{
			$check_ae_device_have = "select * from `".TCVC_NOTIFICATION_DEVICES."` where `device_id`='".$device_id."'";
			$have_ae_device = $wpdb->get_results($check_ae_device_have);
			if($have_ae_device == "" || $have_ae_device == 'null'){
				$insert_android_devide = "insert into `".TCVC_NOTIFICATION_DEVICES."` set `device_id`='".$device_id."', `update_date`='".$update_date."' , `register_date`='".$register_date."'";
				if($wpdb->query($insert_android_devide)){
					$msg = "Device registered Successfully";
				 }
			}
		}		

		return $msg;
	}
	
	public function tc_coupon_notification(){
		global $wpdb;
		
		$have_data 		= file_get_contents('php://input');
        $arguments 		= json_decode($have_data, TRUE);
		$device_id		= $arguments['device_id'];
		$user_id        = $arguments['user_id'];
		
		if(!isset($user_id)){return new WP_Error('user_id', __('<strong>ERROR</strong>:user_id is required.'));}
	
		$get_include_player_idsa   = "SELECT * FROM `".TCVC_ALL_NOTIFICATION."` where `type`=1 && `user_id`='".$user_id."'";	
		$show_include_player_idsa  = $wpdb->get_results($get_include_player_idsa);	
		return array('data'=>$show_include_player_idsa);

	}
	
	public function tc_notification_update(){
		global $wpdb;
		
		$have_data 			= file_get_contents('php://input');
        $arguments 			= json_decode($have_data, TRUE);
		$notification_id    = $arguments['notification_id'];
		
		if(!isset($user_id)){return new WP_Error('notification_id', __('<strong>ERROR</strong>:Notification_id is required.'));}
	
		$get_update_notification   = "update `".TCVC_ALL_NOTIFICATION."` set `is_view`=1 where `id`='".$notification_id."'";
		if($wpdb->query($get_update_notification)){	
			$note =  "Notification Updated";	
		}else {
			$note =  "Sorry Something Wrong Here";
		}

		return $note;
	}   
	
} ?>