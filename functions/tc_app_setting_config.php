<?php

    if ( ! class_exists( 'Redux' ) ) {  return;  }
	
    $opt_name_tc_ecommerce_app = "tc_ecommerce_app_settings"; 
    
    $args_tc_app_array 		= array(
        'opt_name'             => $opt_name_tc_ecommerce_app,
        'display_name'         => 'TC Ecommerce',
        'display_version'      => '1.3.4',
        'menu_type'            => 'menu',
        'allow_sub_menu'       => true,
        'menu_title'           => __( 'TC Ecommerce', 'Theme Coder' ),
        'page_title'           => __( 'TC Ecommerce', 'Theme Coder' ),
        'google_api_key'       => '',
        'google_update_weekly' => false,
        'async_typography'     => true,
        'admin_bar'            => true,
        'admin_bar_icon'       => 'dashicons-portfolio',
        'admin_bar_priority'   => 50,
        'global_variable'      => '',
        'dev_mode'             => false,
        'update_notice'        => true,
        'customizer'           => true,
        'page_priority'        => 41,
        'page_parent'          => 'themes.php',
        'page_permissions'     => 'manage_options',
        'menu_icon'            => '',
        'last_tab'             => '',
        'page_icon'            => 'icon-themes',
        'page_slug'            => 'tc-ecommerce',
        'save_defaults'        => true,
        'default_show'         => false,
        'default_mark'         => '',
        'show_import_export'   => false,
        'transient_time'       => 60 * MINUTE_IN_SECONDS,
        'output'               => true,
        'output_tag'           => false,
        'database'             => '',
        'use_cdn'              => true,
        'hints'                => array(
            'icon'          => 'el el-question-sign',
            'icon_position' => 'right',
            'icon_color'    => 'white',
            'icon_size'     => 'normal',
            'tip_style'     => array(
                'color'   => 'light',
                'shadow'  => true,
                'rounded' => false,
                'style'   => '',
            ),
            'tip_position'  => array(
                'my' => 'top left',
                'at' => 'bottom right',
            ),
            'tip_effect'    => array(
                'show' => array(
                    'effect'   => 'slide',
                    'duration' => '500',
                    'event'    => 'mouseover',
                ),
                'hide' => array(
                    'effect'   => 'slide',
                    'duration' => '500',
                    'event'    => 'click mouseleave',
                ),
            ),
        )
    );
	
    
    Redux::setArgs( $opt_name_tc_ecommerce_app, $args_tc_app_array );
   
    Redux::setSection( $opt_name_tc_ecommerce_app, array(
		'title' => __('App Styling', 'Theme Coder'),
		'id'     => 'app_styling',
		'icon' => 'el-icon-pencil',			
		'fields' => array (
			array (
				'id'       => 'home_style',
				'type'     => 'image_select',
				'title'    => __('Home Styles', 'Theme Coder'),
				'subtitle' => __( 'Please choose default home screen style.', 'Theme Coder' ),
				'options'  => array(
					'1'      => array(
						'alt'   => 'Home Style 1', 
						'title' => __( 'Home Style 1', 'Theme Coder' ),
						'img' => TCVC_PLUGIN_URL . '/assets/images/hs1.png'
					),
					'2'      => array(
						'alt'   => 'Home Style 2', 
						'title' => __( 'Home Style 2', 'Theme Coder' ),
						'img' => TCVC_PLUGIN_URL . '/assets/images/hs2.png'
					),
					'3'      => array(
						'alt'   => 'Home Style 3',
						'title' => __( 'Home Style 3', 'Theme Coder' ),
						'img' => TCVC_PLUGIN_URL . '/assets/images/hs3.png'
					),
					'4'      => array(
						'alt'   => 'Home Style 4',
						'title' => __( 'Home Style 4', 'Theme Coder' ),
						'img' => TCVC_PLUGIN_URL . '/assets/images/hs4.png'
					),
					'5'      => array(
						'alt'   => 'Home Style 5',
						'title' => __( 'Home Style 5', 'Theme Coder' ),
						'img' => TCVC_PLUGIN_URL . '/assets/images/hs5.png'
					),
					'6'      => array(
						'alt'   => 'Home Style 6',
						'title' => __( 'Home Style 6', 'Theme Coder' ),
						'img' => TCVC_PLUGIN_URL . '/assets/images/hs6.png'
					),
					'7'      => array(
						'alt'   => 'Home Style 7',
						'title' => __( 'Home Style 7', 'Theme Coder' ),
						'img' => TCVC_PLUGIN_URL . '/assets/images/hs7.png'
					),
					'8'      => array(
						'alt'   => 'Home Style 8',
						'title' => __( 'Home Style 8', 'Theme Coder' ),
						'img' => TCVC_PLUGIN_URL . '/assets/images/hs8.png'
					),
					'9'      => array(
						'alt'   => 'Home Style 9',
						'title' => __( 'Home Style 9', 'Theme Coder' ),
						'img' => TCVC_PLUGIN_URL . '/assets/images/hs9.png'
					),					
				),
				'default' => '1'
			),
		 )		 
	));
	
	Redux::setSection( $opt_name_tc_ecommerce_app, array(
		'title'      => __('Category Styles', 'Theme Coder'),
		'subsection' => true,			
		'fields'     => array (
			array (
				'id'       => 'category_style',
				'type'     => 'image_select',
				'title'    => __('Category Screen Styles', 'Theme Coder'),
				'subtitle' => __( 'Please choose default category screen style.', 'Theme Coder' ),
				'options'  => array(
					'1'      => array(
						'alt'   => 'Category Style 1', 
						'title' => __( 'Category Style 1', 'Theme Coder' ),
						'img' => TCVC_PLUGIN_URL . '/assets/images/cat1.png'
					),
					'2'      => array(
						'alt'   => 'Category Style 2', 
						'title' => __( 'Category Style 2', 'Theme Coder' ),
						'img' => TCVC_PLUGIN_URL . '/assets/images/cat2.png'
					),
					'3'      => array(
						'alt'   => 'Category Style 3',
						'title' => __( 'Category Style 3', 'Theme Coder' ),
						'img' => TCVC_PLUGIN_URL . '/assets/images/cat3.png'
					),
					'4'      => array(
						'alt'   => 'Category Style 4',
						'title' => __( 'Category Style 4', 'Theme Coder' ),
						'img' => TCVC_PLUGIN_URL . '/assets/images/cat4.png'
					),
					'5'      => array(
						'alt'   => 'Category Style 5',
						'title' => __( 'Category Style 5', 'Theme Coder' ),
						'img' => TCVC_PLUGIN_URL . '/assets/images/cat5.png'
					),
					'6'      => array(
						'alt'   => 'Category Style 6',
						'title' => __( 'Category Style 6', 'Theme Coder' ),
						'img' => TCVC_PLUGIN_URL . '/assets/images/cat6.png'
					),
				),
				'default' => '1'
			),
		 )		 
	));
	
	Redux::setSection( $opt_name_tc_ecommerce_app, array(
		'title'      => __('Banner Styles', 'Theme Coder'),
		'subsection' => true,			
		'fields'     => array (
			array (
				'id'       => 'banner_style',
				'type'     => 'image_select',
				'title'    => __('Banner  Styles', 'Theme Coder'),
				'subtitle' => __( 'Please choose default banner style.', 'Theme Coder' ),
				'options'  => array(
					'1'      => array(
						'alt'   => 'Banner Style 1', 
						'title' => __( 'Banner Style 1', 'Theme Coder' ),
						'img' => TCVC_PLUGIN_URL . '/assets/images/ban1.png'
					),
					'2'      => array(
						'alt'   => 'Banner Style 2', 
						'title' => __( 'Banner Style 2', 'Theme Coder' ),
						'img' => TCVC_PLUGIN_URL . '/assets/images/ban2.png'
					),
					'3'      => array(
						'alt'   => 'Banner Style 3',
						'title' => __( 'Banner Style 3', 'Theme Coder' ),
						'img' => TCVC_PLUGIN_URL . '/assets/images/ban3.png'
					),
					'4'      => array(
						'alt'   => 'Banner Style 4',
						'title' => __( 'Banner Style 4', 'Theme Coder' ),
						'img' => TCVC_PLUGIN_URL . '/assets/images/ban4.png'
					),
					'5'      => array(
						'alt'   => 'Banner Style 5',
						'title' => __( 'Banner Style 5', 'Theme Coder' ),
						'img' => TCVC_PLUGIN_URL . '/assets/images/ban5.png'
					),
					'6'      => array(
						'alt'   => 'Banner Style 6',
						'title' => __( 'Banner Style 6', 'Theme Coder' ),
						'img' => TCVC_PLUGIN_URL . '/assets/images/ban6.png'
					),
				),
				'default' => '1'
			),
		 )		 
	));
	
	Redux::setSection( $opt_name_tc_ecommerce_app, array(
		'title'      => __('Card Styles', 'Theme Coder'),
		'subsection' => true,			
		'fields'     => array (
			array (
				'id'       => 'card_style',
				'type'     => 'image_select',
				'title'    => __('Card Styles', 'Theme Coder'),
				'subtitle' => __( 'Please choose default card style.', 'Theme Coder' ),
				'options'  => array(
					'1'      => array(
						'alt'   => 'Card Style 1', 
						'title' => __( 'Card Style 1', 'Theme Coder' ),
						'img' => TCVC_PLUGIN_URL . '/assets/images/rcard-1.png'
					),
					'2'      => array(
						'alt'   => 'Card Style 2', 
						'title' => __( 'Card Style 2', 'Theme Coder' ),
						'img' => TCVC_PLUGIN_URL . '/assets/images/rcard-2.png'
					),
					'3'      => array(
						'alt'   => 'Card Style 3',
						'title' => __( 'Card Style 3', 'Theme Coder' ),
						'img' => TCVC_PLUGIN_URL . '/assets/images/rcard-3.png'
					),
					'4'      => array(
						'alt'   => 'Card Style 4',
						'title' => __( 'Card Style 4', 'Theme Coder' ),
						'img' => TCVC_PLUGIN_URL . '/assets/images/rcard-4.png'
					),
					'5'      => array(
						'alt'   => 'Card Style 5',
						'title' => __( 'Card Style 5', 'Theme Coder' ),
						'img' => TCVC_PLUGIN_URL . '/assets/images/rcard-5.png'
					),
					'6'      => array(
						'alt'   => 'Card Style 6',
						'title' => __( 'Card Style 6', 'Theme Coder' ),
						'img' => TCVC_PLUGIN_URL . '/assets/images/rcard-6.png'
					),
					'7'      => array(
						'alt'   => 'Card Style 7',
						'title' => __( 'Card Style 7', 'Theme Coder' ),
						'img' => TCVC_PLUGIN_URL . '/assets/images/rcard-7.png'
					),
					'8'      => array(
						'alt'   => 'Card Style 8',
						'title' => __( 'Card Style 8', 'Theme Coder' ),
						'img' => TCVC_PLUGIN_URL . '/assets/images/rcard-8.png'
					),
					'9'      => array(
						'alt'   => 'Card Style 9',
						'title' => __( 'Card Style 9', 'Theme Coder' ),
						'img' => TCVC_PLUGIN_URL . '/assets/images/rcard-9.png'
					),
					'10'      => array(
						'alt'   => 'Card Style 10',
						'title' => __( 'Card Style 10', 'Theme Coder' ),
						'img' => TCVC_PLUGIN_URL . '/assets/images/rcard-10.png'
					),
					'11'      => array(
						'alt'   => 'Card Style 11',
						'title' => __( 'Card Style 11', 'Theme Coder' ),
						'img' => TCVC_PLUGIN_URL . '/assets/images/rcard-11.png'
					),
					'12'      => array(
						'alt'   => 'Card Style 12',
						'title' => __( 'Card Style 12', 'Theme Coder' ),
						'img' => TCVC_PLUGIN_URL . '/assets/images/rcard-12.png'
					),
					'13'      => array(
						'alt'   => 'Card Style 13',
						'title' => __( 'Card Style 13', 'Theme Coder' ),
						'img' => TCVC_PLUGIN_URL . '/assets/images/rcard-13.png'
					),
					'14'      => array(
						'alt'   => 'Card Style 14',
						'title' => __( 'Card Style 14', 'Theme Coder' ),
						'img' => TCVC_PLUGIN_URL . '/assets/images/rcard-14.png'
					),
					'15'      => array(
						'alt'   => 'Card Style 15',
						'title' => __( 'Card Style 15', 'Theme Coder' ),
						'img' => TCVC_PLUGIN_URL . '/assets/images/rcard-15.png'
					),
					'16'      => array(
						'alt'   => 'Card Style 16',
						'title' => __( 'Card Style 16', 'Theme Coder' ),
						'img' => TCVC_PLUGIN_URL . '/assets/images/rcard-16.png'
					),
					'17'      => array(
						'alt'   => 'Card Style 17',
						'title' => __( 'Card Style 17', 'Theme Coder' ),
						'img' => TCVC_PLUGIN_URL . '/assets/images/rcard-17.png'
					),
					'18'      => array(
						'alt'   => 'Card Style 18',
						'title' => __( 'Card Style 18', 'Theme Coder' ),
						'img' => TCVC_PLUGIN_URL . '/assets/images/rcard-18.png'
					),
					'19'      => array(
						'alt'   => 'Card Style 19',
						'title' => __( 'Card Style 19', 'Theme Coder' ),
						'img' => TCVC_PLUGIN_URL . '/assets/images/rcard-19.png'
					),
					'20'      => array(
						'alt'   => 'Card Style 20',
						'title' => __( 'Card Style 20', 'Theme Coder' ),
						'img' => TCVC_PLUGIN_URL . '/assets/images/rcard-20.png'
					),
					'21'      => array(
						'alt'   => 'Card Style 21',
						'title' => __( 'Card Style 21', 'Theme Coder' ),
						'img' => TCVC_PLUGIN_URL . '/assets/images/rcard-21.png'
					),
					'22'      => array(
						'alt'   => 'Card Style 22',
						'title' => __( 'Card Style 22', 'Theme Coder' ),
						'img' => TCVC_PLUGIN_URL . '/assets/images/rcard-22.png'
					),
					'23'      => array(
						'alt'   => 'Card Style 23',
						'title' => __( 'Card Style 23', 'Theme Coder' ),
						'img' => TCVC_PLUGIN_URL . '/assets/images/rcard-23.png'
					),
					'24'      => array(
						'alt'   => 'Card Style 24',
						'title' => __( 'Card Style 24', 'Theme Coder' ),
						'img' => TCVC_PLUGIN_URL . '/assets/images/rcard-24.png'
					),
					'25'      => array(
						'alt'   => 'Card Style 25',
						'title' => __( 'Card Style 25', 'Theme Coder' ),
						'img' => TCVC_PLUGIN_URL . '/assets/images/rcard-25.png'
					),
					'26'      => array(
						'alt'   => 'Card Style 26',
						'title' => __( 'Card Style 26', 'Theme Coder' ),
						'img' => TCVC_PLUGIN_URL . '/assets/images/rcard-26.png'
					),
					'27'      => array(
						'alt'   => 'Card Style 27',
						'title' => __( 'Card Style 27', 'Theme Coder' ),
						'img' => TCVC_PLUGIN_URL . '/assets/images/rcard-27.png'
					),
				),
				'default' => '1'
			),
		 )		 
	));	
	
    Redux::setSection( $opt_name_tc_ecommerce_app, array(
        'title'  => __( 'General Settings', 'Theme Coder' ),
        'id'     => 'vc_general',
        'icon'   => 'el el-home',
        'fields' => array(
		
             array(
                'id'       => 'cancel_order_button',
                'type'     => 'select',
                'title'    => __( 'Cancel Orders Button', 'Theme Coder' ),
                'subtitle' => __( ' ', 'Theme Coder' ),
                'desc'     => __( 'Please choose show to display Cancel Order Button in Order History.', 'Theme Coder' ),
                'options'  => array(
                    '0' => 'Hide',
                    '1' => 'Show',
                ),
                'default'  => '0'
            ),
			
			 array(
                'id'       => 'cancel_order_hours',
                'type'     => 'select',
                'title'    => __( 'Cancel Orders Duration', 'Theme Coder' ),
                'subtitle' => __( ' ', 'Theme Coder' ),
                'desc'     => __( 'Please choose Hours in which user can cancel his order. ', 'Theme Coder' ),
                'options'  => array(
                    '1' => '1 Hour',
                    '2' => '2 Hours',
                    '3' => '3 Hours',
					'4' => '4 Hours',
                    '5' => '5 Hours',
                    '6' => '6 Hours',
					'7' => '7 Hours',
                    '8' => '8 Hours',
                ),
                'default'  => '1'
            ),			
			
			array(
                'id'       => 'package_name',
                'type'     => 'text',
                'title'    => __( 'IOS App Share', 'Theme Coder' ),
                'subtitle' => __( '', 'Theme Coder' ),
                'desc'     => __( 'Please enter URL to iOS share App.', 'Theme Coder' ),
                'default'  => 'Package Name',
            ),
			
			array(
                'id'       => 'site_url',
                'type'     => 'text',
                'title'    => __( 'Website URL', 'Theme Coder' ),
                'subtitle' => __( '', 'Theme Coder' ),
                'desc'     => __( 'Please enter your website URL.', 'Theme Coder' ),
                'default'  => 'http://domain-name.com/',
            ),		
			
			
			array(
                'id'       => 'new_product_duration',
                'type'     => 'text',
                'title'    => __( 'New Product Duration', 'Theme Coder' ),
                'subtitle' => __( '', 'Theme Coder' ),
                'desc'     => __( 'Please enter in days. e.g: 20. New tag will appear in product card for 20 days.', 'Theme Coder' ),
                'default'  => '20',
            ),
			
			array(
                'id'       => 'filter_max_price',
                'type'     => 'text',
                'title'    => __( 'Product Filter Max Price', 'Theme Coder' ),
                'subtitle' => __( '', 'Theme Coder' ),
                'desc'     => __( 'Please enter price of your most expensive item of your store. e.g: 1000.' ),
                'default'  => '1000',
            ),			
			
			array(
                'id'       => 'update_order',
                'type'     => 'text',
				'hidden' => 'true',
                'title'    => __( 'Save Order', 'Theme Coder' ),
                'subtitle' => __( '', 'Theme Coder' ),
                'desc'     => __( 'Do not Enter anything' ),
				'validate_callback' => 'callback_function_update_order',
                'default'  => '1',
            ),	
        )
    ) );
	
	
	
	Redux::setSection( $opt_name_tc_ecommerce_app, array(
        'title'      => __( 'Checkout Settings', 'Theme Coder' ),
        'id'         => 'vc_checkout',
        'subsection' => false,
		'icon'   => 'el el-ok-sign',
        'fields'     => array( 

            array(
                'id'       => 'one_page_checkout',
                'type'     => 'select',
                'title'    => __( 'Checkout Type', 'Theme Coder' ),
                'subtitle' => __( ' ', 'Theme Coder' ),
                'desc'     => __( '- When we select Virtual Products / One Page Checkout then billing, shipping and shipping methods screens will be hide.<br />
                        - When we select "Checkout screen in app" the checkout screen will appear in application. <br /> - WooCommerce points & reward plugin not compatible with Checkout screen in app', 'Theme Coder' ),
                'options'  => array(
                    '0' => 'Default',
                    '1' => ' For Virtual Products / One Page Checkout',
                    '2' => ' Checkout Screen in App',
                ),
                'default'  => '0'
            ),
			
            array(
                'id'       => 'checkout_process',
                'type'     => 'select',
                'title'    => __( 'Enable Guest Checkout', 'Theme Coder' ),
                'subtitle' => __( '', 'Theme Coder' ),
				'desc'     => __('Allows customers to checkout without creating an account.'),
                'options'  => array( 'yes' => 'Yes', 'no' => 'No' ),
                'default'  => 'no',
            ),
			
			array(
                'id'       => 'custom_css_for_checkout',
                'type'     => 'textarea',
                'title'    => __( 'Custom CSS for Checkout Page', 'Theme Coder' ),
                'subtitle' => __( '', 'Theme Coder' ),
                'desc'     => __( 'Use for hide header, footer and anything else for checkout page. It will effect only on mobile checkout screen. Desktop website & responsive view will not effect..', 'Theme Coder' ),
                'validate' => 'no_html',
                'default'  => '.site-header, nav, #secondary, footer {display: none!important;} '
            ),           
        )
    ) );
	
	
	
	
	
	
	
	
	 Redux::setSection( $opt_name_tc_ecommerce_app, array(
        'title'  => __( 'Contact Page Settings ', 'Theme Coder' ),
        'id'     => 'vc_contact_info',
        'icon'   => 'el el-phone-alt',
        'fields' => array(            
			
			array(
                'id'       => 'contact_us_email',
                'type'     => 'text',
                'title'    => __( 'Contact Us Email', 'Theme Coder' ),
                'subtitle' => __( '', 'Theme Coder' ),
                'desc'     => __( 'It will use for contact us form in application.', 'Theme Coder' ),
                'default'  => 'info@domain-name.com',
            ),
			
			array(
                'id'       => 'from_email',
                'type'     => 'text',
                'title'    => __( 'From Email', 'Theme Coder' ),
                'subtitle' => __( '', 'Theme Coder' ),
                'desc'     => __( 'It will use for contact us from mail address in application.', 'Theme Coder' ),
                'default'  => 'from@domain-name.com',
            ),
			
			array(
                'id'       => 'phone_no',
                'type'     => 'text',
                'title'    => __( 'Phone Number Symbol', 'Theme Coder' ),
                'subtitle' => __( '', 'Theme Coder' ),
                'desc'     => __( 'User will be able to contact to you via this phone number.', 'Theme Coder' ),
                'default'  => '+92 123 456-789',
            ),
			
			array(
                'id'       => 'address',
                'type'     => 'text',
                'title'    => __( 'Address', 'Theme Coder' ),
                'subtitle' => __( '', 'Theme Coder' ),
                'desc'     => __( 'Please enter your address.', 'Theme Coder' ),
                'default'  => '228 Park avs',
            ),
			
			array(
                'id'       => 'city',
                'type'     => 'text',
                'title'    => __( 'City', 'Theme Coder' ),
                'subtitle' => __( '', 'Theme Coder' ),
                'desc'     => __( 'Please enter your city.' , 'Theme Coder'),
                'default'  => 'New York',
            ),	
			
			array(
                'id'       => 'state',
                'type'     => 'text',
                'title'    => __( 'state', 'Theme Coder' ),
                'subtitle' => __( '', 'Theme Coder' ),
                'desc'     => __( 'Please enter your state.', 'Theme Coder' ),
                'default'  => 'NY',
            ),	
			
			array(
                'id'       => 'Zip',
                'type'     => 'text',
                'title'    => __( 'zip', 'Theme Coder' ),
                'subtitle' => __( '', 'Theme Coder' ),
                'desc'     => __( 'Please enter your zip.', 'Theme Coder' ),
                'default'  => '10003',
            ),	
			
			array(
                'id'       => 'Country',
                'type'     => 'text',
                'title'    => __( 'country', 'Theme Coder' ),
                'subtitle' => __( '', 'Theme Coder' ),
                'desc'     => __( 'Please enter your country.', 'Theme Coder' ),
                'default'  => 'USA',
            ),
			
			array(
                'id'       => 'Latitude',
                'type'     => 'text',
                'title'    => __( 'latitude', 'Theme Coder' ),
                'subtitle' => __( '', 'Theme Coder' ),
                'desc'     => __( 'Please enter your latitude for map.', 'Theme Coder' ),
                'default'  => '40.730610',
            ),
			
			array(
                'id'       => 'Longitude',
                'type'     => 'text',
                'title'    => __( 'longitude', 'Theme Coder' ),
                'subtitle' => __( '', 'Theme Coder' ),
                'desc'     => __( 'Please enter your longitude for map.', 'Theme Coder' ),
                'default'  => '-73.935242',
            ),	
			
        )
    ) );
	
	Redux::setSection( $opt_name_tc_ecommerce_app, array(
        'title'      => __( 'Sidebar Menu Links', 'Theme Coder' ),
        'id'         => 'vc_sidebar_menu',
        'subsection' => false,
		'icon'       => 'el el-link',
        'fields'     => array(

            array(
                'id'       => 'sidebar_menu_icon',
                'type'     => 'select',
                'title'    => __( 'Sidebar Menu Icon', 'Theme Coder' ),
                'subtitle' => __( '', 'Theme Coder' ),
                'desc'     => __( 'Please choose sidebar menu icon is default(Ionic icon) or use PNG Image(Custom).', 'Theme Coder' ),
                'options'  => array(
                    '0' => ' Default (Ionic)',
                    '1' => ' PNG Image (Custom)',
                ),
                'default'  => '0'
            ),
			
			array(
                'id'       => 'wish_list_page',
                'type'     => 'select',
                'title'    => __( 'WishList', 'Theme Coder' ),
                'subtitle' => __( '', 'Theme Coder' ),
                'desc'     => __( 'Please choose show to display wishlist page.', 'Theme Coder' ),
                'options'  => array(
                    '0' => 'Hide',
                    '1' => 'Show',
                ),
                'default'  => '0'
            ),
			
			array(
                'id'       => 'edit_profile_page',
                'type'     => 'select',
                'title'    => __( 'Edit Profile', 'Theme Coder' ),
                'subtitle' => __( '', 'Theme Coder' ),
                'desc'     => __( 'Please choose show to display Edit Profile page. ', 'Theme Coder' ),
                'options'  => array(
                    '0' => 'Hide',
                    '1' => 'Show',
                ),
                'default'  => '0'
            ),
			
			array(
                'id'       => 'shipping_address_page',
                'type'     => 'select',
                'title'    => __( 'Shipping Address', 'Theme Coder' ),
                'subtitle' => __( '', 'Theme Coder' ),
                'desc'     => __( 'Please choose show to display Shipping Address page. ', 'Theme Coder' ),
                'options'  => array(
                    '0' => 'Hide',
                    '1' => 'Show',
                ),
                'default'  => '0'
            ),
			
			array(
                'id'       => 'my_orders_page',
                'type'     => 'select',
                'title'    => __( 'My Orders', 'Theme Coder' ),
                'subtitle' => __( '', 'Theme Coder' ),
                'desc'     => __( 'Please choose show to display My Orders page. ', 'Theme Coder' ),
                'options'  => array(
                    '0' => 'Hide',
                    '1' => 'Show',
                ),
                'default'  => '0'
            ),
			
			array(
                'id'       => 'contact_us_page',
                'type'     => 'select',
                'title'    => __( 'Contact Us', 'Theme Coder' ),
                'subtitle' => __( '', 'Theme Coder' ),
                'desc'     => __( 'Please choose show to display Contact Us page. ', 'Theme Coder' ),
                'options'  => array(
                    '0' => 'Hide',
                    '1' => 'Show',
                ),
                'default'  => '0'
            ),
			
			array(
                'id'       => 'about_us_page',
                'type'     => 'select',
                'title'    => __( 'About Us', 'Theme Coder' ),
                'subtitle' => __( '', 'Theme Coder' ),
                'desc'     => __( 'Please choose show to display About Us page. ', 'Theme Coder' ),
                'options'  => array(
                    '0' => 'Hide',
                    '1' => 'Show',
                ),
                'default'  => '0'
            ),
			
			array(
                'id'       => 'bill_ship_info',
                'type'     => 'select',
                'title'    => __( 'Billing Shipping Info', 'Theme Coder' ),
                'subtitle' => __( '', 'Theme Coder' ),
                'desc'     => __( 'Please choose show to display Billing Shipping Info. ', 'Theme Coder' ),
                'options'  => array(
                    '0' => 'Hide',
                    '1' => 'Show',
                ),
                'default'  => '0'
            ),
			
			array(
                'id'       => 'downloads',
                'type'     => 'select',
                'title'    => __( 'Downloads', 'Theme Coder' ),
                'subtitle' => __( '', 'Theme Coder' ),
                'desc'     => __( 'Please choose show to display downloads. ', 'Theme Coder' ),
                'options'  => array(
                    '0' => 'Hide',
                    '1' => 'Show',
                ),
                'default'  => '0'
            ),
			
			array(
                'id'       => 'news_page',
                'type'     => 'select',
                'title'    => __( 'News', 'Theme Coder' ),
                'subtitle' => __( '', 'Theme Coder' ),
                'desc'     => __( 'Please choose show to display News page. ', 'Theme Coder' ),
                'options'  => array(
                    '0' => 'Hide',
                    '1' => 'Show',
                ),
                'default'  => '0'
            ),
			
			array(
                'id'       => 'intro_page',
                'type'     => 'select',
                'title'    => __( 'Introduction', 'Theme Coder' ),
                'subtitle' => __( '', 'Theme Coder' ),
                'desc'     => __( 'Please choose show to display Introduction page.', 'Theme Coder' ),
                'options'  => array(
                    '0' => 'Hide',
                    '1' => 'Show',
                ),
                'default'  => '0'
            ),
			
			array(
                'id'       => 'share_app',
                'type'     => 'select',
                'title'    => __( 'ShareApp', 'Theme Coder' ),
                'subtitle' => __( '', 'Theme Coder' ),
                'desc'     => __( 'Please choose show to display ShareApp.', 'Theme Coder' ),
                'options'  => array(
                    '0' => 'Hide',
                    '1' => 'Show',
                ),
                'default'  => '0'
            ),
			
			array(
                'id'       => 'rate_app',
                'type'     => 'select',
                'title'    => __( 'RateApp', 'Theme Coder' ),
                'subtitle' => __( '', 'Theme Coder' ),
                'desc'     => __( 'Please choose show to display RateApp.', 'Theme Coder' ),
                'options'  => array(
                    '0' => 'Hide',
                    '1' => 'Show',
                ),
                'default'  => '0'
            ),
			
			array(
                'id'       => 'setting_page',
                'type'     => 'select',
                'title'    => __( 'Setting', 'Theme Coder' ),
                'subtitle' => __( '', 'Theme Coder' ),
                'desc'     => __( 'Please choose show to display Setting page.', 'Theme Coder' ),
                'options'  => array(
                    '0' => 'Hide',
                    '1' => 'Show',
                ),
                'default'  => '0'
            ),
			
           
        )
    ) );
	
	
	Redux::setSection( $opt_name_tc_ecommerce_app, array(
        'title'      => __( 'Local Notification', 'Theme Coder' ),
        'id'         => 'vc_local_notification',
        'subsection' => false,
		'icon'       => 'el el-hand-right',
        'fields'     => array(
		
			array(
                'id'       => 'notification_title',
                'type'     => 'text',
                'title'    => __( 'Title', 'Theme Coder' ),
                'subtitle' => __( '', 'Theme Coder' ),
                'desc'     => __( 'ocal Notification Title.', 'Theme Coder' ),
                'default'  => 'Theme Coder',
            ),
			
			array(
                'id'       => 'notification_text',
                'type'     => 'text',
                'title'    => __( 'Detail', 'Theme Coder' ),
                'subtitle' => __( '', 'Theme Coder' ),
                'desc'     => __( 'Local Notification Detail.', 'Theme Coder' ),
                'default'  => 'A bundle of products wating for you!',
            ),

            array(
                'id'       => 'notification_duration',
                'type'     => 'select',
                'title'    => __( 'Notification Duration', 'Theme Coder' ),
                'subtitle' => __( '', 'Theme Coder' ),
                'desc'     => __( 'Please select duration for local notification.', 'Theme Coder' ),
                'options'  => array(
                    '0' => 'Hide',
                    '1' => 'Show',
                ),
                'default'  => '0'
            ),
			
	 )
    ) );
	
	Redux::setSection( $opt_name_tc_ecommerce_app, array(
        'title'      => __( 'Facbook Login', 'Theme Coder' ),
        'id'         => 'vc_facebook_login',
        'subsection' => false,
		'icon'  => 'el el-facebook',
        'fields'     => array(			

            array(
                'id'       => 'facebook_login',
                'type'     => 'select',
                'title'    => __( 'Facbook Login', 'Theme Coder' ),
                'subtitle' => __( '', 'Theme Coder' ),
                'desc'     => __( 'Select Show Facbook Login.', 'Theme Coder' ),
                'options'  => array(
                    '0' => 'Hide',
                    '1' => 'Show',
                ),
                'default'  => '0'
            ),
			
	 )
    ) );
	
		
	
	
	Redux::setSection( $opt_name_tc_ecommerce_app, array(
        'title'      => __( 'App Content Pages ', 'Theme Coder' ),
        'id'         => 'vc_content_pages',
        'subsection' => false,
		'icon'       => 'el el-font',
        'fields'     => array(
		
						
			array(
                'id'      => 'about_page_id',
                'type'    => 'text',
                'title'   => __( 'About Us Page ID', 'Theme Coder' ),
                'subtitle' => __( '', 'Theme Coder' ),
                'desc'     => __( 'Please Create about us page for app and put page id here.', 'Theme Coder' ),
                'default'  => '',
            ),		
			
			
			array(
                'id'      => 'refund_page_id',
                'type'    => 'text',
                'title'   => __( 'Refund Page ID', 'Theme Coder' ),
                'subtitle' => __( '', 'Theme Coder' ),
                'desc'     => __( 'Please Create refund page for app and put page id here.', 'Theme Coder' ),
                'default'  => '',
            ),
			
			array(
                'id'      => 'privacy_page_id',
                'type'    => 'text',
                'title'   => __( 'Privacy Page ID', 'Theme Coder' ),
                'subtitle' => __( '', 'Theme Coder' ),
                'desc'     => __( 'Please Create privacy policy page for app and put page id here.', 'Theme Coder' ),
                'default'  => '',
            ),
			
			array(
                'id'      => 'terms_page_id',
                'type'    => 'text',
                'title'   => __( 'Terms Page ID', 'Theme Coder' ),
                'subtitle' => __( '', 'Theme Coder' ),
                'desc'     => __( 'Please Create terms &  condition page for app and put page id here.', 'Theme Coder' ),
                'default'  => '',
            ),
	 	)
    ) );
	
	
	Redux::setSection( $opt_name_tc_ecommerce_app, array(
        'title'      => __( 'WPML (Multi Language)', 'Theme Coder' ),
        'id'         => 'vc_wpml',
        'subsection' => false,
		'icon'       => 'el el-time',
        'fields'     => array(
		
		array(
                'id'       => 'wpml_enabled',
                'type'     => 'select',
                'title'    => __( 'Implement WPML in app', 'Theme Coder' ),
                'subtitle' => __( ' ', 'Theme Coder' ),
                'desc'     => __( 'Please select "Yes" after installation & activation the WPML Plugin in your wordpress site.', 'Theme Coder' ),
                'options'  => array(
                    '0' => 'No',
                    '1' => 'Yes',
                ),
                'default'  => '0'
            ),
	
		)
    ) );
	
	Redux::setSection( $opt_name_tc_ecommerce_app, array(
        'title'      => __( 'Multi Vendor', 'Theme Coder' ),
        'id'         => 'vc_multi_vendor',
        'subsection' => false,
		'icon'       => 'el el-tags',
        'fields'     => array(
		
		array(
                'id'       => 'mvf_enabled',
                'type'     => 'select',
                'title'    => __( 'Implement Multi Vendor Feature ', 'Theme Coder' ),
                'subtitle' => __( ' ', 'Theme Coder' ),
                'desc'     => __( 'Please select "Yes" after installation & activation the "dokan" or "WC Vendor" Plugin in your wordpress site.<br /> - WooCommerce  points & reward plugin not compatible with VC Vendor and dokan plugin ', 'Theme Coder' ),
                'options'  => array(
                    '0' => 'No',
                    '1' => 'Dukan',
					'2' => 'WC Vendor',
					'3' => 'WCFM Market',
                ),
                'default'  => '0'
            ),
	
		)
    ) );
	
	Redux::setSection( $opt_name_tc_ecommerce_app, array(
        'title'      => __( 'WC Points & Reward', 'Theme Coder' ),
        'id'         => 'vc_point_reward',
        'subsection' => false,
		'icon'       => 'el el-tint',
        'fields'     => array(
		
		array(
                'id'       => 'wp_point_reward',
                'type'     => 'select',
                'title'    => __( 'Implement Points & Rewards', 'Theme Coder' ),
                'subtitle' => __( ' ', 'Theme Coder' ),
                'desc'     => __( 'Please select "Yes" after installation & activation the woocommerce points & rewards Plugin in your wordpress site.', 'Theme Coder' ),
                'options'  => array(
                    '0' => 'No',
                    '1' => 'Yes',
                ),
                'default'  => '0'
            ),
	
		)
    ) );
	
	Redux::setSection( $opt_name_tc_ecommerce_app, array(
        'title'      => __( 'Multi Currency', 'Theme Coder' ),
        'id'         => 'vc_multi_currency',
        'subsection' => false,
		'icon'       => 'el el-usd',
        'fields'     => array(
		
		array(
                'id'       => 'wp_multi_currency',
                'type'     => 'select',
                'title'    => __( 'Implement Multiple currency', 'Theme Coder' ),
                'subtitle' => __( ' ', 'Theme Coder' ),
                'desc'     => __( 'Please select "Yes" after installation & activation the WooCommerce Currency Switcher Plugin in your wordpress site.', 'Theme Coder' ),
                'options'  => array(
                    '0' => 'No',
                    '1' => 'Yes',
                ),
                'default'  => '0'
            ),
	
		)
    ) );
	
	Redux::setSection( $opt_name_tc_ecommerce_app, array(
        'title'      => __( 'Delivery Tracking', 'Theme Coder' ),
        'id'         => 'vc_delivery_tracking',
        'subsection' => false,
		'icon'       => 'el el-record',
        'fields'     => array(
		
		array(
                'id'       => 'delivery_tracking',
                'type'     => 'select',
                'title'    => __( 'Enable Delivery Tracking', 'Theme Coder' ),
                'subtitle' => __( ' ', 'Theme Coder' ),
                'desc'     => __( 'Please select "Yes" if after installation & activation Woocommerce AfterShip plugin in your wordpress site.', 'Theme Coder' ),
                'options'  => array(
                    '0' => 'No',
                    '1' => 'Yes',
                ),
                'default'  => '0'
            ),

		array(
                'id'       => 'tracking_url',
                'type'     => 'text',
                'title'    => __( 'Tracking URL', 'Theme Coder' ),
                'subtitle' => __( '', 'Theme Coder' ),
                'desc'     => __( 'Please enter your tracking URL.', 'Theme Coder' ),
                'default'  => 'http://urltracking.com/',
            ),


	
		)
    ) );


	Redux::setSection( $opt_name_tc_ecommerce_app, array(
        'title'      => __( 'GEO Fencing', 'Theme Coder' ),
        'id'         => 'vc_geo_fencing',
        'subsection' => false,
		'icon'       => 'el el-record',
        'fields'     => array(		
		array(
                'id'       => 'geo_fencing',
                'type'     => 'select',
                'title'    => __( 'Enable GEO Fencing', 'Theme Coder' ),
                'subtitle' => __( ' ', 'Theme Coder' ),
                'desc'     => __( 'Please select "Yes" if you enable notification for nearest store available.', 'Theme Coder' ),
                'options'  => array(
                    '0' => 'No',
                    '1' => 'Yes',
                ),
                'default'  => '0'
            ),	
		)
    ) );


 	Redux::setSection( $opt_name_tc_ecommerce_app, array(
        'title'      => __( 'One Signal Notification', 'Theme Coder' ),
        'id'         => 'vc_one_signal',
        'subsection' => false,
		'icon'       => 'el el-record',
        'fields'     => array(		
		array(
                'id'       => 'one_signal_notification',
                'type'     => 'select',
                'title'    => __( 'Enable One Signal Notification', 'Theme Coder' ),
                'subtitle' => __( ' ', 'Theme Coder' ),
                'desc'     => __( 'Please Enable if you want to send coupon notification.', 'Theme Coder' ),
                'options'  => array(
                    '0' => 'No',
                    '1' => 'Yes',
                ),
                'default'  => '0'
            ),

			
			array(
                'id'       => 'one_signal_app_id',
                'type'     => 'text',
                'title'    => __( 'One Signal App ID', 'Theme Coder' ),
                'subtitle' => __( '', 'Theme Coder' ),
                'desc'     => __( 'Please enter your One Signal App ID.', 'Theme Coder' ),
				'placeholder'=> '02a78165-197f-46f7-929e-8f2bbb1b1253',
                'default'  => '',
            ),

				array(
                'id'       => 'one_signal_app_key',
                'type'     => 'text',
                'title'    => __( 'One Signal App Key', 'Theme Coder' ),
                'subtitle' => __( '', 'Theme Coder' ),
                'desc'     => __( 'Please enter your One Signal App Key.', 'Theme Coder' ),
				'placeholder'=> 'MGJjNDQ1MTYtNDhmOC00ZWYzLWIyMzQtNmI5OWE4ZTA0Mjgx',
                'default'  => '',
            ),

	
		)
    ) );

 if ( ! function_exists( 'callback_function_update_order' ) ) {
        function callback_function_update_order( $field, $value, $existing_value ) {
            $error   = false;
            $warning = false;

            if ( $value >= 1 ) {
                $value = $existing_value+1;
            } 
            $return['value'] = $value;           
            return $return;
        }
    }	
   ?>