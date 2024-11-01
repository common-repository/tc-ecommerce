<?php function tc_app_admin_notices(){	
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	
	if ( is_plugin_active('woocommerce/woocommerce.php') == false ) {
		echo esc_html('<div id="message" class="error fade"><p style="line-height: 150%">');
		_e('<strong>TC Ecommerce</strong></a> requires the WooCommerce to be activated. Please <a target="_blank" href="plugin-install.php?tab=plugin-information&plugin=woocommerce&TB_iframe=true&width=600&height=550">install / Activate</a> first.', 'VC App');
		echo esc_html('</p></div>');
		return;
	}	
}

function tc_app_admin_menu() {
	add_menu_page( __( 'TC Banner Settings' ), __( 'TC Banner Settings' ), 'manage_options', 'banner-settings', 'tc_app_banner_setting','' , 42  );	
}

function tc_app_admin_menu_activation() {
	add_menu_page( __( 'TC App Activate' ), __( 'TC App Activate' ), 'manage_options', 'tc-app-activate', 'tc_app_activate','' , 42  );	
}


function tc_app_activate(){ ?>

<div class="wrap">
  <style>
		#poststuff .inside {
			margin: 6px 0 0;
		}
		
		#newImageButton { background:#ccc; box-shadow:none; }
			
		.stuffbox label {
			line-height: 30px;
			font-size: 12px;
			text-align: left;
			font-weight: 700;
		}
		
		.inside input,
		.inside select {
			width: 50%;
			height: 35px;
			box-shadow: none;
			background: #fff;
		}
		
		#poststuff {
			padding-top: 10px;
			width: 100%;
			padding: 0 10px;
		}
		
		#poststuff .stuffbox>h3,
		#poststuff h2,
		#poststuff h3.hndle {
			font-size: 14px;
			padding: 8px 12px;
			margin: 0;
			line-height: 1.4;
		}
		
		.postbox,
		.stuffbox {
			margin-bottom: 20px;
			padding: 0;
			line-height: 1;
			background: #fff;
			padding: 10px;
		}
		
		#poststuff {
			width: 70%;
			background: #fff;
			padding: 20px;
		}
		
		#poststuff h4 {
			font-size: 18px;
		}
		
		.msg {
			color: #ff0000;
			text-align: center;
			font-size: 12px;
			line-height: 20px;
		}
		.bps {padding:2px 20px!important; height:34px!important;}
		@media only screen and (max-device-width : 768px) {
			#poststuff {width: 94%; padding: 20px 3%;}
			.inside input, .inside select { width: 100%; }				
		}	
		
		
	</style>
  <?php	
  		$api_url = 'https://api.themes-coder.com';
  		$purchased_code = sanitize_text_field($_REQUEST['purchase_code']);
  		if(isset($purchased_code) && $purchased_code != ""){			
				
			$current_site_url =	get_site_url();	
			$body = array(
				'code'    => $purchased_code,
				'url'     => $current_site_url,
				'ref'     => 'demo_code',
			);
						
			$args = array(
			    'body'        => $body,
				'timeout'     => '5',
				'redirection' => '5',
				'httpversion' => '1.0',
			);	
			
			$nurl = $api_url . '/api.php';
			$response  = wp_remote_post( $nurl , $args ); 
			$response1  = wp_remote_retrieve_body($response); 
			$response2  = json_decode( $response1, true ); 
			
			if(isset($response2['error']) && $response2['error'] == '404'){
				 $msg = $response2['description'];
			}elseif(isset($response2['purchase_code']) && $response2['purchase_count'] >= 1 && $response2['buyer'] != "" ){ 
			    if($response2['buyer'] == 'trial' && $response2['expiry'] != ""){
			        $tc_app_purchase_code	= get_option('tc_app_purchase_code');
			        $tc_app_buyer           = get_option('tc_app_buyer');
			        $tc_app_expiry          = get_option('tc_app_expiry');
			        $expire_time            =  strtotime(date('M d, Y h:i:s'));
			        if(isset($tc_app_purchase_code) && $tc_app_buyer == 'trial' && $tc_app_expiry <= $expire_time ){
			            $msg = "Sorry, Your Trial Period Expired. Please buy product";
			        }elseif(isset($tc_app_purchase_code) && $tc_app_buyer == 'trial' && $tc_app_expiry >= $expire_time ){
			            $msg = "Sorry, Your Trial Period Already Running.";
			        }
			        else{
    			        update_option('tc_app_purchase_code' , $purchased_code);
        				update_option('tc_app_plugin_active' , 'active');
        				update_option('tc_app_purchase_detail' , $response2);
        				update_option('tc_app_expiry' , $response2['expiry']);
        				update_option('tc_app_buyer' , $response2['buyer']);
        				echo "<script>window.location.href='admin.php?page=tc-ecommerce'</script>";
			        }
			    }else{
    				update_option('tc_app_purchase_code' , $purchased_code);
    				update_option('tc_app_plugin_active' , 'active');
    				update_option('tc_app_purchase_detail' , $response2);
    				update_option('tc_app_expiry' , "");
    				update_option('tc_app_buyer' , $response2['buyer']);
    				echo "<script>window.location.href='admin.php?page=tc-ecommerce'</script>";
			    }
			    
			}else{
			    $msg = "Something wrong here , Please try later.";
			}
		}  
  
  		if(get_option('tc_app_plugin_active') == "active" && get_option('tc_app_purchase_code') != ""){			
			$tc_app_purchase_code	= get_option('tc_app_purchase_code');
			$tc_app_plugin_active   = get_option('tc_app_plugin_active');
			$tc_app_expiry          = get_option('tc_app_expiry');
			$tc_app_buyer           = get_option('tc_app_buyer');
		}
		else {
			$tc_app_purchase_code	= "";
			$tc_app_plugin_active  = "";
		}
  ?>
  <h1 class="wp-heading-inline">Plugin Validation</h1>
  <?php if(isset($msg) && $msg != ""){ ?>
  <div id="message" class="notice notice-error is-dismissible">
    <h4><?php echo esc_attr($msg); ?> </h4>
  </div>
  <?php } ?>
  <div class="poststuff" id="poststuff">
    <form method="post" action="" id="plugin_validate" name="plugin_validate">
      <div class="stuffbox">
        <label for="name" class="col-sm-2 col-md-3 control-label">Please Enter Purchase Code </label>
        <div class="inside">
          <input required class="form-control field-validate" id="purchase_code" name="purchase_code" type="text" value="<?php if(isset($tc_app_purchase_code) && $tc_app_purchase_code != ""){ echo esc_attr($tc_app_purchase_code); } ?>">
          <br />
          <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0; line-height:20px;">Enter Product Purchase Code.</span> </div>
      </div>
      <?php wp_nonce_field('action_settings_add_edit','add_edit_nonce'); ?>
      <div>
        <button type="submit" name="submit" id="btnsave" value="Submit" class="button-primary bps">Submit</button>
        &nbsp;&nbsp;
        <button type="button" name="button" onclick="location.href='admin.php?page=tc-app-activate'" id="btnsave" value="true" class="button-primary bps">Cancel</button>
      </div>
    </form>
  </div>
</div>
<?php }

function tc_wp_rest_allow_all_cors() {
 remove_filter( 'rest_pre_serve_request', 'rest_send_cors_headers' );
 add_filter( 'rest_pre_serve_request', function( $value ) {
 header("Cache-Control: no-cache, must-revalidate");
 header("Access-Control-Allow-Credentials: true");
 header('Access-Control-Allow-Origin:  *');
 header('Access-Control-Allow-Methods:  POST, GET, OPTIONS, PUT, DELETE');
 header('Access-Control-Allow-Headers:  Content-Type, X-Auth-Token, Origin, Authorization');
	 
		return $value;
	});
}

function tc_app_style_hook() {
    $gmob = sanitize_text_field($_GET['mob']);
   if(isset($gmob) && $gmob == true ){ ?>
<style>
		.woocs_auto_switcher {display:none;}
        <?php 
        $platform = sanitize_text_field($_GET['platform']);
        if(isset($platform) && $platform == 'ios' ) {
         echo esc_attr("body{padding-top:50px;}");
        }
         global $wpdb;
         if(get_option( 'tc_ecommerce_app_settings')) {
         $all_settings = get_option( 'tc_ecommerce_app_settings');
        }
         $custom_css_for_checkout = $all_settings['custom_css_for_checkout'];
         echo esc_attr($custom_css_for_checkout);
         ?>
        </style>
<?php 
$onepage = sanitize_text_field($_GET['one_page']);
if(isset($onepage) && $onepage == 2 ){ ?>
<script>  
                jQuery( document ).ready( readyFn );
                function readyFn( jQuery ) { jQuery("#place_order").trigger('click'); }
            </script>
<style>
        body , .checkout {
          display: none;
        }
</style>
<?php } } 	add_filter( 'woocommerce_ship_to_different_address_checked', '__return_true'); } 

function tc_show_extra_profile_fields_for_wcvendor( $user ) { 
$user_meta = get_userdata($user->ID);
$user_roles = $user_meta->roles;

if ( in_array( 'vendor', $user_roles, true ) && current_user_can('administrator')  ) { ?>
<h3>Extra profile information</h3>
<table class="form-table">
  <tr>
    <th><label for="twitter">Mark as Featured Vendor</label></th>
    <td><input type="checkbox" name="feature_wcvendor" id="feature_wcvendor" value="yes" <?php if( get_the_author_meta( 'feature_wcvendor', $user->ID ) == 'yes' ){ ?> checked <?php } ?> />
      Mark as featured vendor <br />
      <span class="description">This vendor will be marked as a featured vendor.</span></td>
  </tr>
</table>
<?php } }

function tc_save_extra_profile_fields_for_wcvendor( $user_id ){
$user_meta = get_userdata($user_id);
$user_roles = $user_meta->roles;

if ( in_array( 'vendor', $user_roles, true ) && current_user_can('administrator')) { 
	if ( !current_user_can( 'edit_user', $user_id ) )
		return false;
	update_usermeta( $user_id, 'feature_wcvendor', $_POST['feature_wcvendor']);
}}

if( ! function_exists( 'tc_app_admin_enqueue_styles' )) {
	add_action( 'admin_enqueue_scripts', 'tc_app_admin_enqueue_styles' );

	function tc_app_admin_enqueue_styles() {
		wp_register_style( 'tc-app-admin-style', TCVC_PLUGIN_URL . '/assets/css/tcvc_admin_style.css' );
		wp_enqueue_style( 'tc-app-admin-style' );
	}
} ?>