<?php 

class TcTeraWalletController {
	
    public function __construct(){
       $this->namespace     = 'api/tc_wallet';				
	}
	
	public function tc_tera_wallet_routes() {		
		register_rest_route($this->namespace, '/balance', array(
            array(
                'methods' => "GET",
                'callback' => array($this, 'tc_wallet_balance'),
                'permission_callback' => '__return_true'
            ),
        ));
		
		register_rest_route( $this->namespace, '/transactions', array(
            array(
                'methods'   => 'GET',
                'callback'  => array( $this, 'wallet_transactions' ),
				'permission_callback' => '__return_true'
            ),
        ));	
		
		register_rest_route($this->namespace, '/fund_transfer', array(
            array(
                'methods' => "POST",
                'callback' => array($this, 'tc_transfer'),
				'permission_callback' => '__return_true'
            ),
        ));	 
		
		register_rest_route($this->namespace, '/payment_process', array(
            array(
                'methods' => "POST",
                'callback' => array($this, 'tc_wallet_payment_process'),
				'permission_callback' => '__return_true'
            ),
        ));
		
		register_rest_route($this->namespace, '/partial_payment', array(
            array(
                'methods' => "POST",
                'callback' => array($this, 'tc_wallet_partial_payment'),
				'permission_callback' => '__return_true'
            ),
        ));
    }
	
  	public function tc_wallet_balance($request){ 
  	    if (!is_plugin_active('woo-wallet/woo-wallet.php')) {
			return new WP_Error('install_plugin', __('<strong>ERROR</strong>: Please install TeraWallet plugin.'));
        }
         $cookie =   $request->get_header("get-cookie");
        if(isset($cookie) && $cookie != ""){
            $uid  = wp_validate_auth_cookie($cookie, 'logged_in');
            if($uid >= 0 && $uid != ""){                
                 $data = woo_wallet()->wallet->get_wallet_balance($uid, 'Edit'); 
            }else{
                return new WP_Error('install_plugin', __('<strong>ERROR</strong>: Please Cookie is not valid Please provide correct login credentials.'));
            }
        }else{
            return new WP_Error('invalid_cookie', __('<strong>ERROR</strong>: Not a valid Cookie value.'));
        }
        return $data;
	}
	
	public function get_info_user($uid){
		if(isset($uid) && $uid >= 1){
		 $usr_info = get_userdata($uid);
		 $usr_array = array(
			"id" 			=> $usr_info->ID,
			"username" 		=> $usr_info->user_login,
			"first_name" 	=> $usr_info->user_firstname,
			"last_name" 	=> $usr_info->last_name,
			"email" 		=> $usr_info->user_email,
			"display_name" 	=> $usr_info->display_name,
		 );		 
		}	
		return $usr_array;			 
	}
		
	public function wallet_transactions($request){
	    if (!is_plugin_active('woo-wallet/woo-wallet.php')) {
			return new WP_Error('install_plugin', __('<strong>ERROR</strong>: Please install TeraWallet plugin.'));
        }
		 $cookie = $request->get_header("get-cookie");
		if(isset($cookie) && $cookie != ""){ 
			$uid = wp_validate_auth_cookie($cookie, 'logged_in');
			$args = array(
                'limit'   => 10,
                'user_id' => $uid
            );
			 $tr_data  	 = get_wallet_transactions($args); 
			 $user_data  = [];
			 $all_data = [];
			 $i = 0;
			 foreach($tr_data as $single_trans => $value){
				 $user_data[]  = $value;				 
				 $user_data[$i]->user   		= $this->get_info_user($value->user_id);
				 $user_data[$i]->created_by   	= $this->get_info_user($value->created_by);
				 $i++;
			 }				 
		   $all_data = $user_data;           
           return $all_data;
        }else{
            return new WP_Error('invalid_cookie', __('<strong>ERROR</strong>: Not a valid Cookie value.'));
        }
		
		
		
    }
	
	public function tc_transfer(){
	    if (!is_plugin_active('woo-wallet/woo-wallet.php')) {
			return new WP_Error('install_plugin', __('<strong>ERROR</strong>: Please install TeraWallet plugin.'));
        }		
		$json   = file_get_contents('php://input');
        $params = json_decode($json, TRUE);			
		$cookie = $params['get-cookie'];
		$uemail = $params['to'];
		$amount = $params['amount'];
		$note   = $params['note'];
		if(isset($cookie) && $cookie != ""){ 
			$uid = wp_validate_auth_cookie($cookie, 'logged_in');
			if(!isset($uid) || $uid == "" || $uid == 0){
				return new WP_Error('invalid_user', __('<strong>ERROR</strong>: Not a valid user.'));
			}
		}else{
			return new WP_Error('invalid_cookie', __('<strong>ERROR</strong>: Not a valid Cookie value.'));
		}
		
		$user_detail   = get_user_by('email', $uemail); 
		$us_email        =	$user_detail->user_email;
		
		if(!isset($us_email) && $us_email == $uemail){
			return new WP_Error('invalid_user', __('<strong>ERROR</strong>: User not Exist.'));
		}
		
		wp_set_current_user($uid);
		$_POST['woo_wallet_transfer_user_id'] 	= $user_detail->id;
		$_POST['woo_wallet_transfer_amount'] 	= $amount;
		$_POST['woo_wallet_transfer_note'] 		= sanitize_text_field($note);
		$_POST['woo_wallet_transfer'] 			= wp_create_nonce('woo_wallet_transfer');

		include_once(WOO_WALLET_ABSPATH . 'includes/class-woo-wallet-frontend.php');
		return Woo_Wallet_Frontend::instance()->do_wallet_transfer();		
    }
	
	public function tc_wallet_payment_process(){
        if (!is_plugin_active('woo-wallet/woo-wallet.php')) {
			return new WP_Error('install_plugin', __('<strong>ERROR</strong>: Please install TeraWallet plugin.'));
        }

        $json_data 	= file_get_contents('php://input');
        $att_data 	= json_decode($json_data, TRUE);
		$oid		= $att_data['order_id'];
        $cookie 	= $att_data['get-cookie'];
        if(isset($cookie) && $cookie != ""){ 
            $uid = wp_validate_auth_cookie($cookie, 'logged_in');
			if(!isset($uid) || $uid == "" || $uid == 0){
				return new WP_Error('invalid_cookie', __('<strong>ERROR</strong>: Not a valid Cookie value.'));
			}			
            wp_set_current_user($uid);
            $order = wc_get_order($oid);
			$order_value = $order->get_total('edit');
			$wallet_bal  = woo_wallet()->wallet->get_wallet_balance(get_current_user_id(),'edit');
			$bal_amount  = $order_value - $wallet_bal;
			
			 if(($order_value > $wallet_bal) && apply_filters('woo_wallet_disallow_negative_transaction', ($wallet_bal <= 0 || $order_value > $wallet_bal), $order_value , $wallet_bal)) {				 
                return new WP_Error('low_balance', __('<strong>ERROR</strong>: Your wallet balance is low. Please add '.$bal_amount.' to proceed with this transaction.'));
            }				
            
            $wallet_res = woo_wallet()->wallet->debit(get_current_user_id(), $order->get_total(), apply_filters('woo_wallet_order_payment_description', __('For order #', 'woo-wallet') . $order->get_order_number(), $order));

            $orid = $request['id'];
            wc_reduce_stock_levels($oid);

            if ($wallet_res) {
                $order->payment_complete($wallet_res);
                do_action('woo_wallet_payment_processed', $orid, $wallet_res);
            }
            return array('result' => 'Wallet Payment successful',);
        } else {
            return new WP_Error('invalid_cookie', __('<strong>ERROR</strong>: Not a valid Cookie value.'));
        }
    } 
	
	public function tc_wallet_partial_payment($request){
        if (!is_plugin_active('woo-wallet/woo-wallet.php')) {
			return new WP_Error('install_plugin', __('<strong>ERROR</strong>: Please install TeraWallet plugin.'));
        }

        $json_data 	= file_get_contents('php://input');
        $att_data 	= json_decode($json_data, TRUE);
        $cookie 	= $att_data['get-cookie'];
		$oid 		= $att_data['order_id'];
        if(isset($cookie) && $cookie != ""){ 
            $uid = wp_validate_auth_cookie($cookie, 'logged_in');
			if(!isset($uid) || $uid == "" || $uid == 0){
				return new WP_Error('invalid_user', __('<strong>ERROR</strong>: Not a valid user.'));
			}	
             
			if(isset($oid) && $oid > 0 && $oid != ""){
				$order = wc_get_order($oid); 
					if ($order->get_customer_id() == $uid) {
						wp_set_current_user($uid);
						woo_wallet()->wallet->wallet_partial_payment($oid); 
						return array(
							'result' => 'Payment Successfull',
						);
					} else {
						return new WP_Error('not_allowed', __('<strong>ERROR</strong>: partial payment not allowed.'));
					}
		   } else {
				return new WP_Error('invalid_corder', __('<strong>ERROR</strong>: Not a valid order.'));
		   }
        } else {
            return new WP_Error('invalid_cookie', __('<strong>ERROR</strong>: Not a valid Cookie value.'));
        }
    }
	
 } ?>