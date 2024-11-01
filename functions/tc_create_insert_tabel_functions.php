<?php function tc_app_create_order_page(){	
	/*---------Mobile Checkout Page Inserted to database-------------*/
	global $json_api ,$wpdb;
	$post_table = $wpdb->prefix . "posts";
	$meta_table = $wpdb->prefix . "postmeta";
	$check_page_exist = "select * from `".$post_table."`as page_rec INNER JOIN `".$meta_table."` as meta_rec on page_rec.ID = meta_rec.post_id where `post_type`='page' && `post_status`='publish' && (meta_key = '_wp_page_template' && meta_value = 'template-mobile-checkout.php')";
	$have_page_record = $wpdb->get_results($check_page_exist);
		
	if($have_page_record == "" || $have_page_record == null ){
		$addd_page = "insert into `".$post_table."` set `post_type`='page' , `post_title`='Mobile Checkout' , `post_name`='mobile-checkout' , `guid`='".site_url()."/mobile-checkout' , `post_status`='publish' , `post_author`=1 , `ping_status`='closed' , `comment_status`='closed' , `menu_order`=0 , `post_date`='".date('Y-m-d H:i:s')."' , `post_date_gmt`='".date('Y-m-d H:i:s')."'";
		if($wpdb->query($addd_page)){
			$inserted_page_id  = $wpdb->insert_id; 
			update_post_meta($inserted_page_id,'_wp_page_template','template-mobile-checkout.php'); 
		}			
	}
	/*---------Mobile Checkout Page Inserted to database-------------*/		


	$sql_banner = "CREATE TABLE IF NOT EXISTS `" . TCVC_APP_BANNERS_SETTINGS . "` (
	  `banners_id` int(11) NOT NULL auto_increment,
	  `banners_title` varchar(64)  NOT NULL,
	  `banners_url` varchar(255)  NOT NULL,
	  `banners_image` mediumtext  NOT NULL,
	  `banners_group` varchar(10)  NOT NULL,
	  `banners_html_text` mediumtext ,
	  `expires_impressions` int(7) DEFAULT '0',
	  `expires_date` datetime DEFAULT NULL,
	  `date_scheduled` datetime DEFAULT NULL,
	  `date_added` datetime NOT NULL,
	  `date_status_change` datetime DEFAULT NULL,
	  `status` int(1) NOT NULL DEFAULT '1',
	  `type` varchar(250)  NOT NULL,
	  `banners_order` int(3) NOT NULL DEFAULT '1',
	  PRIMARY KEY  (banners_id)
	);";

	$sql_data_order = "CREATE TABLE IF NOT EXISTS `" . TCVC_APP_ORDER_DATA . "` (
	  `id` int(11) NOT NULL auto_increment,
	  `data_link` text NOT NULL,
	  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	   PRIMARY KEY (`id`)
	)ENGINE=MyISAM DEFAULT CHARSET=utf8;";

	$sql_tc_app_notification = "CREATE TABLE `".TCVC_NOTIFICATION_DEVICES."` (
	  `id` int(100) NOT NULL auto_increment,
	  `device_id` text NOT NULL,
	  `user_id` int(100) NOT NULL DEFAULT '0',
	  `device_type` text NOT NULL,
	  `register_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	  `update_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	  `status` tinyint(1) NOT NULL DEFAULT '0',
	  PRIMARY KEY (`id`)
	)ENGINE=MyISAM DEFAULT CHARSET=utf8;";

	$sql_tc_all_notification = "CREATE TABLE `".TCVC_ALL_NOTIFICATION."` (
	  	`id` int(10) NOT NULL auto_increment,
  		`user_id` int(10) NOT NULL,
  		`code` varchar(30) NOT NULL,
		`message` text NOT NULL,
  		`type` int(10) NOT NULL DEFAULT '1',
		`is_view` int(10) NOT NULL DEFAULT '0',
  		`expire_date` date NOT NULL,
	  PRIMARY KEY (`id`)
	)ENGINE=MyISAM DEFAULT CHARSET=utf8;";
	
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );		
	
	if($wpdb->get_var("SHOW TABLES LIKE '".TCVC_APP_ORDER_DATA."'") != TCVC_APP_ORDER_DATA) 
	{
		$wpdb->query($sql_data_order);
	}	
	if($wpdb->get_var("SHOW TABLES LIKE '".TCVC_APP_BANNERS_SETTINGS."'") != TCVC_APP_BANNERS_SETTINGS) 
	{
		$wpdb->query($sql_banner);
	}
	if($wpdb->get_var("SHOW TABLES LIKE '".TCVC_NOTIFICATION_DEVICES."'") != TCVC_NOTIFICATION_DEVICES) 
	{
		$wpdb->query($sql_tc_app_notification);
	}	
	if($wpdb->get_var("SHOW TABLES LIKE '".TCVC_ALL_NOTIFICATION."'") != TCVC_ALL_NOTIFICATION) 
	{
		$wpdb->query($sql_tc_all_notification);
	}
}
?>