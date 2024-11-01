<?php
if( ! function_exists( 'add_coupon_notification_checkbox' ) ) {
	function add_coupon_notification_checkbox() { 
		woocommerce_wp_checkbox( array( 'id' => 'coupon_push_notification', 'label' => __( 'Push Notification', 'woocommerce' ), 'description' => sprintf( __( 'Send Push notification to all user', 'woocommerce' ) ) ) );
	}
	add_action( 'woocommerce_coupon_options', 'add_coupon_notification_checkbox', 10, 0 );
}
function save_coupon_notification_tc_app( $post_id ) { global $wpdb;
    $include_stats = isset( $_POST['coupon_push_notification'] ) ? 'yes' : 'no';
    update_post_meta( $post_id, 'coupon_push_notification', $include_stats );
	
	if($include_stats == 'yes'){
		
		$post_coupon_ae   	= get_post( $post_id );
		$title_ae    		= $post_coupon_ae->post_title;
		$output_ae   		= $post_coupon_ae->post_excerpt;
		$expire_date 		= get_post_meta( $post_id, 'expiry_date', true ); 
		
		$content_ae  = array( "en" => $output_ae );		
		$headings_ae = array( "en" => 'A New Scaratch Card!' );

		$get_include_player_ids	  = "SELECT * FROM `".TCVC_NOTIFICATION_DEVICES."` where `device_id`!='' && `user_id`>='1'";
		$show_include_player_ids  = $wpdb->get_results($get_include_player_ids);	
		foreach($show_include_player_ids as $sipi){						
			$all_ae_devices[] = esc_attr($sipi->device_id);
			$all_ae_users[]   = esc_attr($sipi->user_id);				
		}	

		if(get_option( 'tc_ecommerce_app_settings')) { 
			$all_app_settings = get_option( 'tc_ecommerce_app_settings');
		}

		$app_id  = $all_app_settings['one_signal_app_id'];   
		$api_key = $all_app_settings['one_signal_app_key'];  

		if($app_id != "" && $api_key != ""){
			$fields_ae = array(
			   'app_id' 			=> $app_id,
			   'include_player_ids' => $all_ae_devices,		   
			   'contents' 			=> $content_ae,
			   'headings'			=> $headings_ae,
               'code'				=> $title_ae,
               'type'				>  '1'
			);
			
			$fields_ae = json_encode($fields_ae);
			
			$osn_args = array(
			    'body'        => $fields_ae,
				'timeout'     => '5',
				'redirection' => '5',
				'httpversion' => '1.0',
			);
			
			$noti_url = "https://onesignal.com/api/v1/notifications";
			
			$response1  = wp_remote_post( $noti_url , $osn_args );
			$result  	= wp_remote_retrieve_body($response1);
			$data	 	= json_decode( $result, true );
	
			if(!empty($data->recipients) and $data->recipients >= 1){
				$response = '1';
			
				foreach($all_ae_users as $user_num){
					$insert_user_note = "insert into `".TCVC_ALL_NOTIFICATION."` set `user_id`='".$user_num."' , `code`='".$title_ae."', `message`='".$output_ae."' , `expire_date`='".$expire_date."'";
					$wpdb->query($insert_user_note);
				}
			}	
		}			
	}	
} ?>