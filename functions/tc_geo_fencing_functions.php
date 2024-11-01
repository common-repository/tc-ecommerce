<?php 
if( ! function_exists( 'tc_app_custom_posttype_geo_fencing' ) ) {
	function tc_app_custom_posttype_geo_fencing() {
	 
		$labels = array(
			'name'                => _x( 'Geo Fencing', 'Post Type General Name', 'android-ecommerce' ),
			'singular_name'       => _x( 'Geo Fencing', 'Post Type Singular Name', 'android-ecommerce' ),
			'menu_name'           => __( 'Geo Fencing', 'android-ecommerce' ),
			'all_items'           => __( 'All Fencing Data', 'android-ecommerce' ),
			'view_item'           => __( 'View Geo Fencing', 'android-ecommerce' ),
			'add_new_item'        => __( 'Add New Geo Fencing', 'android-ecommerce' ),
			'add_new'             => __( 'Add New', 'android-ecommerce' ),
			'edit_item'           => __( 'Edit Geo Fencing', 'android-ecommerce' ),
			'update_item'         => __( 'Update Geo Fencing', 'android-ecommerce' ),
			'search_items'        => __( 'Search Geo Fencing', 'android-ecommerce' ),
			'not_found'           => __( 'Not Found', 'android-ecommerce' ),
			'not_found_in_trash'  => __( 'Not found in Trash', 'android-ecommerce' ),
		);
	
		 
		$args = array(
			'labels'              => $labels,
			'supports'            => array( 'title', 'editor', 'author',),
			'label'               => __( 'Geo Fencing', 'android-ecommerce' ),
			'description'         => __( 'Geo Fencing notification for nearest store', 'android-ecommerce' ),        
			'taxonomies'          => array( 'genres' ),
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => true,
			'show_in_admin_bar'   => true,
			'menu_position'       => 5,
			'can_export'          => true,
			'has_archive'         => true,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'capability_type'     => 'post',
			'register_meta_box_cb' => 'wpt_androidecommerce_geo_fencing_metaboxes',
		);
	
		register_post_type( 'geofencing', $args ); 
	} 
	
	add_action( 'init', 'tc_app_custom_posttype_geo_fencing', 0 );
	
	function wpt_androidecommerce_geo_fencing_metaboxes() {
		add_meta_box('wpt_ae_gf_latitude',  'Latitude',  'wpt_ae_gf_latitude_function',  'geofencing', 'side', 'default');
		add_meta_box('wpt_ae_gf_longitude', 'Longitude', 'wpt_ae_gf_longitude_function', 'geofencing', 'side', 'default');
		add_meta_box('wpt_ae_gf_radius',    'Radius',    'wpt_ae_gf_radius_function',    'geofencing', 'side' ,'default');
	}
	
	function wpt_ae_gf_latitude_function() {
		global $post;
		$ae_gf_latitude = get_post_meta( $post->ID, 'ae_gf_latitude', true );
		echo '<input type="text" name="ae_gf_latitude" value="' . esc_attr( $ae_gf_latitude )  . '" class="widefat">';
	}
	
	function wpt_ae_gf_longitude_function() {
		global $post;
		$ae_gf_longitude = get_post_meta( $post->ID, 'ae_gf_longitude', true );
		echo '<input type="text" name="ae_gf_longitude" value="' . esc_attr( $ae_gf_longitude )  . '" class="widefat">';
	}
	
	function wpt_ae_gf_radius_function() {
		global $post;
		wp_nonce_field( basename( __FILE__ ), 'geofencing_fields' );
		$ae_gf_radius = get_post_meta( $post->ID, 'ae_gf_radius', true );
		echo '<input type="text" name="ae_gf_radius" value="' . esc_attr( $ae_gf_radius )  . '" class="widefat">';
	}
	
	add_action( 'add_meta_boxes', 'wpt_androidecommerce_geo_fencing_metaboxes' );
	
	function wpt_save_androidecommerce_cf_fata( $post_id, $post ) {
		
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return $post_id;
		}
		
		if ( ! isset( $_POST['geofencing_fields'] ) || ! wp_verify_nonce( $_POST['geofencing_fields'], basename(__FILE__) ) ) {
			return $post_id;
		}
	
	    $ae_gf_meta['ae_gf_latitude']   = sanitize_text_field( $_POST['ae_gf_latitude'] );
		$ae_gf_meta['ae_gf_longitude']  = sanitize_text_field( $_POST['ae_gf_longitude'] );
		$ae_gf_meta['ae_gf_radius'] 	= sanitize_text_field( $_POST['ae_gf_radius'] );	
	
		foreach ( $ae_gf_meta as $key => $value ) :
			if ( 'revision' === $post->post_type ) {
				return;
			}
			if ( get_post_meta( $post_id, $key, false ) ) {
				update_post_meta( $post_id, $key, $value );
			} else {
				add_post_meta( $post_id, $key, $value);
			}
			if ( ! $value ) {
				delete_post_meta( $post_id, $key );
			}
		endforeach;
	}
	
	add_action( 'save_post', 'wpt_save_androidecommerce_cf_fata', 1, 2 );
}
?>